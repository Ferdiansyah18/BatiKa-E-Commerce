# 🚀 Panduan Deploy BatiKa — Vercel + MySQL + Firebase Storage

Dokumen ini menjelaskan cara men-deploy aplikasi **BatiKa** (Laravel 11) ke **Vercel**, dengan **database MySQL** eksternal dan **Firebase Storage** untuk menyimpan gambar unggahan.

> **Catatan penting:** BatiKa adalah aplikasi Laravel monolith (Blade + backend dalam satu project). Karena itu:
>
> - Seluruh aplikasi (frontend **dan** backend) berjalan sebagai satu container Laravel di Vercel.
> - **Firebase tidak bisa menjadi backend/database** untuk Laravel: Cloud Functions tidak mendukung PHP, dan Firestore (NoSQL) tidak kompatibel dengan Eloquent/MySQL. Jadi Firebase dipakai untuk **Storage** (gambar), sesuai kesepakatan.
> - Database memakai **MySQL terkelola** (Aiven/Railway/TiDB), bukan Firebase.

---

## 1. Arsitektur akhir

```
┌──────────────────────────────────────────────┐
│                  Browser                     │
└───────────────────┬──────────────────────────┘
                    │ HTTPS
                    ▼
┌──────────────────────────────────────────────┐
│  Vercel (Container Function — FrankenPHP)    │
│  • Blade views + Vite assets                 │
│  • Laravel controllers, auth, session        │
└───────┬───────────────────────────┬──────────┘
        │                           │
        ▼                           ▼
┌──────────────────┐      ┌─────────────────────┐
│  MySQL (Aiven)   │      │ Firebase Storage    │
│  data & session  │      │ gambar produk/avatar│
└──────────────────┘      └─────────────────────┘
```

File yang ditambahkan untuk deployment:

| File | Fungsi |
|---|---|
| `Dockerfile` | Membangun image Laravel + FrankenPHP + asset Vite |
| `Caddyfile` | Web server yang menyajikan folder `public/` |
| `vercel.json` | Mendaftarkan container sebagai service Vercel |
| `.dockerignore` | Mengecualikan file lokal dari image |
| `.env.production.example` | Daftar lengkap environment variable produksi |
| `app/Support/FirebaseFilesystemAdapter.php` | Menghasilkan URL publik Firebase Storage |
| `.github/workflows/migrate.yml` | Menjalankan migrasi database dari GitHub Actions |

---

## 2. Prasyarat

- Akun **Vercel** (sudah punya).
- Akun **Firebase** (sudah punya).
- Akses push ke repo GitHub `Ferdiansyah18/BatiKa-E-Commerce`.
- Repo sudah berisi perubahan deployment ini (commit & push dulu).
- **Node.js** (untuk membuat `APP_KEY`). Tidak wajib memasang Docker atau Composer di komputer.

---

## 3. Siapkan database MySQL

Pilih salah satu penyedia. Contoh di bawah memakai **Aiven for MySQL (free plan)** karena paling mudah dan gratis.

### 3.1 Buat service MySQL di Aiven

1. Masuk ke <https://console.aiven.io>.
2. **Create service** → pilih **MySQL**.
3. Pilih plan **Free**, region terdekat (mis. `Singapore`), lalu **Create service**.
4. Tunggu sampai status **Running**.
5. Buka tab **Overview**, catat **Connection information**:
   - `Host`
   - `Port`
   - `User` (biasanya `avnadmin`)
   - `Password`
   - `Database name` (biasanya `defaultdb`)
6. Di bagian **CA Certificate**, klik **Download** untuk mengunduh file `ca.pem`.
7. Ubah base64 file CA tersebut:

   **Windows PowerShell**
   ```powershell
   [Convert]::ToBase64String([IO.File]::ReadAllBytes("ca.pem")) | Set-Clipboard
   ```

   **macOS / Linux**
   ```bash
   base64 -i ca.pem | tr -d '\n'
   ```

   Simpan hasilnya — akan dipakai sebagai `DB_SSL_CA_BASE64`.

> Alternatif penyedia MySQL: **Railway** (MySQL), **TiDB Cloud Serverless**, atau MySQL dari penyedia lain. Jika penyedia tidak mewajibkan TLS, `DB_SSL_CA_BASE64` boleh dikosongkan.

---

## 4. Siapkan Firebase Storage

### 4.1 Buat project & bucket

