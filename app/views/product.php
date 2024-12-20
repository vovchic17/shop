<div class="h-full flex justify-center items-center bg-gray-200 overflow-hidden mx-10 py-28">
    <div class="bg-blue-100 shadow-md max-w-3xl rounded-3xl h-auto">
        <div class="bg-gray-100 flex justify-center items-center rounded-t-3xl">
            <img src="/images/<?= $product["id"] ?>.jpg" alt="Фото модели автомобиля"
                class="w-full h-auto rounded-t-3xl" />
        </div>
        <div class="p-6 overflow-auto">
            <h1 class="text-2xl font-bold text-gray-800 mb-4"><?= $product["title"] ?></h1>
            <p class="text-md text-gray-500 mb-2">Бренд: <span class="text-gray-700"><?= $product["brand"] ?></span></p>
            <p class="text-md text-gray-500 mb-2">Масштаб: <span class="text-gray-700"><?= $product["scale"] ?></span>
            </p>
            <p class="text-md text-gray-500 mb-2">Категория: <span
                    class="text-gray-700"><?= $product["category"] ?></span></p>
            <p class="text-md text-gray-500 mb-2">Бренд машины: <span
                    class="text-gray-700"><?= $product["car_brand"] ?></span></p>
            <p class="text-md text-gray-500 mb-2">Год: <span class="text-gray-700"><?= $product["year"] ?></span></p>
            <p class="text-md text-gray-500 mb-4">Страна: <span class="text-gray-700"><?= $product["country"] ?></span>
            </p>
            <div class="text-xl font-semibold text-gray-800 mb-6">
                Цена: <span class="text-green-600"><?= $product["price"] ?> ₽</span>
            </div>

            <div id="add-to-cart-block" class="hidden">
                <button id="add-to-cart-btn"
                    class="bg-blue-500 text-white font-bold py-2 px-4 rounded-xl hover:bg-blue-600 w-64">
                    Добавить в корзину
                </button>
            </div>

            <div id="quantity-block" class="flex items-center space-x-4 hidden">
                <button id="minus-btn" class="bg-blue-600 w-8 h-8 rounded-lg text-white font-bold">-</button>
                <input class="w-8 text-center bg-transparent text-lg font-bold" id="quantity" value="1" readonly></input>
                <button id="plus-btn" class="bg-blue-600 w-8 h-8 rounded-lg text-white font-bold">+</button>
                <a href="/cart" class="bg-green-500 text-white font-bold py-2 px-4 rounded-xl hover:bg-green-600">
                    К корзине
                </a>
            </div>
        </div>
    </div>
</div>
<script src="/static/product.js"></script>