# 🧺 BatiKa — E-Commerce Batik Indonesia

BatiKa adalah platform e-commerce berbasis web yang dirancang khusus untuk mempromosikan dan mempermudah transaksi jual-beli produk kain serta busana Batik khas Nusantara. Platform ini menghadirkan pengalaman berbelanja modern, responsif, dan intuitif bagi para pencinta warisan budaya Indonesia.

---

## 🚀 Fitur Utama

- **Katalog Produk & Detail Batik:** Penjelajahan produk batik berdasarkan kategori, jenis kain, motif, dan rentang harga.

- **Keranjang Belanja (Shopping Cart):** Pengelolaan barang belanjaan yang interaktif (tambah, kurangi, hapus produk).

- **Sistem Checkout & Transaksi:** Alur pemesanan produk yang terstruktur dan siap terintegrasi dengan Payment Gateway.

- **Manajemen Akun User:** Registrasi, login, dan riwayat pesanan bagi para pelanggan.

- **Dashboard Admin:** Pengelolaan data produk, stok, kategori, dan pemantauan transaksi masuk.

- **Desain Responsif & Modern:** Tampilan UI/UX yang dioptimalkan untuk perangkat mobile, tablet, maupun desktop.

---

## 🛠️ Teknologi yang Digunakan

- **Frontend:** HTML5, CSS3, JavaScript (ES6+), Tailwind CSS / Bootstrap

- **Backend:** PHP / Laravel

- **Database:** MySQL

- **Tools & Version Control:** Git, GitHub, VS Code

---

## ⚙️ Panduan Instalasi & Penggunaan Lokal

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lingkungan lokal Anda:

### 1. Prasyarat System

Pastikan perangkat Anda sudah terpasang:
- Git
- Web Server Lokal (XAMPP / Laragon / PHP & Composer)
- Node.js & NPM

### 2. Kloning Repositori

Jalankan perintah berikut di terminal:

git clone https://github.com/Ferdiansyah18/BatiKa-E-Commerce.git

cd BatiKa-E-Commerce

### 3. Pengaturan Lingkungan (Environment)

Salin file `.env.example` menjadi `.env`:

cp .env.example .env

Sesuaikan konfigurasi database pada file `.env`:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=batika_db
DB_USERNAME=root
DB_PASSWORD=

### 4. Instalasi Dependensi & Database

Jalankan perintah berikut secara berurutan di terminal:

# Install dependensi backend
composer install

# Generate application key
php artisan key:generate

# Install dependensi frontend & build asset
npm install
npm run dev

# Jalankan migrasi database
php artisan migrate --seed

### 5. Jalankan Server Lokal

php artisan serve

Akses aplikasi melalui browser di `http://127.0.0.1:8000`.

---

## 📂 Struktur Direktori Utama

- **app/** : Logika aplikasi (Controllers, Models, Middleware)
- **database/** : File Migrasi & Seeders database
- **public/** : Asset publik (Gambar, CSS, JS terkompilasi)
- **resources/** : Views (Blade templates/Components) & Asset mentah
- **routes/** : Definisi route aplikasi (web.php, api.php)
- **storage/** : File upload & log sistem

---

## 📄 Lisensi

Proyek ini dibuat untuk tujuan pengembangan dan pembelajaran. Didistribusikan di bawah lisensi [MIT License](LICENSE).

---

## 👨‍💻 Kontributor

- **Ferdiansyah** - *Lead Developer / Designer* - [@Ferdiansyah18](https://github.com/Ferdiansyah18)