1. Buka <https://console.firebase.google.com>.
2. **Add project** → beri nama (mis. `batika-app`) → buat project.
3. Di menu kiri, buka **Build → Storage** → **Get started**.
4. Pilih lokasi bucket (mis. `asia-southeast2`) → **Done**.
5. Catat **bucket name**. Nama ini terlihat di tab **Files** (formatnya `gs://NAMA-BUCKET`).
   - Project baru: `nama-project.firebasestorage.app`
   - Project lama: `nama-project.appspot.com`

   **Gunakan nama bucket saja, tanpa awalan `gs://`.** Contoh yang benar: `batika-app.firebasestorage.app`.

### 4.2 Atur aturan baca publik

Gambar produk harus bisa dibaca tanpa login. Buka tab **Rules** pada Storage dan gunakan:

```
rules_version = '2';
service firebase.storage {
  match /b/{bucket}/o {
    match /{allPaths=**} {
      allow read: if true;
      allow write: if false;
    }
  }
}
```

Klik **Publish**.

> Penulisan file dilakukan oleh service account (IAM), sehingga **tidak** terpengaruh aturan `allow write: if false`. Aturan tersebut hanya memblokir penulisan dari browser.

### 4.3 Buat service account

1. Klik ⚙️ **Project settings** → tab **Service accounts**.
2. Klik **Generate new private key** → **Generate key**.
3. File JSON akan terunduh (mis. `batika-app-firebase-adminsdk-xxxxx.json`).
4. Ubah isinya menjadi base64:

   **Windows PowerShell**
   ```powershell
   [Convert]::ToBase64String([IO.File]::ReadAllBytes("NAMA-FILE.json")) | Set-Clipboard
   ```

   **macOS / Linux**
   ```bash
   base64 -i NAMA-FILE.json | tr -d '\n'
   ```

   Simpan hasilnya — ini akan menjadi `FIREBASE_CREDENTIALS_BASE64`.

> **Jangan commit file JSON service account ke GitHub.** File tersebut memberi akses penuh ke project Firebase.

---

## 5. Buat APP_KEY

Jalankan salah satu perintah berikut, lalu simpan hasilnya:

```bash
node -e "console.log('base64:' + require('crypto').randomBytes(32).toString('base64'))"
```

atau PowerShell:

```powershell
"base64:" + [Convert]::ToBase64String([Security.Cryptography.RandomNumberGenerator]::GetBytes(32))
```

Contoh hasil: `base64:8Xh...=`

---

## 6. Import project ke Vercel

1. Buka <https://vercel.com/new>.
2. Pilih **Import Git Repository** → repo `BatiKa-E-Commerce`.
3. Pada halaman konfigurasi:
   - **Root Directory** → pilih **`BatiKa Website`** (penting!).
   - **Framework Preset** → biarkan **Other**, Vercel akan mendeteksi `Dockerfile` dan memakai **Container**.
   - **Build & Output Settings** → biarkan default (Dockerfile yang menangani build).
4. Klik **Deploy**. Deploy pertama boleh gagal karena environment variable belum diisi — lanjutkan ke langkah 7 lalu redeploy.

> Jika Vercel tidak mendeteksi Dockerfile, buka **Project → Settings → General → Framework Preset** dan pilih **Container**.
>
> Container runtime Vercel masih berstatus **Beta** dan tersedia di semua plan.

---

## 7. Isi environment variable di Vercel

Buka **Project → Settings → Environment Variables**, lalu tambahkan satu per satu (pilih environment **Production**, boleh sekaligus **Preview**).

### 7.1 Aplikasi

| Name | Value |
|---|---|
| `APP_NAME` | `BatiKa` |
| `APP_ENV` | `production` |
| `APP_KEY` | hasil langkah 5 |
| `APP_DEBUG` | `false` |
| `APP_URL` | `https://<domain-vercel-anda>` |
| `APP_TIMEZONE` | `Asia/Jakarta` |
| `LOG_CHANNEL` | `stderr` |
| `LOG_LEVEL` | `warning` |

### 7.2 Database

| Name | Value |
|---|---|
| `DB_CONNECTION` | `mysql` |
| `DB_HOST` | host dari Aiven |
| `DB_PORT` | port dari Aiven |
| `DB_DATABASE` | `defaultdb` |
| `DB_USERNAME` | `avnadmin` |
| `DB_PASSWORD` | password dari Aiven |
| `DB_SSL_CA_BASE64` | hasil base64 `ca.pem` (opsional jika provider tidak butuh TLS) |

### 7.3 Session, cache, queue

| Name | Value |
|---|---|
| `SESSION_DRIVER` | `database` |
| `SESSION_SECURE_COOKIE` | `true` |
| `CACHE_STORE` | `database` |
| `QUEUE_CONNECTION` | `sync` |

### 7.4 Firebase Storage

