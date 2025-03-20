# Aplikasi Keuangan Software House

Aplikasi manajemen keuangan untuk Software House yang membantu dalam pengelolaan transaksi keuangan, proyek, dan karyawan.

## Fitur

- 📊 Dashboard dengan ringkasan keuangan
- 💼 Manajemen Proyek
- 💰 Pencatatan Transaksi (Pemasukan & Pengeluaran)
- 👥 Manajemen Karyawan
- 📝 Pengelolaan Biaya Operasional
- 📈 Laporan Keuangan:
  - Arus Kas
  - Pendapatan
  - Biaya
  - Laba Rugi

## Teknologi

- Laravel
- MySQL
- Bootstrap 5
- Font Awesome
- Chart.js

## Persyaratan Sistem

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL

## Instalasi

1. Clone repositori
```bash
git clone https://github.com/username/app-akunting.git
cd app-akunting
```

2. Install dependensi PHP
```bash
composer install
```

3. Install dependensi Node.js
```bash
npm install
```

4. Salin file .env
```bash
cp .env.example .env
```

5. Generate key aplikasi
```bash
php artisan key:generate
```

6. Konfigurasi database di file .env
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=username
DB_PASSWORD=password
```

7. Jalankan migrasi database
```bash
php artisan migrate --seed
```

8. Jalankan server development
```bash
php artisan serve
```

## Penggunaan

1. Login dengan kredensial default:
   - Email: admin@example.com
   - Password: 12345678

2. Mulai dengan menambahkan data:
   - Tambah Proyek
   - Tambah Karyawan
   - Catat Transaksi

3. Lihat laporan keuangan di menu Laporan

## Kontribusi

Silakan berkontribusi dengan membuat pull request. Untuk perubahan besar, harap buka issue terlebih dahulu untuk mendiskusikan perubahan yang diinginkan.

## Lisensi

[MIT License](LICENSE)

## Kontak

Untuk pertanyaan dan dukungan, silakan hubungi:
- Email: aqrist@gmail.com