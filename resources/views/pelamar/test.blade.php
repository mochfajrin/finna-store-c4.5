<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,
								initial-scale=1.0">
    <title>Soal Tes buta Warna | {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="from-gray-100 via-gray-400 to-gray-500">
    <section class="bg-slate-800 py-8 antialiased dark:bg-gray-900 md:py-12">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <div class="mb-4 items-end justify-center space-y-4 sm:flex sm:space-y-0 md:mb-8">
                <div>
                    <h2 class="mt-3 text-xl font-semibold text-white sm:text-2xl">Tes Buta
                        Warna</h2>
                </div>
            </div>
            <p class="font-bold my-5 text-white" id="timer"></p>
            <form
                action="{{ route('pelamar.test-submit', [
                    'colorBlindPayload' => $encryptedColorBlindTestPayload,
                    'abilityPayload' => $encryptedAbilityTestPayload,
                ]) }}"
                method="post">
                @csrf
                <div class="mb-4 grid gap-4 sm:grid-cols-2 md:mb-8 lg:grid-cols-3 xl:grid-cols-4">
                    @for ($i = 1; $i <= 10; $i++)
                        <div class="rounded-lg border p-6 shadow-sm border-gray-700 bg-gray-800">
                            <p class="font-bold text-white">{{ $i }}</p>
                            <div class="h-56 w-full">
                                <img class="mx-auto h-full dark:hidden"
                                    src="{{ asset("images/tes/colorblind-test-image$i.webp") }}" alt="" />
                            </div>
                            <div class="pt-6">
                                <input type="text" id="jawaban-buta-warna-{{ $i }}"
                                    name="jawaban-buta-warna-{{ $i }}"
                                    class="border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Jawab pertanyaan diatas" required />
                            </div>
                        </div>
                    @endfor
                </div>
                <div class="mb-4 items-end justify-center space-y-4 sm:flex sm:space-y-0 md:mb-8">
                    <div>
                        <h2 class="mt-3 text-xl font-semibold text-white sm:text-2xl">Tes Kemampuan
                        </h2>
                    </div>
                </div>
                <div class="mb-4 grid gap-4 sm:grid-cols-2 md:mb-8 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach ($ability_questions as $i => $question)
                        <div class="rounded-lg border p-6 shadow-sm border-gray-700 bg-gray-800">
                            <p class="font-bold text-white">{{ $i + 1 }}</p>
                            <div class="w-full text-white">
                                <p>{{ $question['question'] }}</p>
                            </div>
                            <div class="pt-6">
                                @foreach ($question['options'] as $key => $options)
                                    <div class="flex items-center">
                                        <input id="jawaban-kemampuan-{{ $i + 1 . $key }}" type="radio"
                                            value="{{ $key }}" name="jawaban-kemampuan-{{ $i + 1 }}"
                                            class="w-4 h-4 text-white focus:ring-white ring-offset-gray-800 ring-2 bg-gray-700 border-gray-600"
                                            required>
                                        <label for="jawaban-kemampuan-{{ $i + 1 . $key }}"
                                            class="ms-2 text-sm font-medium text-gray-300">{{ $key }}.
                                            {{ $options }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="w-full text-center">
                    <button id="submitBtn" type="submit"
                        class="rounded-lg border px-5 py-2.5 text-sm font-medium hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 dark:border-gray-600 bg-gray-800 text-gray-400 hover:bg-gray-700 hover:text-white focus:ring-gray-700">Simpan
                        Jawaban</button>
                </div>
            </form>
        </div>

    </section>
    <script>
        const timer = document.getElementById('timer');
        const startTime = document.getElementById('startTime');
        const endTime = document.getElementById('endTime');
        const testStart = {{ $tes->start_at }};
        const submitBtn = document.getElementById("submitBtn");
        const endTest = {{ $tes->end_at }};

        let restOfTime = endTest - Date.now();
        const timerInterval = setInterval(() => {
            restOfTime -= 1000;
            timer.textContent = `Sisa Waktu ${Math.ceil(restOfTime / 60000)} Menit`;
            if (restOfTime <= 0) {
                submitBtn.click();
                clearInterval(timerInterval);
            }
        }, 1000);
    </script>
</body>

</html>
