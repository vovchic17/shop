<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/images/favicon.png">
    <title><?php echo $title; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-200">
    <header class="bg-white shadow fixed w-full">
        <div class="container mx-auto flex justify-between items-center px-6 py-4">
            <a href="/" class="text-2xl font-bold text-gray-800">Shop</a>
            <?php if (isset($_SESSION["user"])) { ?>
                <div class="flex space-x-5">
                    <span class="my-auto text-lg font-bold"><?php echo $_SESSION["user"] ?></span>
                    <a href="/auth/logout"
                        class="mx-1 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-500">
                        Выйти
                    </a>
                    <a href="/orders">
                        <svg class="h-9 w-9 text-blue-600 hover:text-blue-500" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" />
                            <path d="M3.5 5.5l1.5 1.5l2.5 -2.5" />
                            <path d="M3.5 11.5l1.5 1.5l2.5 -2.5" />
                            <path d="M3.5 17.5l1.5 1.5l2.5 -2.5" />
                            <line x1="11" y1="6" x2="20" y2="6" />
                            <line x1="11" y1="12" x2="20" y2="12" />
                            <line x1="11" y1="18" x2="20" y2="18" />
                        </svg>
                    </a>
                    <a href="/cart">
                        <svg class="h-9 w-9 text-blue-600 hover:text-blue-500" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </a>
                </div>
            <?php } else { ?>
                <div>
                    <a href="/auth/login"
                        class="mx-1 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-500">
                        Войти
                    </a>
                    <a href="/auth/register"
                        class="mx-1 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-500">
                        Регистрация
                    </a>
                </div>
            <?php } ?>
        </div>
    </header>
    <?php include "$view.php"; ?>
</body>

</html>