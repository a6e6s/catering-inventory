<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }
    </style>
</head>

<body
    class="antialiased bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 h-screen flex items-center justify-center">
    <div class="text-center p-6 max-w-lg w-full">
        <div class="mb-6">
            @section('icon')
                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-amber-500 opacity-80" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            @show
        </div>

        <h1 class="text-6xl font-bold text-gray-800 dark:text-white mb-4">@yield('code')</h1>

        <h2 class="text-2xl font-semibold mb-4">@yield('message')</h2>

        <p class="text-gray-600 dark:text-gray-400 mb-8">
            @yield('description', 'نعتذر، حدث خطأ غير متوقع.')
        </p>

        <div class="flex justify-center gap-4">
            <a href="{{ url('/') }}"
                class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                الرئيسية
            </a>
            <a href="{{ url('/admin') }}"
                class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                لوحة التحكم
            </a>
        </div>
    </div>
</body>

</html>
