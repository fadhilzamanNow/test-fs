TECHNICAL TEST 
BACK END : LARAVEL
FRONT END : VUE JS
DATABASE : POSTGRESQL

CARA PENGGUNAAN:
1. git clone https://github.com/fadhilzamanNow/test-fs.git
[BACKEND]
2. cd backend/
4. composer install
5. cp .env.example .env
6. ubah informasi database sesuai dengan akun database di pc 
      DB_CONNECTION=
      DB_HOST=
      DB_PORT=
      DB_DATABASE=
      DB_USERNAME=
      DB_PASSWORD=
      JWT_SECRET=randomaja
7. php artisan key:generate
8. php artisan migrate:fresh (sebelum melakukan ini, pastikan di database yang akan digunakan,sudah dibuat nama database yang akan digunakan)
9. atau php artisan migrate:fresh --seed (diisi dengan seeder, tabel pada databasenya)
10. php artisan serve (menjalankan aplikasi backend)
[FRONTEND]
11. Bersamaan dengan jalannya aplikasi backend kembali ke root folder, lalu ke frontend dengan cd ../frontend/
12. npm i
13. npm run dev
14. buka localhost:5173/login, disini portal login hanya 1, namun nanti mengarahkan sesuai dengan module pada setiap akunnya apakah PPIC atau Production dan apakah Staff untuk modulenya atau Manager untuk rolenya.
15. kemudian, kalau ingin bikin akun , ke /register , setelah itu kembali lagi ke login
16. Setelah berhasil login, user akan masuk ke masing masing private routes berdasarkan module yang dipilih saat registerasi
17. PPIC => ['/products','/product-plan','plan-log'], Production => ['/orders', '/order-log']
18. Untuk role Staff dan Manager pada setiap module, Manager memiliki hak untuk melakukan edit dan delete
19. PPIC terdapat produk -> buat rencana produksi dalam '/products' -> status rencana produksi hanya dapat diubah oleh manager ppic dalam '/product-plan' -> setiap log perubahan status disimpan dalam '/plan-log'
20. Rencana Produksi yang sudah disetujui oleh Manager PPIC langsung akan menciptakan record Order Produksi, yang isinya dapat dilihat oleh Staff Produksi '/orders', Status dari Order Produksi hanya dapat dihapus dan diedit oleh Manager Produksi
21. Setiap perubahan status pada Order Produksi tercermin pada Order Log '/order-log'
22. Informasi Aplikasi dapat dilihat disini 
[Link Vidio Demo Aplikasi](https://drive.google.com/file/d/1OllgFWgOdtDogQqNmhLeRvnFSwIXODlK/view?usp=sharing)



[INCOMING ERD]
