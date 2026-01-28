# 🌌 Star Wars - Laravel backend with Vue.js frontend that synchronizes Star Wars planet data from SWAPI into MySQL and presents it via paginated UI views.

This Laravel project synchronizes **Star Wars planets and their related films** from  
the public API **https://swapi.dev** into a local MySQL database.  
It also includes a scheduler-ready command, Horizon monitoring, and Supervisor setup.

## 🚀 Features

- Fetch & store planets and the related entities from SWAPI
- MySQL storage with relational tables
- Artisan command to sync data anytime
- Laravel Horizon dashboard for queue monitoring
- Supervisor integration for production queue workers

## 📁 Project Structure

app/
├── Console/Commands/       # create:sync-planets command
├── Models/                 # Planet and Film models
└── Services/               # SynchronizePlanetsProcedure service

database/
├── migrations/             # Migrations for planets & films tables
└── seeders/                # Optional seeders

routes/
└── web.php                 # Landing page displaying planets/films

resources/views/
└── ...                     # Blade templates

## ✅ Requirements

- PHP 8.2+
- Laravel 12
- MySQL 8+
- Composer
- Ubuntu: php-curl package

## 🛠 Installation & Setup

git clone https://github.com/elivol-git/star-wars-data-explorer.git
cd planets

composer install
cp .env.example .env
php artisan key:generate

Update `.env`:

DB_DATABASE=planets
DB_USERNAME=planets_user
DB_PASSWORD=your_strong_password

## 🗄 MySQL Database Setup

CREATE DATABASE planets CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE USER 'planets_user'@'localhost' IDENTIFIED BY 'your_strong_password';

GRANT ALL PRIVILEGES ON planets.* TO 'planets_user'@'localhost';

FLUSH PRIVILEGES;

## 🧱 Create Database Tables (Migrations)

php artisan migrate

## 🔄 Synchronize SWAPI Data

php artisan create:sync-planets

## 📊 Laravel Horizon (Queue Dashboard)

composer require laravel/horizon
php artisan horizon:install
php artisan migrate

Access dashboard:

http://film-planets.test/horizon

## 🖥 Supervisor Setup (Production Only)

sudo apt update
sudo apt install supervisor
sudo systemctl enable supervisor
sudo systemctl start supervisor

Create Horizon config:

[program:horizon]
process_name=%(program_name)s
command=php /var/www/planets/artisan horizon
autostart=true
autorestart=true
user=www-data
redirect_stderr=true
stdout_logfile=/var/www/planets/storage/logs/horizon.log
stopwaitsecs=3600

sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start horizon

## ▶ Development Server

php artisan serve

## 🧰 Useful Artisan Commands

| Action | Command |
|--------|---------|
| Migrate DB | php artisan migrate |
| Sync data | php artisan create:sync-planets |
| Clear caches | php artisan optimize:clear |
| Start Horizon | php artisan horizon |

## 🔐 Fix Linux Permissions (if needed)

sudo chown -R $USER:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

## ❗ Troubleshooting

Permission denied on laravel.log  
sudo chmod -R 775 storage/logs

Redis “Connection refused”  
sudo apt install redis-server
sudo systemctl enable redis
sudo systemctl start redis

## 📜 License

Open-source. Free to use & modify.
