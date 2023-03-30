FROM docker03.gomaji.com/alpine/alpine-php-nginx:7.3

RUN apk update && apk upgrade && \
    apk --no-cache --progress add \
    # php7-pdo \
    # php7-pdo_mysql \
    php7-tokenizer \
    php7-dom \
    php7-xmlwriter \
    php7-xmlreader \
    php7-simplexml \
    php7-xml \
    php7-fileinfo \
    php7-zip \
    php7-session \
    php7-bcmath \
    php7-intl \
    php7-sodium \
    php7-posix \
    php7-gd \
    php7-redis

# 確認 php 版本為 7.3.x
ARG PHP_VERSION=7.3
RUN php -v | head -n 1 | grep -q "PHP ${PHP_VERSION}."

COPY docker-files/config /

RUN rm /etc/nginx/conf.d/default.conf

COPY . /var/www/html

RUN rm -rf /var/www/html/docker-files

RUN chown nobody:nobody -R /var/www/html/storage/

WORKDIR /var/www/html

ENV APP_BASE_PATH=/var/www/html

# 確定使用正式環境
RUN cp /var/www/html/.env.prod /var/www/html/.env

# 進行Laravel最佳化，一定要在確定使用的.env檔後
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache
