# synchronize-planets-films
This project synchronizes data from https://swapi.dev API into the project. Do fetch planets and related films data and store it into MySQL DB.
Preoject includes 2 migration files: database/migrations/2023_02_09_115848_films.php and database/migrations/2023_02_09_115757_planets.php
Installations: sudo apt-get install php-curl
MySQL instructions: 
CREATE DATABASE coperato;
CREATE USER 'coperato'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON coperato.* TO 'coperato'@'localhost';
FLUSH PRIVILEGES;
To run sync command: php artisan create:sync-planets
