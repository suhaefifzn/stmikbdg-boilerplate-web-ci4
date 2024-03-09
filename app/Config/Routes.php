<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 /**
  * ! Jangan ubah atau hapus dua route yang ada di bawah ini
  * route '/' dan '/logout' telah diatur dan ditetapkan 
  * untuk autentikasi dan integrasi dengan sistem login yang sudah ada saat ini
  */
$routes->get('/', 'AuthController::authenticate');
$routes->get('/logout', 'AuthController::logout', ['as' => 'logout']);

/**
 * Pastikan dashboard memiliki halaman utama atau home
 * kamu dapat mengubah '/home' atau pun controllernya 'Home::index'
 * untuk menentukan halaman utamanya. Tetapi,
 * berikan nama atau alias sebagai 'home' pada route tersebut, 'as' => 'home
 * dan selalu gunakan middleware atau filter 'auth_token'.
 */
$routes->get('/home', 'Home::index', ['filter' => ['auth_token'], 'as' => 'home']);

/**
 * * Buatlah route-route lain setelah komentar ini
 * * Saat ini telah terdapat 4 middleware atau filter yang dapat digunakan
 * 1.) 'auth_mahasiswa' => akses hanya untuk mahasiswa
 * 2.) 'auth_dosen' => akses hanya untuk dosen
 * 3.) 'auth_admin' => akses hanya untuk admin
 * 4.) 'auth_developer' => akses hanya untuk developer
 * 
 * contoh penggunaan multi filter: ['filter' => ['auth_token', 'auth_mahasiswa']]
 */