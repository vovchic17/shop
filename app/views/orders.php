<div class="container mx-auto px-4 pt-20">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">История заказов</h1>

    <div class="bg-white shadow-lg overflow-x-auto rounded-xl">
        <table class="w-full text-left">
            <thead class="bg-gray-100 border-b-2">
                <tr>
                    <th class="text-center px-4 py-3 text-gray-600 font-semibold">Номер заказа</th>
                    <th class="px-4 py-3 text-gray-600 font-semibold">Товары</th>
                    <th class="px-4 py-3 text-gray-600 font-semibold">Цена</th>
                    <th class="px-4 py-3 text-gray-600 font-semibold">Количество</th>
                    <th class="px-4 py-3 text-gray-600 font-semibold">Сумма</th>
                    <th class="px-4 py-3 text-gray-600 font-semibold">Итого</th>
                </tr>
            </thead>
            <tbody id="table" class="w-full text-left"></tbody>
        </table>
    </div>
</div>
<script src="/static/orders.js"></script>