<x-app-layout>
    <div class="min-h-[100vh] max-w-[75vw] flex justify-center m-auto">
        @if (count($notifications) == 0)
            <h1 class="text-white mt-[20vh] font-bold text-xl">Notifikasi Kosong</h1>
        @else
            <ol class="relative border-s border-gray-200 dark:border-gray-700" style="margin-top: 10em;">
                @foreach ($notifications as $notification)
                    <li class="mb-10 ms-4">
                        <div
                            class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700">
                        </div>
                        <h3 class="text-lg font-semibold text-white">{{ $notification->title }}
                            Kode Lamaran: {{ str_pad($notification->pelamar_id, 4, '0', STR_PAD_LEFT) }}
                            @if (!$notification->is_read)
                                <span
                                    class="text-sm font-medium me-2 px-2 py-0.5 rounded-sm bg-blue-900 text-blue-300 ms-3">Belum
                                    Dibaca</span>
                            @endif
                        </h3>
                        <a href="{{ route('user.show-notifications', $notification->id) }}"
                            class="mt-2 inline-flex items-center px-4 py-2 text-sm font-medium border rounded-lg focus:z-10 focus:ring-4 focus:outline-none focus:text-blue-700 bg-gray-800 text-white border-gray-600 hover:text-white hover:bg-gray-700 focus:ring-gray-700">Lihat
                            Selengkapnya <svg class="w-3 h-3 ms-2 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg></a>
                    </li>
                @endforeach
            </ol>
        @endif
    </div>
</x-app-layout>
