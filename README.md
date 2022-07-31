# Тестовое задание

1. Установить и настроить Lumen
2. Создать в базе две таблицы: одну для хранения новостей, а вторую для хранения источников, с которых получена новость
3. Добавить в модели таблиц необходимые методы для сохранения и отображения данных из этих таблиц
4. Сделать парсер новостей с https://newsapi.org на темы Bitcoin, Litecoin, Ripple, Dash, Ethereum
5. Сделать job для парсинга новостей с интервалом одна новость по каждой теме в минуту
6. Создать API для вывода новостей в формате JSON с возможностью группировки по источнику новости и дате и теме.



# docker exec -it crypto-backend php artisan queue:work --tries=1 --memory=50 --timeout=3600

# docker exec -it crypto-backend php artisan migrate --seed

# docker exec -it crypto-backend ./vendor/bin/phpunit



