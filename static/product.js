// Получение кнопок и блоков
const addToCartBlock = document.querySelector("#add-to-cart-block");
const quantityBlock = document.querySelector("#quantity-block");
const addToCartBtn = document.querySelector("#add-to-cart-btn");
const plusBtn = document.querySelector("#plus-btn");
const minusBtn = document.querySelector("#minus-btn");
const quantity = document.querySelector("#quantity");

// Получение query
const urlParams = new URLSearchParams(window.location.search);

// Запрос на бэк для получения количества товара в корзине
const getProduct = async () => {
    resp = await fetch("/cart/getProduct?" + urlParams);
    return await resp.json();
}

// Запрос на бэк для добавления товара в корзину
const addToCart = async count => {
    resp = await fetch(
        "/cart/add",
        {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                "product_id": urlParams.get("id"),
                "quantity": count
            })
        }
    );
    return await resp.json();
}

// Запрос на бэк для удаления товара из корзины
const deleteFromCart = async () => {
    resp = await fetch(
        "/cart/delete",
        {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                "product_id": urlParams.get("id")
            })
        }
    );
    return await resp.json();
}

// Привязка события к кнопке "Добавить в корзину"
addToCartBtn.addEventListener("click", async () => {
    const success = await addToCart(parseInt(quantity.value));
    if (success) {
        addToCartBlock.classList.add("hidden");
        quantityBlock.classList.remove("hidden");
    }
})

// Привязка события к кнопке "+"
plusBtn.addEventListener("click", async () => {
    quantity.value = parseInt(quantity.value) + 1;
    await addToCart(parseInt(quantity.value));
})

// Привязка события к кнопке "-"
minusBtn.addEventListener("click", async () => {
    const value = parseInt(quantity.value) - 1;
    if (value >= 1) {
        quantity.value = value;
        await addToCart(parseInt(quantity.value));
    } else {
        await deleteFromCart();
        quantityBlock.classList.add("hidden");
        addToCartBlock.classList.remove("hidden");
    }
})

const main = async () => {
    // Получение количества товара в корзине
    const product = await getProduct();
    // Если продукт в корзине (кол-во > 0), отображается
    // количество, иначе - кнопка "Добавить в корзину"
    if (product.quantity) {
        quantityBlock.classList.remove("hidden");
        quantity.value = product.quantity;
    } else {
        addToCartBlock.classList.remove("hidden");
    }
}

main();
