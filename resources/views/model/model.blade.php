@props(['title'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Hasil Perhitungan | {{ config('app.name', '') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/output.css') }}">
</head>

<body>
    <main>
        <div>
            <a href="{{ route('filament.admin.pages.dashboard') }}">Kembali</a>
        </div>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Id
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama Kandidat
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Riwayat
                        </th>
                        <th scope="col" class="px-6 py-3">
                            KTP
                        </th>
                        <th scope="col" class="px-6 py-3">
                            SKCK
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Ijazah
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Buta Warna
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Kemampuan
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Wawancara
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Total
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($evaluations as $evaluation)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <td class="px-6 py-4">
                                {{ $evaluation->pelamar_id }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $evaluation->nama }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $evaluation->riwayat }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $evaluation->ktp }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $evaluation->skck }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $evaluation->ijazah }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $evaluation->buta_warna }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $evaluation->kemampuan }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $evaluation->wawancara }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $evaluation->total }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($evaluation->status == true)
                                    <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                        Terima
                                    </span>

                                @else
                                    <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                        Tolak
                                    </span>

                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace();
    </script>
</body>

</html>
