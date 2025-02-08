<x-app-layout title="{{ $lowongan->judul }}">
    <div class="flex items-center justify-center p-12 mt-14">
        <div class="mx-auto w-full max-w-[550px] bg-white">
            <h1 class="font-extrabold text-xl mb-10">Lamaran {{ $lowongan->judul }} | {{ config('app.name') }}</h1>
            <form class="mt-10" method="post" action="{{ route('pelamar.register', $lowongan->id) }}"
                enctype="multipart/form-data">
                @csrf
                <div class="mb-5">
                    <label for="nama" class="mb-3 block text-base font-medium text-[#07074D]">
                        Nama Lengkap
                    </label>
                    <input type="text" name="nama" id="nama" placeholder="Isi nama lengkap"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                        value="{{ old('nama') }}" />
                    @error('nama')
                        <p class="text-center text-red-700">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="alamat" class="mb-3 block text-base font-medium text-[#07074D]">
                        Alamat
                    </label>
                    <input type="text" name="alamat" id="alamat" placeholder="Isi alamat anda"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                        value="{{ old('alamat') }}" />
                    @error('alamat')
                        <p class="text-center text-red-700">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="jenis_kelamin" class="mb-3 block text-base font-medium text-[#07074D]">
                        Jenis Kelamin
                    </label>
                    <fieldset>
                        <legend class="sr-only">jenis Kelamin</legend>
                        <div class="flex items-center mb-4">
                            <input id="jenis-kelamin-option-1" type="radio" name="jenis_kelamin" value="l"
                                class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600"
                                {{ old('jenis_kelamin') == 'l' ? 'checked' : '' }}>
                            <label for="jenis-kelamin-option-1"
                                class="block ms-2  text-sm font-medium text-gray-900 dark:text-gray-300">
                                Laki-laki
                            </label>
                        </div>
                        <div class="flex items-center mb-4">
                            <input id="jenis-kelamin-option-2" type="radio" name="jenis_kelamin" value="p"
                                class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600"
                                {{ old('jenis_kelamin') == 'p' ? 'checked' : '' }}>
                            <label for="jenis-kelamin-option-2"
                                class="block ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                Perempuan
                            </label>
                        </div>
                    </fieldset>
                    @error('jenis_kelamin')
                        <p class="text-center text-red-700">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="no_telepon" class="mb-3 block text-base font-medium text-[#07074D]">
                        Nomor Telepon
                    </label>
                    <input type="text" name="no_telepon" id="no_telepon" placeholder="Masukkan nomor telepon"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                        value="{{ old('no_telepon') }}" />
                    @error('no_telepon')
                        <p class="text-center text-red-700">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="email" class="mb-3 block text-base font-medium text-[#07074D]">
                        Alamat Email
                    </label>
                    <input type="email" name="email" id="email" placeholder="Masukkan email"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                        value="{{ old('email') }}" />
                    @error('email')
                        <p class="text-center text-red-700">{{ $message }}</p>
                    @enderror
                </div>
                <div class="-mx-3 flex flex-wrap">
                    <div class="w-full px-3 sm:w-1/2">
                        <div class="mb-5">
                            <label for="date" class="mb-3 block text-base font-medium text-[#07074D]">
                                Tanggal Lahir
                            </label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                                value="{{ old('tanggal_lahir') }}" />
                            @error('tanggal_lahir')
                                <p class="text-center text-red-700">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="mb-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="foto">Unggah
                        Foto Terbaru</label>
                    <input
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                        aria-describedby="foto_help" id="foto" name="url_foto" type="file"
                        accept="image/* ,application/pdf" value="{{ old('url_foto') }}">
                    @error('url_foto')
                        <p class="text-center text-red-700">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="ijazah">Unggah
                        Ijazah Pendidikan Terakhir</label>
                    <input
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                        aria-describedby="ijazah_help" id="ijazah" name="url_ijazah" type="file"
                        accept="image/*, application/pdf" value="{{ old('url_ijazah') }}">
                    @error('url_ijazah')
                        <p class="text-center text-red-700">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        for="user_avatar">Unggah
                        KTP</label>
                    <input
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                        aria-describedby="ktp_help" id="url_ktp" name="url_ktp" type="file"
                        accept="image/*, application/pdf" value="{{ old('url_ktp') }}">
                    @error('url_ktp')
                        <p class="text-center text-red-700">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="skck">Unggah
                        SKCK Aktif</label>
                    <input
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                        aria-describedby="skck_help" id="skck" name="url_skck" type="file"
                        accept="image/*, application/pdf" value="{{ old('url_skck') }}">
                    @error('url_skck')
                        <p class="text-center text-red-700">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="riwayat">Unggah
                        Riwayat (CV) </label>
                    <input
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                        aria-describedby="riwayat_help" id="riwayat" type="file"
                        accept="image/*, application/pdf" name="url_riwayat" value="{{ old('url_riwayat') }}">
                    @error('url_riwayat')
                        <p class="text-center text-red-700">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <button type="submit"
                        class="bg-[#6A64F1] hover:shadow-form w-full rounded-md  py-3 px-8 text-center text-base font-semibold text-white outline-none"
                        style="background-color: #6A64F1">
                        Lamar Pekerjaan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
