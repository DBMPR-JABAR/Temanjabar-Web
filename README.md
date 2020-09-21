# Temanjabar Laravel
Temanjabar Website Repository

## Backend framework
<img width="40px" align="left" src="https://raw.githubusercontent.com/github/explore/56a826d05cf762b2b50ecbe7d492a839b04f3fbf/topics/laravel/laravel.png"/>
<br/><br/>

## Frontend framework
<img width="40px" align="left" src="https://camo.githubusercontent.com/324e9374b778037129e4aabb453a4e4bc75a4922/68747470733a2f2f6672616d65776f726b372e696f2f692f6c6f676f2e737667"/>
<br/><br/>

## Instalasi
1. Clone repo
2. Pergi ke direktori aplikasi
  ```
  cd path/to/temanjabar-laravel
  ```
2. Pastikan sudah terinstall composer (download [disini](https://getcomposer.org/)), masukkan command di bawah pada cmd/terminal
  ```
  composer install
  ```
3. Copy .env.example terus rename jadi .env
  ```
  copy .env.example .env
  ```
4. ubah konfigurasi env, sesuaikan 
  ```
  APP_URL=http://localhost:8000/

  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=uptm3922_uptd1
  DB_USERNAME=root
  DB_PASSWORD=
  ```
5. run  
  ```
  php artisan key:generate
  php artisan jwt:secret
  ```
6. Import Database uptm3922_uptd1.sql ke server
7. Untuk menyalakan virtual server run:
  ```
  php artisan serve
  ```