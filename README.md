# Webinar Sibali (Using Laravel Breeze)

Aplikasi manajemen webinar dan ujian Ukbing yang dibangun dengan framework Laravel dan starter kit Breeze untuk sistem autentikasi yang cepat dan aman.

## 🛠️ Prasyarat (Prerequisites)
Pastikan perangkat Anda sudah terpasang:
- **PHP** (v8.1 ke atas)
- **Composer**
- **Node.js & NPM**
- **MySQL/MariaDB**

## 📥 Langkah Instalasi

1. **Clone Repositori**
   ```bash
   git clone https://github.com/nurfadhilah1699/webinar-sibali.git
   cd project-webinar
2. **Install Composer**
    ```bash
    composer install
3. **Install Dependensi Frontend (NPM)**
    ```bash
    npm install
    npm run build
4. **Konfigurasi Environment**
    ```bash
    cp .env.example .env
    php artisan key:generate
5. **Setup Database**
    ```bash
    php artisan migrate
6. **Link Storage**
    ```bash
    php artisan storage:link
7. **Jalankan Server**
    ```bash
    php artisan serve

🔑 Akun Demo (Cek AdminSeeder)
Admin: admin@sibali.id / password : sibali123

🚀 Fitur yang Diimplementasikan (Breeze Power)
Auth System: Login, Register, Password Reset menggunakan Laravel Breeze.

Role Management: Pembedaan akses antara Peserta Reguler, Peserta VIP, dan Admin.

TOEFL Dashboard: Halaman khusus ujian yang muncul setelah status VIP diverifikasi.

Responsive UI: Menggunakan Tailwind CSS bawaan Breeze.