<x-app-layout>
    <section class="py-8 antialiased md:py-8" style="margin-top: 10vh">
        <div class="mx-auto max-w-screen-lg px-4 2xl:px-0">
            <h2 class="mb-4 text-xl font-semibold text-white sm:text-2xl md:mb-6">Profil Saya
            </h2>

            <div class="py-4 md:py-8">
                <div class="mb-4 grid gap-4 sm:grid-cols-2 sm:gap-8 lg:gap-16">
                    <div class="space-y-4">
                        <div class="flex space-x-4 items-center">
                            <img class="h-16 w-16 rounded-lg" src="{{ asset('images/blank-profile.png') }}"
                                alt="{{ $user->name }} avatar" />
                            <div>

                                <h2 class="flex items-center text-xl font-bold leading-none text-white sm:text-2xl">
                                    {{ $user->name }}</h2>
                            </div>
                        </div>
                        <dl class="">
                            <dt class="font-semibold text-white">Email</dt>
                            <dd class=" text-gray-400">{{ $user->email }}</dd>
                        </dl>

                    </div>

                </div>
                <button type="button" data-modal-target="accountInformationModal2"
                    data-modal-toggle="accountInformationModal2"
                    class="inline-flex w-full items-center justify-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 bg-primary-600 hover:bg-primary-700 focus:ring-primary-800 sm:w-auto"
                    style="background-color: black">
                    <svg class="-ms-0.5 me-1.5 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z">
                        </path>
                    </svg>
                    Edit your data
                </button>
            </div>

        </div>
        <!-- Account Information Modal -->
        <div id="accountInformationModal2" tabindex="-1" aria-hidden="true"
            class="max-h-auto fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden antialiased md:inset-0">
            <div class="max-h-auto relative max-h-full w-full max-w-lg p-4">
                <!-- Modal content -->
                <div class="relative rounded-lg shadow bg-gray-800">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between rounded-t border-b  p-4 border-gray-700 md:p-5">
                        <h3 class="text-lg font-semibold text-white">Informasi Akun</h3>
                        <button type="button"
                            class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400  hover:bg-gray-600 hover:text-white"
                            data-modal-toggle="accountInformationModal2">
                            <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form class="p-4 md:p-5" method="post" action="{{ route('user.update') }}">
                        @csrf
                        <div class="mb-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div class="col-span-2 sm:col-span-1">
                                <label for="full_name_info_modal" class="mb-2 block text-sm font-medium  text-white">
                                    Nama Lengkap
                                </label>
                                <input type="text" id="full_name_info_modal"
                                    class="block w-full rounded-lg border   p-2.5 text-sm focus:border-primary-500 focus:ring-primary-500 border-gray-600 bg-gray-700 text-white placeholder:text-gray-400 focus:border-primary-500 focus:ring-primary-500"
                                    name="name" placeholder="Masukkan nama lengkap anda" value="{{ $user->name }}"
                                    required />
                                @error('name')
                                    <p class="text-center text-red-700">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="password_info_modal" class="mb-2 block text-sm font-medium  text-white">
                                    Password Baru*
                                </label>
                                <input type="password" id="password_info_modal"
                                    class="block w-full rounded-lg border p-2.5 text-sm focus:border-primary-500 focus:ring-primary-500 border-gray-600 bg-gray-700 text-white placeholder:text-gray-400 focus:border-primary-500 focus:ring-primary-500"
                                    name="password" required />
                                @error('password')
                                    <p class="text-center text-red-700">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="confirm_password_info_modal"
                                    class="mb-2 block text-sm font-medium text-white"> Konfirmasi
                                    Password Baru*
                                </label>
                                <input type="password" id="confirm_password_info_modal"
                                    class="block w-full rounded-lg border p-2.5 text-sm focus:border-primary-500 focus:ring-primary-500 border-gray-600 bg-gray-700 text-white placeholder:text-gray-400 focus:border-primary-500 focus:ring-primary-500"
                                    name="password_confirmation" required />
                                @error('password')
                                    <p class="text-center text-red-700">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="border-t  pt-4 border-gray-700 md:pt-5">
                            <button type="submit"
                                class="me-2 inline-flex items-center rounded-lg bg-primary-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 bg-primary-600 hover:bg-primary-700 focus:ring-primary-800"
                                style="background-color: black;">Simpan</button>
                            <button type="button" data-modal-toggle="accountInformationModal2"
                                class="me-2 rounded-lg border px-5 py-2.5 text-sm font-medium hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 border-gray-600 bg-gray-800 text-gray-400 hover:bg-gray-700 hover:text-white focus:ring-gray-700">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </section>
</x-app-layout>
