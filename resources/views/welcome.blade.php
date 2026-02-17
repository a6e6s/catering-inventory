<x-guest-layout>
    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex-shrink-0 flex items-center gap-2">
                        <!-- Logo Icon -->
                        <div class="bg-amber-500 rounded-lg p-1.5">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <span class="font-bold text-xl text-gray-800 tracking-tight">نظام المخزون</span>
                    </a>
                </div>
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/admin') }}"
                            class="text-sm font-medium text-gray-700 hover:text-amber-600 transition">لوحة التحكم</a>
                    @else
                        <a href="{{ route('filament.admin.auth.login') }}"
                            class="text-sm font-medium text-gray-700 hover:text-amber-600 transition">تسجيل الدخول</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">

                <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-white transform translate-x-1/2"
                    fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                    <polygon points="50,0 100,0 50,100 0,100" />
                </svg>

                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-right">
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                            <span class="block xl:inline">إدارة مخزونك</span>
                            <span class="block text-amber-600 xl:inline">بكل سهولة واحترافية</span>
                        </h1>
                        <p
                            class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            نظام متكامل يساعدك على تتبع المنتجات، إدارة الموردين، ومراقبة حركة المستودعات بدقة متناهية.
                            صمم لرفع كفاءة أعمالك.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start gap-4">
                            <div class="rounded-md shadow">
                                @auth
                                    <a href="{{ url('/admin') }}"
                                        class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-amber-600 hover:bg-amber-700 md:py-4 md:text-lg md:px-10 transition duration-150 ease-in-out">
                                        لوحة التحكم
                                    </a>
                                @else
                                    <a href="{{ route('filament.admin.auth.login') }}"
                                        class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-amber-600 hover:bg-amber-700 md:py-4 md:text-lg md:px-10 transition duration-150 ease-in-out">
                                        ابدأ الآن
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:left-0 lg:w-1/2 bg-gray-50 flex items-center justify-center">
            <!-- Abstract decorative graphic -->
            <div
                class="relative w-full h-full opacity-30 bg-[url('https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')] bg-cover bg-center">
                <div class="absolute inset-0 bg-amber-900 mix-blend-multiply"></div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-amber-600 font-semibold tracking-wide uppercase">المميزات</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    كل ما تحتاجه في مكان واحد
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    نوفر لك مجموعة من الأدوات القوية لضمان سير عملياتك اللوجستية بسلاسة.
                </p>
            </div>

            <div class="mt-10">
                <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                    <!-- Feature 1 -->
                    <div class="relative">
                        <dt>
                            <div
                                class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-amber-500 text-white">
                                <!-- Heroicon name: outline/cube -->
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <p class="mr-16 text-lg leading-6 font-medium text-gray-900">تتبع المخزون</p>
                        </dt>
                        <dd class="mt-2 mr-16 text-base text-gray-500">
                            مراقبة دقيقة لمستويات المخزون في جميع المستودعات مع تحديثات فورية للكميات.
                        </dd>
                    </div>

                    <!-- Feature 2 -->
                    <div class="relative">
                        <dt>
                            <div
                                class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-amber-500 text-white">
                                <!-- Heroicon name: outline/chart-bar -->
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <p class="mr-16 text-lg leading-6 font-medium text-gray-900">تقارير وتحليلات</p>
                        </dt>
                        <dd class="mt-2 mr-16 text-base text-gray-500">
                            احصل على رؤى تفصيليّة حول الأداء، وحركة الأصناف، والتكاليف لاتخاذ قرارات مدروسة.
                        </dd>
                    </div>

                    <!-- Feature 3 -->
                    <div class="relative">
                        <dt>
                            <div
                                class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-amber-500 text-white">
                                <!-- Heroicon name: outline/truck -->
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                </svg>
                            </div>
                            <p class="mr-16 text-lg leading-6 font-medium text-gray-900">إدارة التوزيع</p>
                        </dt>
                        <dd class="mt-2 mr-16 text-base text-gray-500">
                            نظم عمليات التوزيع والشحن وتتبع حركة البضائع بين الفروع والمستودعات بكفاءة.
                        </dd>
                    </div>

                    <!-- Feature 4 -->
                    <div class="relative">
                        <dt>
                            <div
                                class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-amber-500 text-white">
                                <!-- Heroicon name: outline/shield-check -->
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="mr-16 text-lg leading-6 font-medium text-gray-900">صلاحيات وأمان</p>
                        </dt>
                        <dd class="mt-2 mr-16 text-base text-gray-500">
                            تحكم كامل في صلاحيات المستخدمين لضمان أمان البيانات وتنظيم الوصول للمعلومات الحساسة.
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center">
            <div class="mb-4 md:mb-0">
                <p class="text-sm">© {{ date('Y') }} نظام المخزون المتكامل. جميع الحقوق محفوظة.</p>
            </div>
            <div class="flex space-x-6 space-x-reverse">
                <a href="#" class="text-gray-400 hover:text-white transition">سياسة الخصوصية</a>
                <a href="#" class="text-gray-400 hover:text-white transition">الشروط والأحكام</a>
                <a href="#" class="text-gray-400 hover:text-white transition">اتصل بنا</a>
            </div>
        </div>
    </footer>
</x-guest-layout>
