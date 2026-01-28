# 🌌 Star Wars Data Explorer
### Laravel Backend + Vue 3 (Vite) Frontend

This project synchronizes **Star Wars planets and their related entities** from the public API  
**https://swapi.dev** into a local **MySQL** database using **Laravel 12**,  
and displays the data through a **Vue 3 frontend powered by Vite**.

---

## 🚀 Features

- 🔄 Sync planets, films, residents and related entities from SWAPI
- 🗄 MySQL relational database structure
- ⚙️ Artisan command for scheduled/manual synchronization
- 📊 Laravel Horizon for queue monitoring
- 🧵 Supervisor support for production queues
- ⚡ Vue 3 frontend with Vite bundler
- 📄 Paginated planet listing UI

---

## 📁 Project Structure

```
app/
├── Console/Commands/       # swapi:sync command
├── Models/                 # Planet, Film, Person models
└── Services/Swapi/         # Synchronization service

database/
├── migrations/             # DB schema
└── seeders/

resources/
├── js/
│   ├── app.js              # Vite entry
│   ├── bootstrap.js
│   └── vue/
│       ├── App.vue
│       └── components/
│           └── PlanetList.vue
└── views/
    └── app.blade.php       # Vue mounting point

routes/
└── web.php

vite.config.js
```

---

## ✅ Requirements

### Backend
- PHP **8.2+**
- Laravel **12**
- MySQL **8+**
- Composer
- Redis (for queues)
- Ubuntu package:
  ```bash
  sudo apt install php-curl
  ```

### Frontend
- Node.js **18+**
- NPM or Yarn

---

## 🛠 Installation & Setup

### 1️⃣ Clone Repository

```bash
git clone https://github.com/elivol-git/star-wars-data-explorer.git
cd star-wars-data-explorer
```

---

### 2️⃣ Install PHP Dependencies

```bash
composer install
```

```bash
cp .env.example .env
php artisan key:generate
```

---

### 3️⃣ Configure Environment

Edit `.env`:

```env
DB_DATABASE=planets
DB_USERNAME=planets_user
DB_PASSWORD=your_strong_password

QUEUE_CONNECTION=redis
```

---

## 🗄 MySQL Database Setup

```sql
CREATE DATABASE planets CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE USER 'planets_user'@'localhost'
IDENTIFIED BY 'your_strong_password';

GRANT ALL PRIVILEGES ON planets.*
TO 'planets_user'@'localhost';

FLUSH PRIVILEGES;
```

---

## 🧱 Run Migrations

```bash
php artisan migrate
```

---

## 🔄 Synchronize SWAPI Data

```bash
php artisan swapi:sync
```

This command can also be scheduled via Laravel Scheduler.

---

# ⚡ Vue 3 + Vite Frontend Setup

## 📦 Install Node Dependencies

```bash
npm install
```

or

```bash
yarn install
```

---

## ▶ Run Vite Dev Server

```bash
npm run dev
```

Vite will start at:

```
http://localhost:5173
```

Laravel will load assets automatically via Vite.

---

## 🏗 Build Frontend for Production

```bash
npm run build
```

Compiled files will be placed in:

```
public/build
```

---

## 🧩 Vite Configuration

`vite.config.js`:

```js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
});
```

---

## 📊 Laravel Horizon

### Install

```bash
composer require laravel/horizon
php artisan horizon:install
php artisan migrate
```

### Access Dashboard

```
http://your-domain.test/horizon
```

---

## 🖥 Supervisor Configuration (Production)

```ini
[program:horizon]
process_name=%(program_name)s
command=php /var/www/planets/artisan horizon
autostart=true
autorestart=true
user=www-data
redirect_stderr=true
stdout_logfile=/var/www/planets/storage/logs/horizon.log
stopwaitsecs=3600
```

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start horizon
```

---

## ▶ Run Laravel Server

```bash
php artisan serve
```

Open:

```
http://127.0.0.1:8000
```

---

## 🧰 Useful Artisan Commands

| Action | Command |
|------|------|
| Migrate DB | `php artisan migrate` |
| Sync SWAPI | `php artisan swapi:sync` |
| Clear cache | `php artisan optimize:clear` |
| Horizon | `php artisan horizon` |
| Queue worker | `php artisan queue:work` |

---

## 🔐 Linux Permissions Fix

```bash
sudo chown -R $USER:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

---

## ❗ Troubleshooting

### Permission denied (laravel.log)

```bash
sudo chmod -R 775 storage/logs
```

### Redis connection refused

```bash
sudo apt install redis-server
sudo systemctl enable redis
sudo systemctl start redis
```

---

## 📜 License

Open-source.  
Free to use, modify, and distribute.

---

✨ **May the Force be with your code.**
