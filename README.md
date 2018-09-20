# Portfolio

## Installtion
If you are interested in using the website, you may follow the instructions below to install the application.

### Requirements
You server needs to satisfy these requirements:
* PHP >= 7.1.3
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension
* Ctype PHP Extension
* JSON PHP Extension

### Steps 
1. Clone the repo
```
git clone https://github.com/joshuajazleung/portfolio portfolio
```
    
2. Copy .env.example to .env and generate an application key    
```
cp .env.example .env && php artisan key:generate
```

3. Fill out the database info in ```.env```

4. Migrate the databse
```
php artisan migrate
```