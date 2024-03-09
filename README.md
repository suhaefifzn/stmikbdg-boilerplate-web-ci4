## STMIK Bandung - Boilerplate - Web - Versi CodeIgniter

Template dasar untuk membangun web menggunakan CodeIgniter 4. Template ini telah diintegrasikan dengan login sistem, sehingga pengembangan web cukup berfokus pada halaman dashboardnya dan boilerplate ini dibuat untuk penggunaan dengan API STMIK Bandung, sama seperti template dasar versi Laravelnya.

### Penggunaan

Download atau clone terlebih dahulu project ini dan pastikan perangkat Anda telah terpasang dukungan untuk PHP Versi 8 ke atas dan telah terpasang composer. Buka terminal dan arahkan ke path direktori root dari project ini disimpan, jalankan composer install. Kemudian:
- Salin env ke file baru dengan nama .env
- Buka .env, matikan komentar dan isi nilai CI_ENVIRONMENT, app.baseURL, API_BASE_URL, dan LOGIN_BASE_URL
- Jalankan perintah, php spark serve --port 8000. Jika ingin menggunakan port lain atau menjalankannya dengan virtual host maka hubungi tim Back-End agar dapat diregistrasikan terlebih dahulu.
- Jika tidak melakukan perubahan pada host dan port, project siap dikembangkan dan diakses menggunakan browser pada alamat localhost:8000 setelah berhasil login.