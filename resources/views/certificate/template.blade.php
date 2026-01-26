<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica', sans-serif; text-align: center; padding: 50px; border: 10px solid #4F46E5; }
        .title { font-size: 50px; color: #1e1b4b; margin-bottom: 0; }
        .subtitle { font-size: 20px; color: #4b5563; margin-top: 0; }
        .content { margin-top: 50px; font-size: 24px; }
        .name { font-size: 40px; font-weight: bold; color: #4F46E5; text-decoration: underline; margin: 20px 0; }
        .footer { margin-top: 100px; font-size: 16px; color: #9ca3af; }
        .id-cert { font-family: monospace; font-size: 12px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="title">SERTIFIKAT</div>
    <div class="subtitle">PENGHARGAAN</div>
    
    <div class="content">
        Diberikan kepada:
        <div class="name">{{ $name }}</div>
        Atas partisipasinya dalam kegiatan <strong>Webinar Bersama Awardee Beasiswa LPDP</strong><br>
        Sebagai Peserta Paket <strong>{{ $package }}</strong>
    </div>

    <div class="footer">
        Diterbitkan pada {{ $date }} <br>
        <strong>Sibali.Id</strong>
    </div>
    
    <div class="id-cert">ID: {{ $id_sertifikat }}</div>
</body>
</html>