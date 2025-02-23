<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberitahuan Penerimaan Karyawan {{ config('app.name') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #0077b6;
        }

        .header h1 {
            color: #0077b6;
        }

        .content {
            padding: 20px 0;
        }

        .content p {
            line-height: 1.6;
            color: #333;
        }

        .footer {
            text-align: center;
            padding-top: 20px;
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            @if ($data['status'])
                <h1>Selamat! Anda Diterima</h1>
            @else
                <h1>Terima Kasih Atas Lamaran Anda</h1>
            @endif
        </div>
        @if ($data['status'])
            <div class="content">
                <p>Kepada Yth. <strong>{{ $data['name'] }}</strong>,</p>
                <p>Kami dengan senang hati menginformasikan bahwa Anda telah diterima untuk bergabung dengan tim kami di
                    <strong>{{ config('app.name') }}</strong> sebagai <strong>{{ $data['role'] }}</strong>.
                </p>
                <p>Selanjutnya, kami akan menghubungi Anda untuk proses orientasi dan kelengkapan administrasi. Silakan
                    menghubungi tim HRD kami jika ada pertanyaan lebih lanjut.</p>
                <p>Selamat bergabung! Kami sangat antusias untuk bekerja sama dengan Anda.</p>
                <p>Salam hangat,<br>
                    Tim Recruitment<br>
                    {{ config('app.name') }}
                </p>
            </div>
        @else
            <div class="content">
                <p>Kepada Yth. <strong>{{ $data['name'] }}</strong>,</p>
                <p>Terima kasih telah meluangkan waktu untuk melamar posisi <strong>{{ $data['role'] }}</strong> di
                    <strong>{{ config('app.name') }}</strong>. Kami sangat menghargai minat dan usaha Anda.
                </p>
                <p>Setelah mempertimbangkan dengan saksama, kami memutuskan untuk melanjutkan proses rekrutmen dengan
                    kandidat lain. Namun, kami akan menyimpan data Anda dan tidak menutup kemungkinan untuk bekerja sama
                    di masa mendatang.</p>
                <p>Kami mengucapkan semoga sukses dalam perjalanan karier Anda ke depannya.</p>
                <p>Salam hangat,<br>
                    Tim Recruitment<br>
                    {{ config('app.name') }}
                </p>
            </div>
        @endif
        <div class="footer">
            <p>Hak Cipta &copy; {{ $data['year'] }} {{ config('app.name') }}. Semua Hak Dilindungi.</p>
        </div>
    </div>
</body>

</html>
