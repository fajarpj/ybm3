# Deploy ke cPanel/Rumahweb/InfinityFree

Struktur hosting yang disarankan:

```text
/home/username/
├─ public_html/
│  ├─ index.php
│  ├─ .htaccess
│  ├─ assets/
│  ├─ favicon.ico
│  └─ robots.txt
│
└─ yayasan-core/
   ├─ app/
   ├─ system/
   ├─ vendor/
   ├─ writable/
   ├─ .env
   ├─ spark
   ├─ composer.json
   └─ composer.lock
```

## Upload ke `public_html`

Upload isi folder `public/`, bukan folder `public`-nya:

- `index.php`
- `.htaccess`
- `assets/`
- `favicon.ico`
- `robots.txt`

Jangan upload `public/writable/`. Folder itu hanya berisi file runtime lokal dan tidak diperlukan di web root.

## Upload ke `yayasan-core`

Buat folder `yayasan-core` sejajar dengan `public_html`, lalu upload:

- `app/`
- `system/`
- `vendor/`
- `writable/`
- `.env`
- `spark`
- `composer.json`
- `composer.lock`

Opsional, tidak perlu dihosting untuk menjalankan website:

- `tests/`
- `phpunit.xml.dist`
- `preload.php`
- `README.md`
- `LICENSE`
- folder `.git/`, `.agents/`, dan folder duplikat `yayasan/`

## Konfigurasi `.env` server

Di `yayasan-core/.env`, gunakan mode production dan isi data server:

```env
CI_ENVIRONMENT = production
app.baseURL = 'https://domain-kamu/'

database.default.hostname = HOST_DATABASE_DARI_CPANEL
database.default.database = NAMA_DATABASE
database.default.username = USER_DATABASE
database.default.password = PASSWORD_DATABASE
database.default.DBDriver = MySQLi
database.default.port = 3306

logger.threshold = 1

session.driver = 'CodeIgniter\Session\Handlers\FileHandler'
# session.savePath =
```

Biarkan `session.savePath` tidak aktif supaya session tersimpan otomatis di `yayasan-core/writable/session`.

## Catatan penting

- `public/index.php` sudah mendukung struktur `public_html + yayasan-core`.
- Pastikan versi PHP hosting minimal 8.2.
- Pastikan folder `yayasan-core/writable/` dapat ditulis oleh server.
- Jika memakai Midtrans, isi `midtrans.*` di `.env` server dengan key dari akun Midtrans.
- Setelah upload, jangan tampilkan atau bagikan isi `.env`.

## Jika terjadi error 500

Cek urutan ini:

1. `vendor/` sudah ikut diupload ke `yayasan-core/`.
2. `.env` berada di `yayasan-core/.env`.
3. Database hostname, username, password, dan nama database sudah sesuai panel hosting.
4. File `.htaccess` dari `public/` ikut terupload ke `public_html/`.
5. Folder inti benar-benar bernama `yayasan-core`.
6. PHP hosting sudah dipilih ke versi 8.2 atau lebih baru.
