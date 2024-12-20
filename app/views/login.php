<div class="flex items-center justify-center h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-md mb-16">
        <h2 class="text-3xl font-bold text-center mb-10">Авторизация</h2>

        <div id="label" class="text-white font-bold text-center mb-4 py-2 px-2 rounded hidden"></div>

        <div class="mb-6">
            <label for="email" class="text-sm font-medium text-gray-700">Логин</label>
            <input type="text" id="login" required
                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500"
                placeholder="Введите логин">
        </div>

        <div class="mb-6">
            <label for="password" class="text-sm font-medium text-gray-700">Пароль</label>
            <input type="password" id="password" required
                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500"
                placeholder="Введите пароль">
        </div>

        <button id="submit-btn"
            class="w-full bg-blue-600 rounded-lg text-white py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
            Войти
        </button>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
<script src="/static/auth.js"></script>
<script src="/static/login.js"></script>