<style>
    @font-face {
        font-family: 'NameFont';
        src: url("{{ public_path('fonts/EBGaramond.ttf') }}") format('truetype');
        font-weight: medium;
        font-style: normal;
    }

    @page {
        margin: 0;
        size: landscape; /* Memastikan PDF otomatis landscape */
    }

    body {
        margin: 0;
    }

    .background {
        position: absolute;
        width: 100%;
        height: 100%;
        z-index: -1;
    }

    .name {
        position: absolute;
        top: 42%; /* Angka ini harus kamu tes, ubah pelan-pelan sampai pas di garis */
        left: 0;
        width: 100%;
        text-align: center;
        text-transform: uppercase;
        font-family: 'NameFont', serif;
        font-size: 35pt;
        font-weight: medium;
        color: #000000;
    }
</style>

<body>
    @php
        // Pastikan nama file di folder public/img/ adalah 'peserta.jpeg'
        // Jika namanya 'peserta copy.jpg.jpeg', ganti di bawah sesuai nama aslinya
        $path = public_path('img/peserta.jpeg');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    @endphp

    <img src="{{ $base64 }}" class="background">

    <div class="name">
        {{ $name }}
    </div>
</body>