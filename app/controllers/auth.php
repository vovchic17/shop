<?php

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new AuthModel();
    }

    /**
     * Страница регистрации
     */
    public function register()
    {
        $this->view->render("Регистрация", "register");
    }

    /**
     * Страница авторизации
     */
    public function login()
    {
        $this->view->render("Авторизация", "login");
    }

    /**
     * Выход из аккаунта | закончить сессию
     */
    public function logout()
    {
        $_SESSION = [];
        $newUrl = str_replace("logout", "login", $_SERVER["REQUEST_URI"]);
        header("Location: $newUrl");
    }

    /**
     * Получить salt для login и случайный challenge
     */
    public function getSaltChallenge()
    {
        $data = json_decode(file_get_contents('php://input'));
        $salt = $this->model->getUserSalt($data->login) ??
            hash("sha256", $data->login);
        $username = $data->login;
        $challenge = bin2hex(random_bytes(16));
        $_SESSION = compact(["salt", "challenge", "username"]);
        $response = compact("salt", "challenge");
        header("Content-Type: application/json");
        echo json_encode($response);
    }

    /**
     * Вычисление Hs и сравнение его с клиентским Hs
     * В случае соответствия создаётся пользователь
     */
    public function registerUser()
    {
        $data = json_decode(file_get_contents('php://input'));
        $challenge = $_SESSION["challenge"];
        $Hs = hash("sha256", $data->H . $challenge);
        header("Content-Type: application/json");

        if ($Hs !== $data->Hs) {
            echo json_encode([
                "success" => false,
                "message" => "salt клиента не соответствует salt сервера"
            ]);
            exit();
        }
        try {
            $username = $_SESSION["username"];
            $this->model->createUser(
                $username,
                $_SESSION["salt"],
                $data->H
            );
            $_SESSION = [
                "user" => $username,
                "id" => $this->model->getUserId($username)
            ];
            echo json_encode([
                "success" => true,
                "message" => "Пользователь создан"
            ]);
            exit();
        } catch (PDOException $e) {
            echo json_encode([
                "success" => false,
                "message" => "Такой пользователь уже существует"
            ]);
        }
    }

    /**
     * Вычисление Hs и сравнение его с клиентским Hs
     * В случае соответствия выполняется авторизация
     */
    public function verifyHash()
    {
        $data = json_decode(file_get_contents('php://input'));
        $challenge = $_SESSION["challenge"];
        $username = $_SESSION["username"];
        $H = $this->model->getUserHash($username);
        $Hs = hash("sha256", $H . $challenge);
        $success = $data->Hs === $Hs;
        if ($success)
            $_SESSION = [
                "user" => $username,
                "id" => $this->model->getUserId($username)
            ];
        header("Content-Type: application/json");
        echo json_encode([
            "success" => $success,
            "message" => $success ?
                "Авторизация прошла успешно" :
                "Неверный логин или пароль"
        ]);
    }
}