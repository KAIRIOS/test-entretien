FROM php:7.4-apache

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update && apt-get install -y \
    gnupg \
    ca-certificates \
    curl \
    git \
    unzip \
    libzip-dev && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install mysqli pdo pdo_mysql zip \
    && echo "LISTEN 8080" >> /etc/apache2/ports.conf

RUN mkdir -p /etc/apt/keyrings \
    && curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg \
    && NODE_MAJOR=18 \
    && echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_MAJOR.x nodistro main" | tee /etc/apt/sources.list.d/nodesource.list

RUN apt update -y \
    && apt install nodejs -y    && apt-get update \
    && apt-get install -y nodejs

COPY . /var/www/html
COPY ./docker/entrypoint.sh /usr/bin/entrypoint.sh
COPY ./docker/apache2/hosts.conf /etc/apache2/sites-enabled/hosts.conf
COPY ./docker/apache2/symfony.conf /etc/apache2/sites-available/000-default.conf

RUN chown -R www-data:www-data /var/www \
    && echo "date.timezone = Europe/Paris" >> /usr/local/etc/php/php.ini \
    && usermod -u 1000 www-data

RUN ["chmod", "+x", "/usr/bin/entrypoint.sh"]

HEALTHCHECK --interval=5s --timeout=3s CMD curl --fail http://localhost:80/ || exit 1

WORKDIR /var/www/html

RUN set -eux; \
	composer install; \
	composer dump-autoload; \
    chmod +x bin/console; sync

RUN npm install -g yarn

USER www-data

ENTRYPOINT ["/usr/bin/entrypoint.sh"]