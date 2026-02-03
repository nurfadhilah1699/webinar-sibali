<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 0; }
        body { 
            font-family: 'Helvetica', sans-serif; 
            margin: 0; 
            padding: 0; 
            background-color: #ffffff;
        }
        .container {
            width: 100%;
            height: 100%;
            border: 25px solid #1e3a8a; /* Border Biru Navy Utama */
            box-sizing: border-box;
            position: relative;
            background-color: white;
        }
        .accent-red {
            position: absolute;
            top: 0;
            right: 0;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 0 150px 150px 0;
            border-color: transparent #ef4444 transparent transparent; /* Aksen Merah Pojok */
        }
        .content {
            padding: 60px;
            text-align: center;
        }
        .title { 
            font-size: 65px; 
            color: #1e3a8a; 
            font-weight: 900; 
            margin-bottom: 0;
            letter-spacing: 2px;
        }
        .subtitle { 
            font-size: 22px; 
            color: #ef4444; 
            margin-top: -10px; 
            font-weight: bold;
            letter-spacing: 8px;
            text-transform: uppercase;
        }
        .text-given { 
            margin-top: 40px; 
            font-size: 20px; 
            color: #4b5563; 
            font-style: italic;
        }
        .name { 
            font-size: 48px; 
            font-weight: bold; 
            color: #111827; 
            margin: 15px 0;
            border-bottom: 3px double #1e3a8a;
            display: inline-block;
            padding: 0 40px;
        }
        .event-detail { 
            margin-top: 30px; 
            font-size: 18px; 
            color: #374151; 
            line-height: 1.6;
        }
        .highlight { color: #1e3a8a; font-weight: bold; }

        /* Score Box - Tema Merah Putih Biru */
        .score-container {
            margin-top: 40px;
            display: inline-block;
            background-color: #1e3a8a;
            padding: 2px;
            border-radius: 8px;
        }
        .score-inner {
            background-color: white;
            padding: 15px 40px;
            border-radius: 6px;
            border: 2px solid #ef4444;
        }
        .score-label { font-size: 14px; color: #1e3a8a; font-weight: bold; margin-bottom: 5px; }
        .score-value { font-size: 36px; font-weight: 900; color: #ef4444; }

        .footer { 
            margin-top: 80px; 
            font-size: 14px; 
            color: #6b7280; 
            position: relative;
        }
        .signature-line {
            width: 200px;
            margin: 0 auto 10px;
            border-bottom: 1px solid #1e3a8a;
        }
        .id-cert { 
            position: absolute;
            bottom: 30px;
            left: 30px;
            font-family: monospace; 
            font-size: 10px; 
            color: #9ca3af; 
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="accent-red"></div>
        
        <div class="content">
            <div class="title">CERTIFICATE</div>
            <div class="subtitle">Of Appreciation</div>
            
            <div class="text-given">This certificate is proudly awarded to:</div>
            <div class="name">{{ $name }}</div>
            
            <div class="event-detail">
                Atas partisipasinya dalam kegiatan <span class="highlight">Webinar Nasional Beasiswa LPDP & Simulasi Tes Ukbing</span><br>
                Sebagai Peserta Terverifikasi Paket <span class="highlight text-uppercase">{{ $package }}</span>
            </div>

            <div class="footer">
                <div class="signature-line"></div>
                <strong>Sibali.Id</strong><br>
                Diterbitkan pada {{ date('d F Y') }}
            </div>
        </div>
        
        <div class="id-cert">Verification ID: SIBALI.ID-{{ $id_sertifikat }}-{{ date('Ymd') }}</div>
    </div>
</body>
</html>