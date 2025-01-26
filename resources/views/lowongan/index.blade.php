<x-app-layout>
    <section class="bg-gray-50 py-20 antialiased dark:bg-gray-900 md:py-12">
        <div class="mt-5 mx-auto max-w-screen-xl px-4 2xl:px-0">
            <h2 class="my-5 text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Lowongan Kerja</h2>
            <div class="mb-4 grid gap-4 sm:grid-cols-2 md:mb-8 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($lowongans as $lowongan)
                    <div
                        class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                        <div class="h-56 w-full">
                            <a href="{{ route('lowongan.show', ['lowonganId' => $lowongan->id]) }}">
                                <img class="mx-auto h-full" src="{{ $lowongan->getThumbnailUrl() }}" alt="" />
                            </a>
                        </div>
                        <div class="pt-6">
                            <a href="{{ route('lowongan.show', ['lowonganId' => $lowongan->id]) }}"
                                class="text-lg font-semibold leading-tight text-gray-900 hover:underline dark:text-white">
                                {{ $lowongan->judul }}
                            </a>
                            <div class="mt-4 flex items-center">
                                <a href="{{ route('lowongan.show', ['lowonganId' => $lowongan->id]) }}"
                                    class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 sm:mr-2 lg:mr-0 dark:bg-purple-600 dark:hover:bg-purple-700 focus:outline-none dark:focus:ring-purple-800">Lamar
                                    Sekarang</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </section>
</x-app-layout>
