// Получение элементов полей ввода, кнопки регистрации/авторизации
// и появляющегося поля для вывода сообщения от сервера
const loginField = document.querySelector("#login");
const passwordField = document.querySelector("#password");
const button = document.querySelector("#submit-btn");
const label = document.querySelector("#label");

// Запрос на бэк для получения соли и случайного challenge
const getSaltChallenge = async login => {
    const respSaltChal = await fetch("/auth/getSaltChallenge", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ login: login })
    });
    return await respSaltChal.json();
}

// Функция хеширования
const hash = (...strings) => {
    return CryptoJS.SHA256(strings.join("")).toString();
}

// Вычислить H и Hs по логину и паролю
const getHash = async (login, password) => {
    // получение соли и хеша
    const { salt, challenge } = await getSaltChallenge(login);

    // вычисление хеша по формуле
    const H = hash(salt + password);
    const Hs = hash(H + challenge);

    return { H, Hs }
}