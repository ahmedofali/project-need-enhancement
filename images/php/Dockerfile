FROM php:8.0-fpm

RUN apt-get update && apt-get install -y --no-install-recommends zip unzip git vim libpq-dev procps libjpeg-dev libpng-dev libzip-dev libonig-dev

RUN docker-php-ext-configure gd --enable-gd --with-jpeg

RUN docker-php-ext-install gd pdo pdo_pgsql zip pcntl mbstring exif

RUN apt-get -y autoremove && apt-get clean

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN chmod a+x /usr/local/bin/composer

RUN pecl install redis && docker-php-ext-enable redis

RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

WORKDIR /var/www/html/qawafel

RUN groupadd -g 1000 qawafel

RUN useradd -u 1000 -ms /bin/bash -g qawafel qawafel

USER qawafel

EXPOSE 9000

CMD ["php-fpm"]
