<div class="container mx-auto px-4 pt-20">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Корзина</h1>

    <div class="bg-white shadow-lg overflow-x-auto rounded-xl">
        <table class="w-full text-left">
            <thead class="bg-gray-100 border-b-2">
                <tr>
                    <th class="px-4 py-3 text-gray-600 font-semibold">Товар</th>
                    <th class="px-4 py-3 text-gray-600 font-semibold">Цена</th>
                    <th class="px-4 py-3 text-gray-600 font-semibold">Количество</th>
                    <th class="px-4 py-3 text-gray-600 font-semibold">Итого</th>
                    <th class="px-4 py-3 text-gray-600 font-semibold"></th>
                </tr>
            </thead>
            <tbody id="table" class="w-full text-left"></tbody>
        </table>
    </div>

    <div class="mt-6 bg-white shadow-lg rounded-lg p-4">
        <div class="flex justify-between items-center">
            <span class="text-gray-700 text-xl font-bold">Общая стоимость:</span>
            <div class="text-right space-x-4 space-y-2">
                <span id="total-amount" class="text-gray-900 text-2xl font-bold">0 ₽</span>
                <button id="order-btn" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold">
                    Оформить заказ
                </button>
            </div>
        </div>
    </div>
</div>
<script src="/static/cart.js"></script>