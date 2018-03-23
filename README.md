# Learn React: To Do App #
Ini merupakan repositori pembelajaran pertama gw untuk mengetahui bagaimana membuat web app menggunakan Framework React JS.

## Build Status ##
Travis CI  
[![Build Status](https://travis-ci.org/nurimansyah/react-todo-app.svg?branch=master)](https://travis-ci.org/nurimansyah/react-todo-app)

## Getting Started ##
Sebelum memulai untuk mencoba atau melanjutkan latihan, terlebih dahulu kita harus menginstall beberapa dependencies berikut:

- MySQL Server
- PHP >= 7.1
- Composer
- Node JS

### Installation ###
Lalu, setelah melakukan instalasi kebutuhan tersebut, kita harus menginstall dependencies repo terlebih dahulu dengan cara:

- `git clone` repositori ini.
- Buka terminal/command prompt.
- Ganti directory (`cd`) ke hasil cloning.
- Lalu, untuk sistem API:
	- Ganti directory (`cd`) ke `./api`.
	- Install dependencies Composer dengan mengetikkan, `composer install`.
- Dan untuk Aplikasinya:
	- Ganti directory (`cd`) ke `./app`.
	- Install dependencies NPM dengan mengetikkan, `npm install`.

Selanjutnya, kita dapat menggunakan perintah-perintah dibawah untuk memulai latihan ini.

### Command ###
Berikut ini adalah list perintah yang dapat digunakan:

- Frontend (Jalankan di dalam folder `./app`):
	- `npm run test`: Unit Testing BDD
	- `npm run acceptance`: Acceptance Test
	- `npm run acceptance:create`: Pembuatan test Acceptance baru
	- `npm run dev`: Kompilasi webpack untuk development
	- `npm run watch`: Sama seperti diatas, namun akan melihat perubahan file
	- `npm run serve`: Akan menjalankan server PHP
- Backend API (Jalankan di dalam folder `./api`):
	- `php -S localhost:8080 -t public`: Menjalankan PHP server pada API
	- `phpunit`: Menjalankan Unit-Testing

### Lisensi ###
Saat ini, lisensi untuk repo ini bersifat Free/Open-Source sehingga kamu bebas untuk mengembangkan latihan ini.