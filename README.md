<table>
<td width=100>
<img src='https://www.malaysia.gov.my/media/uploads/c9558a31-7723-4558-9fee-f69baca119ff.png'/>
</td>
<td width=800>
Merupakan sistem pengurusan maklumat dengan nama lengkap sistem adalah Sistem Maklumat Jabatan Perpaduan Negara dan Integrasi Nasional
</td>
</table>

----------

# Pembangunan Sistem Maklumat Perpaduan - Jabatan Perpaduan Negara dan Integrasi Nasional

## Pemasangan

Pastikan peralatan berikut telah dipasang pada komputer pembangunan (development computer)

*  PHP (sekurang-kurangnya versi 7.2 ke atas sahaja)
*  MySQL versi 5 ke atas
*  Composer (muat turun composer installer di laman web [Composer](https://getcomposer.org/))


Klon (Clone) repository projek SMP-JPNIN di: http://git.perpaduan.gov.my/scm/jpnin/php.web.smpjpnin.git

    git clone git@gitlab.com:jpnin/php.smpjpnin.portal.git

atau melalui protokol HTTPS:

    https://git.perpaduan.gov.my/scm/jpnin/php.web.smpjpnin.git
    
Masuk ke dalam *folder*

    cd php.web.smpjpnin

Pemasangan semua *dependencies* menggunakan **composer**

    composer update

Salin fail env.example dengan menukar kepada nama .env (fail konfigure Laravel)

    cp .env.example .env

Jana (generate) application key bagi projek yang dimuat-turun

    php artisan key:generate

Run proses migrasi pangkalan data - database migrations (**pastikan maklumat conenction telah ditetapkan di fail .env sebelum proses migrasi**)

    php artisan migrate

Start development server pada localhost

    php artisan serve

Anda boleh akses localhost development server pada alamat: http://localhost:8000

**TL;DR senarai arahan**

    git clone git@gitlab.com:jpnin/php.smpjpnin.portal.git
    cd php.web.smpjpnin
    composer update
    cp .env.example .env
    php artisan key:generate
    
**Pastikan sambungan ke pangkalan data telah diset dengan maklumat yang betul sebelum melarikan arahan berikut** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan serve

## Database seeding

**lengkaPopulate the database with seed data with relationships which includes users, articles, comments, tags, favorites and follows. This can help you to quickly start testing the api or couple a frontend and start using it with ready content.**

Folder database seed

    database/seeds/ <fail Ref*>

Untuk member arahan kepada Laravel agar memuat data yang telah di-seed-kan dalam Laravel

    php artisan db:seed

***Note*** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

    php artisan migrate:refresh

## API Specification

Aplikasi SMP-JPNIN akan berintegrasi dengan API berikut:

> [JPN MyIdentity](https://www.myidentity.gov.my/)


----------

# Code overview

## Folders

- `app` - Contains all the Eloquent models
- `app/Http/Controllers/Api` - Contains all the api controllers
- `app/Http/Middleware` - Contains the JWT auth middleware
- `app/Http/Requests/Api` - Contains all the api form requests
- `config` - Contains all the application configuration files
- `database/factories` - Contains the model factory for all the models
- `database/migrations` - Contains all the database migrations
- `database/seeds` - Contains the database seeder
- `routes` - Contains all the api routes defined in api.php file

## Environment variables

- `.env` - Environment variables diset pada fail ini

----------

RANIA Resources Sdn Bhd :copyright: 2003-2021