<x-app-layout title="{{ $lowongan->judul }}">
    <div class="mt-10 md:flex items-start justify-center py-12 2xl:px-20 md:px-6 px-4">
        <div class="">
            <img class="sm:w-full md:w-[40vw] lg:w-[30vw]" alt="{{ $lowongan->judul }}"
                src="{{ $lowongan->getThumbnailUrl() }}" />
        </div>
        <div class="xl:w-2/5 md:w-1/2 lg:ml-8 md:ml-6 md:mt-0 mt-6">
            <div class="border-b border-gray-200 pb-6">
                <h1 class="lg:text-2xl text-xl font-semibold lg:leading-6 leading-7 text-gray-800 dark:text-white mt-2">
                    {{ $lowongan->judul }}
                </h1>
            </div>
            <div class="py-4 border-b border-gray-200 flex items-center justify-between">
                <strong class="text-base leading-4 text-gray-800 dark:text-gray-300">Kriteria</strong>
            </div>
            <div class="py-4 border-b border-gray-200 flex items-center justify-between">
                <div class="flex flex-wrap items-center justify-center">
                    @foreach ($lowongan->kriterias()->get() as $index => $kriteria)
                        <p
                            class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                            {{ $kriteria->judul }}</p>
                    @endforeach
                </div>
            </div>
            <a href="{{ route('pelamar.form', $lowongan->id) }}"
                class="dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800 text-base flex items-center justify-center leading-none text-white bg-gray-800 w-full py-4 hover:bg-gray-700 ">
                Lamar Pekerjaan Ini
            </a>
            <div>
                <p class="xl:pr-48 text-base lg:leading-tight leading-normal text-gray-600 dark:text-gray-300 mt-7">
                    {!! $lowongan->deskripsi !!}
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
