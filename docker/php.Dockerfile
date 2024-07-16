FROM php:8.3-fpm

RUN apt-get update && \
    apt-get install -y git zip && \
    docker-php-ext-install pdo pdo_mysql

RUN curl --silent --show-error https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Uncomment to have mysqli extension installed and enabled
# RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
