FROM php:8.4-cli

WORKDIR /app

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        zip \
    && docker-php-ext-install pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
