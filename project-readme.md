# 🌌 SWAPI Planets & Films Sync Project

This Laravel project synchronizes **Star Wars planets and related films** from the official SWAPI API:

👉 https://swapi.dev

It fetches the data, stores it in MySQL, and provides a clean structure for further development of a Star Wars data explorer.

---

## 🚀 Features

- Fetches planets and related films from SWAPI
- Stores all data in MySQL using Eloquent
- Includes custom Artisan sync command
- Laravel Horizon for queue monitoring
- Supervisor configuration for production queue workers
- Example MySQL setup instructions
- Fully container-ready and Ubuntu-friendly environment

---

## 📦 Requirements

- PHP 8.3+
- Composer
- MySQL or MariaDB
- Laravel 11
- PHP extensions:
    - php-curl

### Install required extension on Ubuntu

```bash
sudo apt-get install php-curl
