<h1 align="center" id="title">RT Admin</h1>

<p id="description">Backend projek RT Admin menggunakan Laravel untuk membuat Restfull API</p>

<h2>🛠️ Installation Steps:</h2>

<p>1. Clone projek ke lokal</p>

```
git clone https://github.com/Akmdrhannn/rtAdmin.git
```

<p>2. Setup lokal env</p>
Buka terminal jalankan command

```
1. composer install
2. npm install
```

Setelah itu 
```
rename .env.example menjadi .env
```
Dan buka kembali terminal untuk menjalankan command
```
php artisan key:generate
```
agar mendapatkan APP_KEY
<p>3. Jalankan migrate, seed dan artisan serve</p>

```
php artisan migrate
2. php artisan db:seed db_randomdata
3. php artisan serve
```


Maka API Laravel siap digunakan dan dapat menggunakan postman untuk pengujian.


