<h1>This project synchronizes data from <a href="https://swapi.dev">https://swapi.dev</a> API into the project.</h1>
<ol>
<li>Do fetch planets and related films data and store it into MySQL DB. </li>
<li>Project includes 2 migration files: database/migrations/2023_02_09_115848_films.php and database/migrations/2023_02_09_115757_planets.php</li> 
<li>Ubuntu requirements: <strong>sudo apt-get install php-curl</strong> </li>
<li>MySQL instructions: </li>
<ol>
<li>CREATE DATABASE coperato; </li>
<li>CREATE USER 'coperato'@'localhost' IDENTIFIED BY 'password'; </li>
<li>GRANT ALL PRIVILEGES ON coperato.* TO 'coperato'@'localhost'; </li>
<li>FLUSH PRIVILEGES; </li>
</ol>
<li>To create DB tables run: <strong>php artisan migrate</strong></li>
<li>To run sync command: php artisan create:sync-planets</li>
</ol>
