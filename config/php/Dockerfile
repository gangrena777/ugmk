FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    curl \
    wget \
    git \
    cron \
    bash \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    ssmtp \
    mailutils \
    libonig-dev  # Установка oniguruma

# Установка расширений PHP
RUN docker-php-ext-install -j$(nproc) \
    iconv \
    mbstring \
    mysqli \
    pdo_mysql \
    zip

# Конфигурация и установка расширения GD
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd

# Настройка ssmtp для отправки электронной почты
RUN echo "root=gaa1@ugmk-telecom.ru" >> /etc/ssmtp/ssmtp.conf
RUN echo "mailhub=corp.ugmk-telecom.ru:587" >> /etc/ssmtp/ssmtp.conf 
RUN echo "AuthUser=gaa1@ugmk-telecom.ru" >> /etc/ssmtp/ssmtp.conf
RUN echo "AuthPass=Rvp0%pr*J2" >> /etc/ssmtp/ssmtp.conf
RUN echo "UseTLS=YES" >> /etc/ssmtp/ssmtp.conf
RUN echo "UseSTARTTLS=YES" >> /etc/ssmtp/ssmtp.conf

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

USER www-data:www-data

CMD ["php-fpm"]
