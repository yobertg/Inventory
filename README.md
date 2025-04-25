README
Alur Pengerjaan Proyek UTS Manajemen Persediaan Toko

Proyek ini adalah aplikasi backend berbasis Laravel untuk mengelola persediaan barang pada suatu toko, meliputi kategori barang, pemasok atau supplier, dan admin yang bertanggung jawab atas pengelolaan data barang. Berikut adalah langkah-langkah yang saya lakukan selama mengerjakan proyek ini, mulai dari inisialisasi hingga selesai.

1. Inisialisasi Proyek
- Saya memulai dengan membuat folder proyek baru menggunakan Laragon, sebuah tools yang mempermudah pembuatan proyek Laravel.
- Lalu Saya menjalankan perintah laravel new inventory untuk membuat proyek Laravel baru bernama "inventory".

2. Containerisasi dengan Docker
- Saya mengatur containerisasi menggunakan Docker agar aplikasi dapat berjalan dalam lingkungan yang terisolasi.
- Saya membuat file docker-compose.yml untuk mendefinisikan layanan seperti aplikasi Laravel (PHP), web server (Nginx), dan database (MySQL).
- Setelah konfigurasi selesai, saya menjalankan docker-compose up -d untuk memulai container dan memastikan semua layanan berjalan dengan baik.

3. Koneksi ke Database
- Saya mengatur file .env dan konfigurasi database pada proyek Laravel untuk menghubungkan aplikasi dengan database MySQL yang berjalan di dalam container Docker lalu menguji koneksi database dengan menjalankan php artisan migrate untuk memastikan aplikasi dapat berkomunikasi dengan MySQL.

4. Pembuatan Model, Migration, dan Relasi
Saya membuat model dan migration untuk tabel Admin, Category, Supplier, dan Item berdasarkan ERD yang telah dirancang.
- Untuk tabel admins, saya membuat migration dengan kolom id, username, password, email, created_at, dan updated_at.
- Untuk tabel categories, saya membuat migration dengan kolom id, name, description, created_by (foreign key ke admins), created_at, dan updated_at.
- Untuk tabel suppliers, saya membuat migration dengan kolom id, name, contact_info, created_by (foreign key ke admins), created_at, dan updated_at.
- Untuk tabel items, saya membuat migration dengan kolom id, name, description, price, quantity, category_id (foreign key ke categories), supplier_id (foreign key ke suppliers), created_by (foreign key ke admins), created_at, dan updated_at.


5. Pembuatan Controller
Saya membuat controller untuk masing-masing entitas: AdminController, CategoryController, SupplierController, dan ItemController.

Pada setiap controller, saya mengimplementasikan fungsi dasar:
- index() untuk menampilkan daftar data (Read).
- create() untuk menampilkan form pembuatan data (Create).
- store() untuk menyimpan data baru ke database.

Saya juga membuat DashboardController untuk menangani logika halaman dashboard.

6. Pembuatan View
Saya membuat view menggunakan Blade untuk setiap entitas dengan fungsi Create dan Read:
- Untuk items, saya membuat halaman untuk menampilkan daftar barang dan form untuk menambah barang baru.
- Untuk categories, saya membuat halaman untuk menampilkan daftar kategori dan form untuk menambah kategori baru.
- Untuk suppliers, saya membuat halaman untuk menampilkan daftar pemasok dan form untuk menambah pemasok baru.
- Untuk admins, saya tidak membuat sistem login, melainkan halaman untuk memilih admin dari database yang sudah saya seed secara manual.

Saya membuat seeder untuk tabel admins menggunakan php artisan make:seeder AdminSeeder dan mengisi data admin secara manual dan menjalankan php artisan db:seed --class=AdminSeeder untuk mengisi data admin ke database.
Lalu saya juga membuat halaman sederhana dengan dropdown untuk memilih admin yang akan digunakan dalam pengelolaan data yang nantinya akan berubah pada created_by di tabel item,category, dan supplier

7. Pembuatan Halaman Dashboard
Saya membuat halaman dashboard dengan fitur berikut:
- Ringkasan stok barang: Menampilkan stok total, total nilai stok (harga × jumlah), dan rata-rata harga barang menggunakan query Eloquent.
- Daftar barang di bawah ambang batas: Menampilkan barang dengan stok di bawah 5 unit
- Laporan barang berdasarkan kategori: Menampilkan daftar barang yang dapat difilter berdasarkan kategori tertentu.
- Ringkasan per kategori: Menampilkan jumlah barang per kategori, total nilai stok per kategori, dan rata-rata harga barang dalam kategori tersebut menggunakan grouping dan agregasi.
- Ringkasan per pemasok: Menampilkan jumlah barang per pemasok dan total nilai barang yang disuplai menggunakan relasi dan agregasi.
- Ringkasan keseluruhan sistem: Menampilkan total jumlah barang, nilai stok keseluruhan, jumlah kategori, dan jumlah pemasok.

Saya membuat view dashboard.blade.php untuk menampilkan semua informasi ini dalam format yang rapi menggunakan tabel dan card.

8. Pengujian dan Penyelesaian
Saya menguji aplikasi dengan langsung mengetikkan localhost:8000/admin/select karena sudah menggunakan docker.
Saya memastikan semua fitur berjalan dengan baik, seperti memilih admin yang diinginkan,jika belum memilih admin maka tidak bisa mengakses halaman lainnya, lalu saya mengecek pembuatan data, pembacaan data, dan tampilan dashboard.

Setelah semua fitur berfungsi dengan baik, saya mendokumentasikan proyek ini dalam file README untuk menjelaskan alur pengerjaan.