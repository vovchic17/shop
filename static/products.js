// Получение элементов выпадающих списков
const brand_select = document.querySelector("#brand-select");
const scale_select = document.querySelector("#scale-select");
const category_select = document.querySelector("#category-select");
const car_brand_select = document.querySelector("#car_brand-select");
const year_select = document.querySelector("#year-select");
const country_select = document.querySelector("#country-select");
// Получение поля ввода
const search_bar = document.querySelector("#search-bar");
// Получения кнопки поиска
const search_button = document.querySelector("#search-button");
// Получение контейнера продуктов
const productList = document.querySelector("#product-list");
// Получение блока пагинации
const pagination = document.querySelector("#pagination");
// Получение блока с сообщением об отсутствии соответствующих товаров
const not_found = document.querySelector("#not-found");

// Запрос на бэк для получения товаров
const getProducts = async () => {
    const resp = await fetch("/product/get" + window.location.search);
    return await resp.json();
}

// Запрос на бэк для получения уникальных значений каждой категории
const getCategories = async () => {
    const resp = await fetch("/product/categories");
    return await resp.json();
}

// Выгрузка товаров в контейнер
// Обновление блока пагинации
const loadProducts = async () => {
    not_found.classList.add("hidden");
    updateUrlParams();
    const { result, count } = await getProducts();
    productList.innerHTML = "";
    for (const product of result) {
        productList.innerHTML += `
            <a href="/product/page?id=${product.id}">
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                    <div сlass="bg-white rounded-lg shadow hover:shadow-lg transition">
                        <img src="/images/${product.id}.jpg" alt="Product Image"
                            class="w-full h-48 object-cover rounded-t-lg" />
                        <div class="p-4">
                            <h2 class="text-md font-bold text-gray-800">
                            ${product.title.length > 50 ?
                product.title.slice(0, 50) + "..."
                : product.title
            }</h2>
                            <p class="text-sm text-gray-600">${product.scale}</p>
                            <p class="text-sm text-gray-600">${product.car_brand}</p>
                            <p class="text-sm text-gray-600">${product.country}</p>
                            <p class="mt-2 text-lg font-semibold text-blue-600">
                                ₽ ${parseInt(product.price).toLocaleString()}
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        `;
    }
    if (result.length == 0) {
        not_found.classList.remove("hidden");
    }
    // Получение номера текущей страницы из query
    const urlParams = new URLSearchParams(window.location.search);
    const page = parseInt(urlParams.get("page")) || 1;
    // Создание новых параметров для генерации новой
    // ссылки для каждой кнопки блока пагинации
    let pageParams = new URLSearchParams(urlParams);
    pagination.innerHTML = "";
    if (page > 1) {
        pageParams.set("page", parseInt(page) - 1);
        pagination.innerHTML += `
            <a href="?${pageParams.toString()}" class="px-4 py-2 flex items-center border
            bg-blue-600 text-white rounded-xl hover:bg-blue-600">&lt;</a>
        `;
    }
    for (let i = page - 2; (i - 1) * 20 < count && i < page + 3; i++) {
        if (i > 0) {
            pageParams.set("page", i);
            pagination.innerHTML += `
            <a href="?${pageParams.toString()}" class="px-4 py-2 flex items-center border
            bg-blue-600 text-white rounded-xl hover:bg-blue-600">${i}</a>
        `;
        }
    }
    if (page * 20 < count) {
        pageParams.set("page", parseInt(page) + 1);
        pagination.innerHTML += `
            <a href="?${pageParams.toString()}" class="px-4 py-2 flex items-center border
            bg-blue-600 text-white rounded-xl hover:bg-blue-600">&gt;</a>
        `;
    }
}

// Удаление лишних параметров из query
// Обновление категорий в выпадающих списках
// Обновление строки поиска
const updatePage = async () => {
    // Получение категорий
    const urlParams = new URLSearchParams(window.location.search);
    const categories = await getCategories();
    // Удалить из query все невалидные параметры
    for (const [key, value] of urlParams) {
        if (
            !(categories[key] || []).map(String).includes(value) &&
            !["search", "limit", "page"].includes(key)
        ) {
            urlParams.delete(key);
        }
    }
    // Обновление query в ссылке без перезагрузки страницы
    window.history.replaceState(null, null, "?" + urlParams);

    // Обновление поля поиска из query
    search_bar.value = urlParams.get("search");

    // Функция для добавления значений в выпадающий список,
    // если значение равно значению в query, то оно выбирается
    const populateSelect = (selectElement, options, param) => {
        for (const option of options) {
            if (param == option)
                selectElement.innerHTML += `<option selected value="${option}">${option}</option>`;
            else
                selectElement.innerHTML += `<option value="${option}">${option}</option>`;
        }
    };

    // Заполнение выпадающих списков
    populateSelect(brand_select, categories.brand, urlParams.get("brand"));
    populateSelect(scale_select, categories.scale, urlParams.get("scale"));
    populateSelect(category_select, categories.category, urlParams.get("category"));
    populateSelect(car_brand_select, categories.car_brand, urlParams.get("car_brand"));
    populateSelect(year_select, categories.year, urlParams.get("year"));
    populateSelect(country_select, categories.country, urlParams.get("country"));
};

// Обновление параметров перед запросом товаров
const updateUrlParams = () => {
    const oldParams = new URLSearchParams(window.location.search);
    const params = new URLSearchParams();
    if (brand_select.value !== "")
        params.set("brand", brand_select.value);
    if (scale_select.value !== "")
        params.set("scale", scale_select.value);
    if (category_select.value !== "")
        params.set("category", category_select.value);
    if (car_brand_select.value !== "")
        params.set("car_brand", car_brand_select.value);
    if (year_select.value !== "")
        params.set("year", year_select.value);
    if (country_select.value !== "")
        params.set("country", country_select.value);
    if (search_bar.value !== "")
        params.set("search", search_bar.value);
    if (oldParams.get("limit"))
        params.set("limit", oldParams.get("limit"));
    if (oldParams.get("page"))
        params.set("page", oldParams.get("page"));
    window.history.replaceState(null, null, "?" + params);
}

// Обновление списка продуктов при нажатии на
// кнопку поиска или на клавишу enter
const updateProducts = async () => {
    // Удаление параметра страницы, т.к. при изменении
    // параметров поиска он больше не актуален
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.delete("page");
    window.history.replaceState(null, null, "?" + urlParams);
    await loadProducts();
}

const main = async () => {
    await updatePage();
    await loadProducts();
}

main();

// Привязка функции к событию нажатия на кнопку "Поиск"
search_button.addEventListener("click", updateProducts);
// Привязка функции к событию нажатия enter в поле поиска
search_bar.addEventListener("keypress", async (e) => {
    if (e.key === "Enter")
        await updateProducts();
});