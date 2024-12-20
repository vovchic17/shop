// Получение таблицы истории покупок
const table = document.querySelector("#table");

// Запрос на бэк для получения спискка заказов
const getOrders = async () => {
    resp = await fetch("/orders/get");
    return await resp.json();
}

const main = async () => {
    // Получение заказов
    const orders = await getOrders();
    // Если заказов нет, выводится соответствующее сообщение
    if (orders.length === 0) {
        table.innerHTML = `
        <tr>
            <td class="px-4 py-3 text-gray-700">Вы ещё не сделали ни одного заказа</td>
        </tr>
        `
    }
    // Заполнение таблицы
    for (const order of orders) {
        let first = true;
        for (const product of order.products) {
            if (first) {
                table.innerHTML += `
                <tr class="hover:bg-gray-50 border-t-4">
                    <td class="text-center px-4 py-3 text-gray-800 text-lg font-bold" rowspan="${order.products.length}">#${order.order_id}</td>
                    <td class="px-4 py-3 text-gray-600">${product.title.substring(0, 60) + "..."}</td>
                    <td class="px-4 py-3 text-gray-600">${product.price} ₽</td>
                    <td class="px-4 py-3 text-gray-600">${product.quantity}</td>
                    <td class="px-4 py-3 text-gray-600">${product.price * product.quantity} ₽</td>
                    <td class="px-4 py-3 text-gray-800 font-bold" rowspan="${order.products.length}">${order.total_price} ₽</td>
                </tr>
                `;
                first = false;
            } else {
                table.innerHTML += `
                <tr class="hover:bg-gray-50 border">
                    <td class="px-4 py-3 text-gray-600">${product.title.substring(0, 60) + "..."}</td>
                    <td class="px-4 py-3 text-gray-600">${product.price} ₽</td>
                    <td class="px-4 py-3 text-gray-600">${product.quantity}</td>
                    <td class="px-4 py-3 text-gray-600">${product.price * product.quantity} ₽</td>
                </tr>
                `;
            }
        }
    }
}

main();