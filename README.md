## About App

- Aplikasi toko sederhana

![image info](./images/dashboard.png)

## Fitur
- Pencatatan keluar masuk barang
- Logging all crud

## Default Menu
- Permission
- Menu
- Route
- Role
- User
- Purchase
- Sale
- Expense
- Report
- Product

## Requirement
- PHP >= php@8.1
- MySQL >= 8.0 ( current development )

## Install
- `composer install`
- `php artisan starmoozie:install`
- `php artisan migrate --seed`
- `php artisan db:seed --class=RouteSeeder`
- `php artisan db:seed --class=MenuSeeder`

## Default User
- Email `starmoozie@gmail.com`
- Password `password`

## Note
- Aplikasi ini dibuat memang tidak ada fitur print / export data, karena sudah ada aplikasi ini sebagai pengganti kertas
