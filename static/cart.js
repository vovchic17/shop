// Получение таблицы товаров в корзине
const table = document.querySelector("#table");
// Получение суммы корзины
const totalAmount = document.querySelector("#total-amount");
// Получение кнопки заказа
const orderBtn = document.querySelector("#order-btn");

// Запрос на бэк для получения товаров в корзине пользователя
const getCart = async () => {
    resp = await fetch("/cart/getCart");
    return await resp.json();
}

// Запрос на бэк для добавления N товаров в корзину
const addToCart = async (product_id, count) => {
    resp = await fetch(
        "/cart/add",
        {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                "product_id": product_id,
                "quantity": count
            })
        }
    );
    return await resp.json();
}

// Запрос на бэк для удаления товара из корзины
const deleteFromCart = async (product_id) => {
    resp = await fetch(
        "/cart/delete",
        {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ "product_id": product_id })
        }
    );
    return await resp.json();
}

orderBtn.addEventListener("click", async () => {
    const cart = await getCart();
    if (cart.length) {
        await fetch("/cart/order");
        window.location.href = "/cart/purchase";
    }
})

const main = async () => {
    // Получение корзины пользователя
    const cart = await getCart();
    // Если корзина пуста, выводится соответствующее сообщение
    if (cart.length === 0) {
        table.innerHTML = `
        <tr>
            <td class="px-4 py-3 text-gray-700">Корзина пуста</td>
        </tr>
        `;
        return;
    }
    // Циклически добавляем товары в таблицу корзину, считая сумму
    let sum = 0;
    for (const product of cart) {
        sum += product.price * product.quantity;
        table.innerHTML += `
            <tr id="product-${product.id}" class="h-10">
            <td class="min-w-80 px-4 py-3 flex items-center overflow-hidden">
                <img src="/images/${product.id}.jpg" alt="Товар" class="h-12 mr-4">
                <a href="/product/page?id=${product.id}" class="text-gray-800 text-lg font-semibold">${product.title.length > 60 ?
                product.title.slice(0, 60) + "..."
                : product.title
            }</a>
            </td>
            <td class="min-w-36 px-4 py-3 text-gray-700">${product.price.toLocaleString()} ₽</td>
            <td class="py-3">
                <button id="minus-btn-${product.id}" class="bg-blue-600 w-8 h-8 rounded-lg text-white font-bold">-</button>
                <input class="w-8 text-center bg-transparent text-lg" id="quantity-${product.id}" value="${product.quantity}" readonly></input>
                <button id="plus-btn-${product.id}" class="bg-blue-600 w-8 h-8 rounded-lg text-white font-bold">+</button>
            </td>
            <td id="total-${product.id}" class="min-w-28 px-4 py-3 text-gray-700">${(product.price * product.quantity).toLocaleString()} ₽</td>
            <td>
                <button id="remove-${product.id}"class="flex gap-1 text-red-500 hover:bg-red-100 font-semibold px-2 py-2 rounded-lg">
                    <svg class="h-6 w-6 text-red-500"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Удалить
                </button>
            </td>
        </tr>
        `;
    }
    // Обновляем итоговую сумму корзины
    totalAmount.innerHTML = `${sum.toLocaleString()} ₽`;
    // Привязываем события при нажатии на кнопки вторым
    // циклом, т.к. при изменении элемента в первом цикле,
    // обновляется весь элемент таблицы, удаляя события,
    // привязанные ко вложенным в него элементам.
    for (const product of cart) {
        // Получение элементов для изменения количества, итоговой
        // стоимости, а также удаления товара из корзины.
        const minusBtn = document.querySelector(`#minus-btn-${product.id}`);
        const plusBtn = document.querySelector(`#plus-btn-${product.id}`);
        const quantity = document.querySelector(`#quantity-${product.id}`);
        const removeBtn = document.querySelector(`#remove-${product.id}`);
        const total = document.querySelector(`#total-${product.id}`);
        // Привязка событий к каждой кнопке
        minusBtn.addEventListener("click", async () => {
            if (quantity.value > 1) {
                const success = await addToCart(product.id, parseInt(quantity.value) - 1);
                if (success) {
                    quantity.value--;
                    sum -= product.price;
                    total.innerHTML = `${product.price * quantity.value} ₽`;
                    totalAmount.innerHTML = `${sum.toLocaleString()} ₽`;
                }
            }
        });
        plusBtn.addEventListener("click", async () => {
            const success = await addToCart(product.id, parseInt(quantity.value) + 1);
            if (success) {
                quantity.value++;
                sum += product.price;
                total.innerHTML = `${(product.price * quantity.value).toLocaleString()} ₽`;
                totalAmount.innerHTML = `${sum.toLocaleString()} ₽`;
            }
        });
        removeBtn.addEventListener("click", async () => {
            const success = await deleteFromCart(product.id);
            if (success) {
                const row = document.querySelector(`#product-${product.id}`);
                sum -= product.price * quantity.value;
                totalAmount.innerHTML = `${sum.toLocaleString()} ₽`;
                row.remove();
                if (sum === 0) {
                    table.innerHTML = `
                    <tr>
                        <td class="px-4 py-3 text-gray-700">Корзина пуста</td>
                    </tr>
                    `;
                }
            }
        });
    }
}

main();