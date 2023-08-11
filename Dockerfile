FROM php:8.2-fpm
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql sockets

RUN apt-get update && apt-get install -y \
    nginx \
    && rm -rf /var/lib/apt/lists/*

#RUN apt-get install -y clickhouse-client

COPY nginx/default.conf /etc/nginx/sites-available/default

COPY . /var/www/html

EXPOSE 80

CMD service nginx start && php-fpm
