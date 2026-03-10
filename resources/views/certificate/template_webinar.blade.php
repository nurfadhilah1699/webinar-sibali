<style>
    @font-face {
        font-family: 'NameFont';
        src: url("data:font/truetype;base64,{{ base64_encode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/fonts/EBGaramond.ttf')) }}") format('truetype');
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
        /* PERBAIKAN 2: Path Gambar menggunakan DOCUMENT_ROOT */
        $path = $_SERVER['DOCUMENT_ROOT'] . '/img/peserta.jpeg';
        
        if (file_exists($path)) {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        } else {
            // Fallback jika file tidak ditemukan agar tidak error 500
            $base64 = '';
        }
    @endphp

    <img src="{{ $base64 }}" class="background">

    <div class="name">
        {{ $name }}
    </div>
</body>