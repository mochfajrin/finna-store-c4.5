<x-app-layout title="About">
    <section class="py-24 relative xl:mr-0 lg:mr-5 mr-0">
        <div class="w-full max-w-7xl px-4 md:px-5 lg:px-5 mx-auto">
            <div class="w-full justify-start items-center xl:gap-12 gap-10 grid lg:grid-cols-2 grid-cols-1">
                <div class="w-full flex-col justify-center lg:items-start items-center gap-10 inline-flex">
                    <div class="w-full flex-col justify-center items-start gap-8 flex">
                        <div class="flex-col justify-start lg:items-start items-center gap-10 flex">
                            <div class="w-full flex-col justify-start lg:items-start items-center gap-3 flex">
                                <h2
                                    class="text-indigo-400 text-4xl font-bold font-manrope leading-normal lg:text-start text-center">
                                    Visi dan Misi Perusahaan</h2>
                                <p class="text-gray-100 text-base font-normal leading-relaxed lg:text-start text-center">
                                    Finna Store percaya bahwa suatu keberhasilan dalam perkembangan perusahaan sangat
                                    bergantung seberapa kuat dalam menjalankan pedoman Visi, Misi, dan Nilai-nilai yang
                                    ada dari dalam organisasinya.</p>
                            </div>
                            <div class="w-full flex-col justify-start lg:items-start items-center gap-3 flex">
                                <h2
                                    class="text-indigo-400 text-4xl font-bold font-manrope leading-normal lg:text-start text-center">
                                    Tentang Perusahaan</h2>
                                <p
                                    class="text-gray-100 text-base font-normal leading-relaxed lg:text-start text-center">
                                    Finna Store berdiri pada tanggal 01 Oktober 2015 perusahaan yang didirikan oleh Ibu
                                    Finna Agustias selaku Direktur yang berkedudukan di Kota Lamongan. Finna Store
                                    adalah perusahaan yang bergerak dibidang distributor barang Scincare yang
                                    berkotmitmen untuk menjadi salah satu perusahaan distributor terbesar yang unggul
                                    dalam rangka persaingan dengan menyediakan Produk yang berkualitas.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full lg:justify-start justify-center items-start flex">
                    <div
                        class="sm:w-[564px] w-full sm:h-[646px] h-full sm:bg-gray-100 rounded-3xl sm:border border-gray-200 relative">
                        <img class="sm:mt-5 sm:ml-5 w-full h-full rounded-3xl object-cover"
                            src="{{ asset('images/about.jpg') }}" alt="about Us image" />
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
