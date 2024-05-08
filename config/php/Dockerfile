
FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
        curl \
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
        libonig-dev \
        libwebp-dev \

    && docker-php-ext-install -j$(nproc) iconv  mysqli pdo_mysql zip \
 

    && docker-php-ext-configure gd --with-freetype   --with-webp  --with-jpeg  \

    && docker-php-ext-install -j$(nproc) gd

###############-------#################################
#RUN apt-get update \
    #&& apt-get install php-pear \
    #&& apt-get install -y gpg unixodbc unixodbc-dev \
    #&& docker-php-ext-install pdo pdo_mysql \
    #&& pecl install sqlsrv pdo_sqlsrv

# ------------ Install MS SQL client deps ------------ #
# adding custom MS repository
RUN curl -s  https://packages.microsoft.com/keys/microsoft.asc |  tee /etc/apt/trusted.gpg.d/microsoft.asc



RUN curl http://packages.microsoft.com/config/ubuntu/22.04/prod.list | tee /etc/apt/sources.list.d/mssql-release.list

RUN apt-get update 
RUN ACCEPT_EULA=Y apt-get -y --no-install-recommends install -y   unixodbc-dev 
RUN pecl install sqlsrv
RUN pecl install pdo_sqlsrv
RUN docker-php-ext-enable sqlsrv pdo_sqlsrv
# -------------- END MSSQL -------------------------------- #
###########--------------------####################

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




