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

    <!-- DataTables Tailwind CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.tailwindcss.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/output.css') }}">
</head>

<body>
    <main>
        <div>
            <a href="{{ route('filament.admin.pages.dashboard') }}">Kembali</a>
        </div>
        <div class="relative overflow-x-auto container mx-auto">
            <!-- Add an ID to the table for DataTables initialization -->
            <table id="evaluationsTable"
                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs uppercase" style="background-color: #16a34a;">
                    <tr>
                        <th scope="col" class="px-6 py-3" style="color: white;">
                            Kandidat
                        </th>
                        <th scope="col" class="px-6 py-3" style="color: white;">
                            DRH
                        </th>
                        <th scope="col" class="px-6 py-3" style="color: white;">
                            KTP
                        </th>
                        <th scope="col" class="px-6 py-3" style="color: white;">
                            SKCK
                        </th>
                        <th scope="col" class="px-6 py-3" style="color: white;">
                            Ijazah
                        </th>
                        <th scope="col" class="px-6 py-3" style="color: white;">
                            Tes Buta Warna
                        </th>
                        <th scope="col" class="px-6 py-3" style="color: white;">
                            Tes Kemampuan
                        </th>
                        <th scope="col" class="px-6 py-3" style="color: white;">
                            Tes Wawancara
                        </th>
                        <th scope="col" class="px-6 py-3" style="color: white;">
                            Total
                        </th>
                        <th scope="col" class="px-6 py-3" style="color: white;">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($evaluations as $evaluation)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <td class="px-6 py-4" style="color: black;">
                                {{ $evaluation->nama }}
                            </td>
                            <td class="px-6 py-4" style="color: black;">
                                @if ($evaluation->riwayat >= 50)
                                    <span
                                        class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                        {{ $evaluation->riwayat }}
                                    </span>
                                @else
                                    <span
                                        class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                        {{ $evaluation->riwayat }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4" style="color: black;">
                                @if ($evaluation->ktp == 100)
                                    <span
                                        class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                        {{ $evaluation->ktp }}
                                    </span>
                                @else
                                    <span
                                        class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                        {{ $evaluation->ktp }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4" style="color: black;">
                                @if ($evaluation->skck == 100)
                                    <span
                                        class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                        {{ $evaluation->skck }}
                                    </span>
                                @else
                                    <span
                                        class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                        {{ $evaluation->skck }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4" style="color: black;">
                                @if ($evaluation->ijazah >= 50)
                                    <span
                                        class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                        {{ $evaluation->ijazah }}
                                    </span>
                                @else
                                    <span
                                        class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                        {{ $evaluation->ijazah }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4" style="color: black;">
                                @if ($evaluation->buta_warna >= 80)
                                    <span
                                        class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                        {{ $evaluation->buta_warna }}
                                    </span>
                                @else
                                    <span
                                        class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                        {{ $evaluation->buta_warna }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4" style="color: black;">
                                @if ($evaluation->kemampuan >= 50)
                                    <span
                                        class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                        {{ $evaluation->kemampuan }}
                                    </span>
                                @else
                                    <span
                                        class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                        {{ $evaluation->kemampuan }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4" style="color: black;">
                                @if ($evaluation->wawancara >= 50)
                                    <span
                                        class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                        {{ $evaluation->wawancara }}
                                    </span>
                                @else
                                    <span
                                        class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                        {{ $evaluation->wawancara }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4" style="color: black;">
                                {{ $evaluation->total }}
                            </td>
                            <td class="px-6 py-4" style="color: black;">
                                @if ($evaluation->status)
                                    <span
                                        class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                        Terima
                                    </span>
                                @else
                                    <span
                                        class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
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

    <!-- Feather Icons -->
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace();
    </script>

    <!-- jQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    <!-- DataTables Tailwind JS -->
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.tailwindcss.js"></script>

    <!-- Initialize DataTables -->
    <script>
        $(document).ready(function() {
            $('#evaluationsTable').DataTable({
                responsive: true, // Enable responsive feature
                paging: true, // Enable pagination
                pageLength: 15, // Set default page length
                searching: true, // Enable search bar
                ordering: true, // Enable column sorting
                info: true, // Show table information
                autoWidth: false, // Disable auto-width calculation
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json' // Indonesian language (optional)
                }
            });
        });
    </script>
</body>

</html>
