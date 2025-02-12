<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ isset($title) ? $title . ' | ' : '' }} {{ config('app.name', '') }}</title>
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
<script async defer src="https://buttons.github.io/buttons.js"></script>
@vite(['resources/css/app.css', 'resources/js/app.js'])
<link rel="stylesheet" href="{{ asset('css/output.css') }}">

<body>
    <section class="mt-14 max-w-2xl px-6 py-8 mx-auto bg-white dark:bg-gray-900">
        <header>
            <a href="{{ route('home') }}" class="flex gap-5 align-items-center">
                <img class="w-auto h-7 sm:h-8" src="{{ asset('images/logo.png') }}" alt="">
                <strong>
                    {{ config('app.name') }}
                </strong>
            </a>
        </header>
        <main class="mt-8">
            <h2 class="text-gray-700 dark:text-gray-200">Hallo {{ $data['nama'] }},</h2>

            <p class="mt-2 leading-loose text-gray-600 dark:text-gray-300">
                Terima kasih atas minat Anda untuk bergabung dengan Finna Store. Kami mengundang Anda untuk mengikuti
                tes online kesehatan (buta warna) dan keterampilan sebagai bagian dari proses seleksi karyawan kami.
            </p>
            <strong>Waktu masing-masing tes adalah 30 menit dan waktu akan langsung berjalan ketika mengklik link
                dibawah</strong>
            <br>
            <a href="{{ $data['buta_warna'] }}"
                class="px-6 py-2 mt-4 text-sm font-medium tracking-wider text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-lg hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80">
                Tes Buta Warna
            </a>
            <br>
            <a href="{{ $data['kemampuan'] }}"
                class="px-6 py-2 mt-4 text-sm font-medium tracking-wider text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-lg hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80">
                Tes Kemampuan
            </a>

            <p class="mt-8 text-gray-600 dark:text-gray-300">
                Terima kasih, <br>
                {{ config('app.name') }}
            </p>
        </main>
        <footer class="mt-8">
            <p class="mt-3 text-gray-500 dark:text-gray-400">© {{ date('Y') }} {{ config('app.name') }}. All
                Rights
                Reserved.</p>
        </footer>
    </section>
</body>

</html>
