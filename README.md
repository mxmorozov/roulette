## Установка

- Клонируем репозиторий:	
git clone https://github.com/mxmorozov/roulette

- Переходим в папку проекта:
cd roulette

- Устанавливаем зависимости:
composer install

- Поднимаем контейнер:
./vendor/bin/sail up -d

- Выполняем миграции:
./vendor/bin/sail php artisan migrate

Смотрим http://localhost
