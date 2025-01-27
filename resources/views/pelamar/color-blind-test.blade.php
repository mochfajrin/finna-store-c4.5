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
    <section class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-12">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <!-- Heading & Filters -->
            <div class="mb-4 items-end justify-center space-y-4 sm:flex sm:space-y-0 md:mb-8">
                <div>
                    <h2 class="mt-3 text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Tes Buta
                        Warna</h2>
                </div>
            </div>
            <p class="font-bold" id="timer"></p>
            <form action="" method="post">
                <div class="mb-4 grid gap-4 sm:grid-cols-2 md:mb-8 lg:grid-cols-3 xl:grid-cols-4">
                    @for ($i = 1; $i <= 10; $i++)
                        <div
                            class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                            <div class="h-56 w-full">
                                <img class="mx-auto h-full dark:hidden"
                                    src="{{ asset("images/tes/colorblind-test-image$i.webp") }}" alt="" />
                            </div>
                            <div class="pt-6">
                                <input type="text" id="first_name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="John" />
                            </div>
                        </div>
                    @endfor
                </div>
                <div class="w-full text-center">
                    <button id="submitBtn" type="submit"
                        class="rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700">Simpan
                        Jawaban</button>
                </div>
            </form>
        </div>

    </section>
    <script>
        const timer = document.getElementById('timer');
        const startTime = document.getElementById('startTime');
        const endTime = document.getElementById('endTime');
        const testStart = Date.now();
        const submitBtn = document.getElementById("submitBtn");
        const endTest = testStart + 3600000;

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
