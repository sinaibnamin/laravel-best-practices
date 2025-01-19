# Portal Admin


## Add your files
```
composer i
cp .env.example .env
php artisan key:generate
```
setup db credentials in .env and ```php artisan migrate:fresh --seed```