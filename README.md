# wargametracker-laravel
 
## I) Introduction
WarGameTracker-Laravel is an enhanced version of https://github.com/gusemil/wargame-tracker-php-1.0 rebuilt in Laravel (PHP) <br>

WarGameTracker is a PHP(Laravel)/SQL(PostgreSQL) based CRUD site for tracking stats and matches of nerdy war games using the ELO scoring system.

## II) Installation
Tested with Laravel Herd and PostgreSQL

### 1) Install Laravel Herd to run the application
Download and Install Laravel Herd from https://herd.laravel.com (tested with Windows 10)

### 2) Clone the repository to the Herd folder
run **git clone https://github.com/gusemil/wargametracker-laravel.git** on your terminal of choice inside the Laravel Herd folder (by default in Windows 10 the folder is: C:\Users\YOUR_USER_NAME\Herd)

### 3) Install Composer 
Inside the root of the WarGameTracker repository: run the command: **composer install** on your terminal of choice

### 4) create your .env
Create a .env file to the repository root and copy the contents of **.env.example**

### 5) Modify .env by changing these values to your own
#DB_CONNECTION=pgsql <br>
#DB_HOST=127.0.0.1 <br>
#DB_PORT= <br>
#DB_DATABASE= <br>
#DB_USERNAME= <br>
#DB_PASSWORD= <br>

### 6) Generate an app key
Inside the root of the WarGameTracker repository: run **artisan key:generate**, in your terminal of choice, to generate an app key for Laravel (this modifies the **.env** file)

### 7) Create your database
Create a database for WarGameTracker (for example: wargametracker) using a database system of your choice (tested with PostgreSQL)

### 8) Run migrations
Run migrations by typing the command **php artisan migrate** on your terminal of choice

### 9) Create entries for tables 'game and 'group'
Create entries for tables 'game and 'group' using a database system of your choice (tested with PostgreSQL)

### 10) Open the site using Laravel Herd
Default url might be: http://wargametracker-laravel.test/ on Windows 10

### 11) Create at least two users (registering via the application or via your database)
Ensure that that at least one has admin rights (set isAdmin column as TRUE in your database)

### 12) Use the application by creating/showing/removing matches between at least two users (players)
Log-in as admin to create and remove matches. Log-in as a regular user to view matches and players
