FROM php:7.2-fpm

RUN docker-php-ext-install pdo_mysql && \
    curl https://getcomposer.org/installer > installer.php && \
    php installer.php && \
    rm installer.php && \
    chmod +x composer.phar && \
    mv composer.phar /usr/bin/composer && \
    pecl install xdebug-2.6.0 && \
    docker-php-ext-enable xdebug