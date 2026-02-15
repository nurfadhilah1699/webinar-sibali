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

    .container { 
        position: relative; 
        width: 100%; height: 
        100%; 
    }

    .background { 
        position: absolute; 
        width: 100%; 
        height: 100%; 
        z-index: -1; 
    }
    
    .name { 
        position: absolute; 
        top: 32%;
        width: 100%; 
        text-align: center; 
        font-size: 35pt; 
        font-weight: medium; 
        font-family: 'NameFont', serif;
        text-transform: uppercase;
    }

    /* Container utama untuk memposisikan tabel */
    .score-container {
        position: absolute;
        top: 61%; /* Geser naik/turun tabel secara keseluruhan di sini */
        left: 57%;  /* Geser kiri/kanan tabel secara keseluruhan di sini */
        width: 150px;
    }

    .score-table {
        width: 100%;
        border-collapse: collapse;
    }

    .score-table td {
        /* Padding ini yang akan menjaga jarak antar baris agar pas dengan background */
        padding-bottom: 6.5px; 
        padding-top: 1px; /* Tambahkan padding atas untuk menjaga jarak antar baris */
        font-family: Arial, sans-serif;
        font-weight: bold;
        font-size: 16px;
        color: black;
        vertical-align: middle;
    }

    .total-score-cell {
        /* Jarak khusus untuk baris Total Score jika posisinya agak jauh di bawah */
        padding-top: 1.5px;
        font-size: 19px;
    }

    .id-cert { 
        position: absolute; 
        bottom: 78px; 
        left: 226px; 
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11px; 
    }
</style>

<body>
    @php
        /* PERBAIKAN 2: Path Gambar menggunakan DOCUMENT_ROOT */
        $path = $_SERVER['DOCUMENT_ROOT'] . '/img/toefl.jpeg';
        
        if (file_exists($path)) {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        } else {
            // Fallback jika file tidak ditemukan agar tidak error 500
            $base64 = '';
        }
    @endphp

    <div class="container">
        <img src="{{ $base64 }}" class="background">
        <div class="name">{{ $name }}</div>
        
        <div class="score-container">
            <table class="score-table">
                <tr>
                    <td>{{ $listening }}</td>
                </tr>
                <tr>
                    <td>{{ $structure }}</td>
                </tr>
                <tr>
                    <td>{{ $reading }}</td>
                </tr>
                <tr>
                    <td class="total-score-cell">{{ $score }}</td>
                </tr>
            </table>
        </div>

        <div class="id-cert">{{ $id_sertifikat }}</div>
    </div>
</body>