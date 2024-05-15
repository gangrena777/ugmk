
FROM php:8.1-fpm

RUN apt-get update && apt-get install -y  curl \
        wget \
        git \
        cron \
        bash \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        libzip-dev \
        ssmtp \
        mailutils \
    &&  docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
    &&  docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    &&  docker-php-ext-install -j$(nproc) gd



#sendmailer
RUN apt-get install -q -y ssmtp mailutils

# root is the person who gets all mail for userids < 1000
#RUN echo "root=yourAdmin@email.com" >> /etc/ssmtp/ssmtp.conf
RUN echo "root=golopolosovartem@yandex.ru" >> /etc/ssmtp/ssmtp.conf

# Here is the gmail configuration (or change it to your private smtp server)
#RUN echo "mailhub=smtp.gmail.com:587" >> /etc/ssmtp/ssmtp.conf
RUN echo "mailhub=smtp.yandex.ru:465" >> /etc/ssmtp/ssmtp.conf

RUN echo "AuthUser=golopolosovartem@yandex.ru" >> /etc/ssmtp/ssmtp.conf
RUN echo "AuthPass=128900mgmggmgm" >> /etc/ssmtp/ssmtp.conf

RUN echo "UseTLS=YES" >> /etc/ssmtp/ssmtp.conf
RUN echo "UseSTARTTLS=YES" >> /etc/ssmtp/ssmtp.conf


# Set up php sendmail config
RUN echo "sendmail_path=sendmail -i -t" >> /usr/local/etc/php/conf.d/php-sendmail.ini



#sendmailer
    
# Ставим Composer'а.
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

USER www-data:www-data

# Указываем рабочую директорию для PHP
WORKDIR /var/www


# Запускаем контейнер
CMD ["php-fpm"]




