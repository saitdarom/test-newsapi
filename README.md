# Тестовое задание

1. Установить и настроить Lumen
2. Создать в базе две таблицы: одну для хранения новостей, а вторую для хранения источников, с которых получена новость
3. Добавить в модели таблиц необходимые методы для сохранения и отображения данных из этих таблиц
4. Сделать парсер новостей с https://newsapi.org на темы Bitcoin, Litecoin, Ripple, Dash, Ethereum
5. Сделать job для парсинга новостей с интервалом одна новость по каждой теме в минуту
6. Создать API для вывода новостей в формате JSON с возможностью группировки по источнику новости и дате и теме.

`Ключ можно изменить в конфиге newsapi.key`

`docker rm -f $(docker ps -qa)`

Пользователь по умолчанию "1000:1000" - поменяйте, если нужно в файле  docker-compose.yml  
`docker compose up --build -d`

Проваливаемся в контейнер  
`docker compose exec backend bash`

После миграции запустит джобу и наполнит данными.  
`php artisan migrate --seed`

Запуск джобы.  
`php artisan queue:work --tries=1 --memory=50 --timeout=3600`

larastan  
`./vendor/bin/phpstan analyse ./app`

Юнит тест правильности формирования пакета и проверка вызова метода отправки пакета во внешнюю систему.  
`./vendor/bin/phpunit --filter Unit`

Функциональный тест работы API.  
`./vendor/bin/phpunit --filter Feature`



