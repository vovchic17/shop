<main class="container mx-auto p-6 pt-20">

    <div id="filter-container"
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 md:justify-between items-center mb-6 gap-4 md:space-y-0">
        <select id="brand-select"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-300">
            <option value="">Все бренды</option>
        </select>

        <select id="scale-select"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-300">
            <option value="">Все размеры</option>
        </select>

        <select id="category-select"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-300">
            <option value="">Все категории</option>
        </select>

        <select id="car_brand-select"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-300">
            <option value="">Все фирмы</option>
        </select>

        <select id="year-select"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-300">
            <option value="">Все года</option>
        </select>

        <select id="country-select"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-300">
            <option value="">Все страны</option>
        </select>
    </div>
    <div class="flex flex-col md:flex-row mb-6 gap-6">
        <input id="search-bar" type="text" placeholder="Поиск по товарам..."
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-300" />
        <button id="search-button"
            class="min-w-32 px-4 py-2 text-md font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-500">
            Поиск
        </button>
    </div>
    <h1 id="not-found" class="h-[40vh] flex items-center justify-center text-3xl mx-10 hidden">Товары по данному запросу
        не найдены</h1>
    <div id="product-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6"></div>
    <div id="pagination" class="flex justify-center items-center mt-6 space-x-2"></div>
</main>
<script src="/static/products.js"></script>