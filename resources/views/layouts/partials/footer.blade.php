<!-- End block -->
<footer class="bg-slate-900 dark:bg-gray-800">
    <div class="max-w-screen-xl p-4 py-6 mx-auto lg:py-16 md:p-8 lg:p-10">
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8">
        <div class="text-center">
            <a href="{{ route('home') }}"
                class="flex items-center justify-center mb-5 text-2xl font-semibold text-gray-900 dark:text-white">
                <img src="{{ asset('images/logo.png') }}" class="h-6 mr-3 sm:h-9" alt="Landwind Logo" />
                <p class="text-white">
                    {{ config('app.name', '') }}
                </p>
            </a>
            <p class="block text-sm text-center text-white dark:text-gray-400">Jln Sunan Giri No 17 Groyok Kel
                Sukorejo
                Lamongan
            </p>
            <p class="block text-sm text-center text-white dark:text-gray-400">
                <strong>Phone:</strong> (0778) 4081191
            </p>
            <p class="block text-sm text-center text-white dark:text-gray-400">
                <strong>Email:</strong> FinnaStore@gmail.com
            </p>
            <span class="block text-sm text-center text-white dark:text-gray-400">© 2015
                {{ config('app.name', '') }}. All Rights
                Reserved.
            </span>
        </div>
    </div>
</footer>
