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
            <h2 class="text-gray-700 dark:text-gray-200">Hi {{ $pelamar->nama }},</h2>

            <p class="mt-2 leading-loose text-gray-600 dark:text-gray-300">
                Terima kasih atas minat Anda untuk bergabung dengan Finna Store dan sudah mengikuti tahapan seleksi
                tes wawancara sebagai bagian dari proses seleksi karyawan kami
                sebagai {{ $pelamar->lowongan->judul }}.
            </p>
            <p class="mt-2 leading-loose text-gray-600 dark:text-gray-300">
                Hasil seleksi telah dikirim ke email {{ $pelamar->email }}
            </p>

            <a href="https://gmail.com" target="_blank"
                class="px-6 py-2 mt-4 text-sm font-medium tracking-wider text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-lg hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80">
                Cek Inbox
            </a>

            <p class="mt-8 text-gray-600 dark:text-gray-300">
                Terima kasih, <br>
                {{ config('app.name') }}
            </p>
        </main>


        <footer class="mt-8">
            <p class="mt-3 text-gray-500 dark:text-gray-400">© {{ date('Y') }} {{ config('app.name') }}. All Rights
                Reserved.</p>
        </footer>
    </section>
</x-app-layout>
