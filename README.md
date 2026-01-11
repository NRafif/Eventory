# Eventory

Eventory adalah platform Sistem Manajemen Acara berbasis web yang dirancang untuk memfasilitasi pengelolaan acara secara terpusat. Aplikasi ini menghubungkan tiga pemangku kepentingan utama: Administrator, Penyelenggara (Organizer), dan Peserta, guna menciptakan ekosistem manajemen acara yang efisien, transparan, dan modern.

## Latar Belakang dan Tujuan

Dalam penyelenggaraan acara, pengelolaan informasi, pendaftaran peserta, dan koordinasi antar pihak seringkali menjadi tantangan. Eventory hadir untuk menjawab kebutuhan tersebut dengan menyediakan solusi digital yang memungkinkan:
- **Administrator** untuk memiliki kendali penuh atas sistem dan pengawasan operasional.
- **Penyelenggara** untuk mengelola acara, memantau kuota, dan menganalisis partisipasi peserta secara mandiri.
- **Peserta** untuk mencari, mendaftar, dan mengelola riwayat keikutsertaan mereka dalam berbagai acara dengan mudah.

## Fitur Utama

Aplikasi ini menyediakan fitur-fitur yang dikelompokkan berdasarkan peran pengguna:

### Administrator
- **Dashboard**: Menyajikan statistik ringkas mengenai sistem.
- **Manajemen Acara**: Melakukan pengawasan penuh (membuat, menyunting, menghapus) terhadap seluruh acara yang terdaftar.
- **Manajemen Penyelenggara**: Mengelola akun penyelenggara (Create, Read, Update, Delete).
- **Laporan dan Audit**: Memantau status seluruh acara (Draft, Published, Completed, Cancelled).

### Penyelenggara (Organizer)
- **Manajemen Acara Mandiri**: Membuat dan mengelola acara yang diselenggarakan oleh pihak mereka sendiri.
- **Monitoring Kuota Real-time**: Memantau perkembangan jumlah pendaftar melalui indikator visual.
- **Kontrol Publikasi**: Mengatur status acara, mulai dari persiapan (Draft) hingga siap dipublikasikan (Published).

### Peserta (Participant)
- **Katalog Acara**: Menjelajahi daftar acara yang tersedia untuk publik.
- **Sistem Pendaftaran**: Mendaftar pada acara yang diminati selama kuota tersedia.
- **Riwayat Partisipasi**: Mengakses daftar acara yang telah diikuti sebelumnya.

### Keamanan dan Sistem
- **Otentikasi Aman**: Sistem login dan registrasi terintegrasi.
- **Kontrol Akses Berbasis Peran**: Validasi akses (Middleware) untuk memastikan keamanan data antar pengguna.
- **Validasi Data**: Mekanisme validasi input yang ketat untuk menjaga integritas data (misalnya validasi kuota dan tanggal).

## Teknologi yang Digunakan

Proyek ini dikembangkan menggunakan teknologi standar industri modern:
- **Framework Backend**: Laravel 12 (PHP 8.2+)
- **Antarmuka Pengguna**: Blade Templates
- **Styling**: Tailwind CSS
- **Database**: MySQL (via Eloquent ORM)

## Persyaratan Sistem

Sebelum menjalankan aplikasi, pastikan perangkat Anda telah memenuhi persyaratan berikut:
- PHP versi 8.2 atau lebih baru
- Composer
- Node.js dan NPM
- Database MySQL

## Panduan Instalasi dan Penggunaan

Ikuti langkah-langkah berikut untuk menjalankan proyek di lingkungan lokal Anda:

1.  **Duplikasi Repositori**
    Salin kode sumber proyek ke direktori lokal Anda.

2.  **Instalasi Dependensi PHP**
    Jalankan perintah berikut untuk mengunduh pustaka yang dibutuhkan oleh Laravel:
    ```bash
    composer install
    ```

3.  **Konfigurasi Lingkungan (`.env`)**
    Salin file contoh konfigurasi `.env.example` menjadi `.env`:
    ```bash
    cp .env.example .env
    ```
    Buka file `.env` dan sesuaikan konfigurasi database Anda (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

4.  **Generate Application Key**
    Buat kunci enkripsi aplikasi baru:
    ```bash
    php artisan key:generate
    ```

5.  **Migrasi Database**
    Jalankan migrasi untuk membuat tabel-tabel yang diperlukan di database:
    ```bash
    php artisan migrate
    ```

6.  **Instalasi Dependensi Frontend**
    Unduh dan kompilasi aset frontend (CSS/JS):
    ```bash
    npm install
    npm run build
    ```

7.  **Menjalankan Server Lokal**
    Mulai server pengembangan lokal:
    ```bash
    php artisan serve
    ```
    Aplikasi dapat diakses melalui browser pada alamat yang tertera (biasanya `http://localhost:8000`).
