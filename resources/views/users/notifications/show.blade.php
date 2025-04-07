<x-app-layout>
    <section class="mt-14 max-w-2xl px-6 py-8 mx-auto bg-white dark:bg-gray-900">
        <header>
            <a href="#" class="flex gap-5 align-items-center">
                <img class="w-auto h-7 sm:h-8" src="{{ asset('images/logo.png') }}" alt="">
                <strong>
                    {{ config('app.name') }}
                </strong>
            </a>
        </header>
        <main class="mt-8">
            <h1>{{ $notification->title }} Kode Lamaran: {{ str_pad($notification->pelamar_id, 4, '0', STR_PAD_LEFT) }}
            </h1>
            {!! $notification->content !!}
        </main>
        <footer class="mt-8">
            <p class="mt-3 text-gray-500 dark:text-gray-400">© {{ date('Y') }} {{ config('app.name') }}. All Rights
                Reserved.</p>
        </footer>
    </section>
</x-app-layout>
