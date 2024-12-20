// Запрос на бэк для авторизации пользователя (сверка хеша)
const verifyHash = async Hs => {
    const resp = await fetch("/auth/verifyHash", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ Hs: Hs })
    });
    return await resp.json();
}

async function login() {
    // Получение данных из полей "логин" и "пароль"
    const login = loginField.value;
    const password = passwordField.value;

    // Вычисление хеша по формуле
    const { H, Hs } = await getHash(login, password);

    console.log("H: ", H);

    const { success, message } = await verifyHash(Hs);
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
button.addEventListener("click", login);