| Name | Value |
|---|---|
| `FILESYSTEM_DISK` | `public` |
| `FIREBASE_PROJECT_ID` | ID project Firebase |
| `FIREBASE_STORAGE_BUCKET` | nama bucket (langkah 4.1) |
| `FIREBASE_CREDENTIALS_BASE64` | hasil base64 service account (langkah 4.3) |

### 7.5 Email (wajib untuk OTP registrasi)

| Name | Value |
|---|---|
| `MAIL_MAILER` | `smtp` |
| `MAIL_HOST` | mis. `smtp-relay.brevo.com` |
| `MAIL_PORT` | `587` |
| `MAIL_USERNAME` | username SMTP |
| `MAIL_PASSWORD` | password SMTP |
| `MAIL_ENCRYPTION` | `tls` |
| `MAIL_FROM_ADDRESS` | email pengirim terverifikasi |
| `MAIL_FROM_NAME` | `BatiKa` |

### 7.6 Midtrans

| Name | Value |
|---|---|
| `MIDTRANS_SERVER_KEY` | Server Key (sandbox/production) |
| `MIDTRANS_CLIENT_KEY` | Client Key |
| `MIDTRANS_IS_PRODUCTION` | `false` untuk sandbox, `true` untuk produksi |

Setelah semua variable diisi, buka tab **Deployments** → **Redeploy** deployment terakhir.

---

## 8. Jalankan migrasi database

Container tidak menjalankan migrasi otomatis (agar tidak bentrok saat banyak instance). Gunakan workflow GitHub Actions yang sudah disertakan.

### 8.1 Tambahkan repository secrets

Buka repo GitHub → **Settings → Secrets and variables → Actions → New repository secret**.

**Wajib:**

| Secret | Isi |
|---|---|
| `APP_KEY` | sama dengan `APP_KEY` di Vercel |
| `DB_HOST` | host MySQL |
| `DB_PORT` | port MySQL |
| `DB_DATABASE` | nama database |
| `DB_USERNAME` | user database |
| `DB_PASSWORD` | password database |

**Opsional:**

| Secret | Isi |
|---|---|
| `DB_SSL_CA_BASE64` | base64 `ca.pem` |
| `SEED_OWNER_EMAIL`, `SEED_OWNER_NAME`, `SEED_OWNER_PASSWORD` | kredensial owner |
| `SEED_ADMIN_EMAIL`, `SEED_ADMIN_NAME`, `SEED_ADMIN_PASSWORD` | kredensial admin |

### 8.2 Jalankan workflow

1. Buka tab **Actions** di repo GitHub.
2. Pilih **Database migrations** → **Run workflow**.
3. Centang **Run database seeders** pada run pertama (membuat role, kategori, dan akun owner/admin).
4. Klik **Run workflow** dan tunggu sampai hijau.

> Jika Anda lebih suka menjalankan dari komputer: pastikan PHP 8.2+ dan Composer terpasang, isi `.env` dengan kredensial produksi, lalu jalankan
> `php artisan migrate --force` dan `php artisan db:seed --force` dari folder `BatiKa Website`.

Setelah seed berhasil, **hapus** secret `SEED_*` dari GitHub dan Vercel agar tidak tersimpan permanen.

---

## 9. Verifikasi

1. Buka `https://<domain-vercel-anda>` — halaman utama harus tampil.
2. Buka `https://<domain-vercel-anda>/up` — harus mengembalikan status `200`.
3. Login admin:
   - URL: `/login`
   - Email: nilai `SEED_ADMIN_EMAIL` (default `admin@batika.com`)
   - Password: nilai `SEED_ADMIN_PASSWORD` (default `password`)
4. **Segera ganti password admin** melalui halaman profil.
5. Buka `/admin/products` → **Create** → unggah thumbnail. Setelah tersimpan:
   - Gambar harus tampil (berasal dari Firebase Storage).
   - Cek Firebase Console → Storage → Files, file baru harus muncul di folder `products/`.
6. Uji registrasi user baru untuk memastikan email OTP terkirim.

---

## 10. Konfigurasi Midtrans

