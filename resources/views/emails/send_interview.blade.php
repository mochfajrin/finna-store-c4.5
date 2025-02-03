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
            <a href="#" class="flex gap-5 align-items-center">
                <img class="w-auto h-7 sm:h-8" src="{{ asset('images/logo.png') }}" alt="">
                <strong>
                    {{ config('app.name') }}
                </strong>
            </a>
        </header>
        <main class="mt-8">
            <h2 class="text-gray-700 dark:text-gray-200">Halo {{ $data['nama'] }},</h2>

            <p class="mt-2 leading-loose text-gray-600 dark:text-gray-300">
                Terima kasih telah melamar untuk posisi {{ $data['posisi'] }} di {{ config('app.name') }}. Kami telah
                meninjau lamaran
                Anda dan tertarik untuk mengundang Anda ke sesi wawancara guna mengenal lebih lanjut keterampilan serta
                pengalaman Anda.
            </p>
            <p>
                <strong>
                    Detail Interview:
                </strong>
            </p>
            <div>
                🕒 <strong>Waktu:</strong> 09.00 - 15.00 WIB
            </div>
            <div>
                📍 <strong>Lokasi:</strong> Jln Sunan Giri No 17 Groyok Kel Sukorejo Lamongan
            </div>
            <div>
                📅 <strong>Tanggal:</strong> {{ $data['date'] }}
            </div>
            <div></div>
            <p class="mt-2 leading-loose text-gray-600 dark:text-gray-300">
                Silakan konfirmasi kehadiran Anda dengan membalas email ini sebelum {{ $data['date'] }}. Jika waktu
                yang dijadwalkan tidak sesuai, beri tahu kami agar dapat dijadwalkan ulang.

                Jangan ragu untuk menghubungi kami jika ada pertanyaan lebih lanjut. Kami menantikan pertemuan dengan
                Anda!
            </p>
            <p class="mt-2 leading-loose text-gray-600 dark:text-gray-300">
                Salam hangat,
                HRD {{ config('app.name') }}
            </p>
            <p>
                <strong>Phone:</strong>(0778) 4081191
            </p>
            <p>
                <strong>Email:</strong>FinnaStore@gmail.com
            </p>
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
