// Запрос на бэк для регистрации пользователя
const registerUser = async (H, Hs) => {
    const resp = await fetch("/auth/registerUser", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ H: H, Hs: Hs })
    });
    return await resp.json();
}

const register = async () => {
    // Получение данных из полей "логин" и "пароль"
    const login = loginField.value;
    const password = passwordField.value;

    // Вычисление хеша по формуле
    const { H, Hs } = await getHash(login, password);

    // Запрос на регистрацию пользователя
    const { success, message } = await registerUser(H, Hs);

    // Вывод сообщения от сервера пользователю,
    // редирект на главную при успехе
    label.classList.remove("hidden");
    label.innerHTML = message;

    if (success) {
        label.classList.add("bg-green-500");
        document.location.href = "/";
    } else {
        label.classList.add("bg-red-400");
    }
}

// Привязка функции к событию нажатия на кнопку
button.addEventListener("click", register);