1. Masuk ke dashboard Midtrans (sandbox: <https://dashboard.sandbox.midtrans.com>).
2. **Settings → Configuration → Payment Notification URL**.
3. Isi: `https://<domain-vercel-anda>/midtrans/callback`
4. Simpan.

Endpoint callback sudah dikecualikan dari CSRF di `bootstrap/app.php`, sehingga notifikasi Midtrans bisa masuk.

---

## 11. Catatan penting

### Gambar & storage
- Semua unggahan baru disimpan di **Firebase Storage** melalui disk `public`.
- Gambar statis bawaan (`public/images/*.jpg`, `hero-img.png`, dll.) tetap ikut di image container dan disajikan langsung oleh Caddy.
- Folder `storage/app/public/products` di repo **kosong**, jadi setelah migrasi katalog produk juga kosong. Tambahkan produk lewat panel admin. (Seeder `ProductSeeder` merujuk gambar `products/bag1.png` yang tidak ada di repo, jadi jangan diandalkan.)

### Session, cache, queue
- Session dan cache memakai tabel database (`sessions`, `cache`) sehingga aman di banyak instance.
- `QUEUE_CONNECTION=sync` berarti job dijalankan langsung saat request. Tidak ada worker background di Vercel. Jika nanti butuh antrean asinkron, gunakan Vercel Queues atau layanan eksternal.

### Filesystem container bersifat sementara
- File apa pun yang ditulis ke disk container akan hilang saat instance didaur ulang. Karena itu **jangan** kembali menyimpan unggahan ke disk lokal di produksi.

### Jangan `config:cache`
- `config:cache` akan membekukan nilai environment saat build, padahal Vercel menyuntikkan env saat runtime. Karena itu Dockerfile hanya menjalankan `view:cache`.
- `route:cache` juga tidak dipakai karena `routes/web.php` berisi closure.

### Batas ukuran upload
- Vercel Functions membatasi ukuran body request sekitar **4,5 MB**. Form produk mengizinkan beberapa gambar sekaligus, jadi unggah **satu per satu** atau kompres gambar terlebih dahulu. Jika melebihi batas, Vercel akan mengembalikan `413 Request Entity Too Large` sebelum request sampai ke Laravel.

### Keamanan
- Jangan commit `.env`, file service account JSON, atau kredensial database.
- Ganti password default owner/admin setelah seed.
- Gunakan kredensial Midtrans **production** hanya setelah pengujian sandbox selesai.

---

## 12. Troubleshooting

| Gejala | Penyebab & solusi |
|---|---|
| Halaman 502 / container gagal start | Cek **Deployments → Logs**. Biasanya `APP_KEY` kosong atau port tidak sesuai. Pastikan `Caddyfile` memakai `:{$PORT:80}`. |
| `No application encryption key has been specified` | `APP_KEY` belum diisi di Vercel, atau Anda mengubah env tanpa redeploy. Tambahkan lalu redeploy. |
| Error koneksi database / SSL | Pastikan `DB_SSL_CA_BASE64` benar (base64 dari `ca.pem` tanpa karakter baru). Cek juga IP allowlist penyedia database. Jika muncul error verifikasi sertifikat, tambahkan env `MYSQL_ATTR_SSL_VERIFY_SERVER_CERT=false` (koneksi tetap terenkripsi, hanya verifikasi sertifikat dimatikan). |
| Gambar produk rusak / 404 | Bucket Firebase belum public. Periksa **Storage → Rules** dan pastikan `allow read: if true`. Pastikan `FIREBASE_STORAGE_BUCKET` sama persis dengan nama bucket. |
| `Class "Google\Cloud\Storage\StorageClient" not found` | Dependency belum terpasang. Pastikan `composer.lock` ikut ter-commit dan build Docker berhasil. |
| Gambar hilang setelah beberapa menit | Berarti unggahan masih tersimpan di disk lokal, bukan Firebase. Pastikan `FILESYSTEM_DISK=public` dan env Firebase terisi. |
| OTP tidak terkirim | Konfigurasi SMTP salah. Cek **Logs** di Vercel; `MAIL_MAILER=smtp` harus diisi lengkap. |
| `419 Page Expired` saat callback Midtrans | Pastikan URL callback tepat `https://domain/midtrans/callback` (tanpa trailing slash). |
| Perubahan env tidak berefek | Vercel hanya membaca env baru setelah **redeploy**. |
| Build gagal di `npm ci` | Pastikan `package-lock.json` ikut ter-commit dan tidak diubah manual. |
| Build gagal di `composer install` | `composer.lock` tidak sinkron dengan `composer.json`. Jalankan `composer update --lock` di mesin dengan PHP 8.2+, lalu commit. |

---

## 13. Ringkasan biaya & limit

| Layanan | Plan | Catatan |
|---|---|---|
| Vercel | Hobby | Container runtime (Beta), aktif saat ada trafik, scale-to-zero |
| Aiven MySQL | Free | ±1 GB storage, koneksi TLS wajib |
| Firebase Storage | Spark (gratis) | 5 GB storage, 1 GB download/hari |

Jika trafik naik, pertimbangkan upgrade plan database terlebih dahulu karena koneksi MySQL biasanya menjadi bottleneck.
