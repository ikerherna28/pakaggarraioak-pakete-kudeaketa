FROM php:8.2-fpm

ARG WITH_XDEBUG=true

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        # sendmail \
        ssmtp \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install pdo pdo_mysql; \
    if [ $WITH_XDEBUG = "true" ] ; then \
        pecl install xdebug; \
    fi ;

# ADD ./php/php.sh /opt/php.sh
# ADD ./php/sendmail.ini /usr/local/etc/php/conf.d/
# RUN chmod u+x /opt/php.sh
# WORKDIR /opt

# ENTRYPOINT ["/opt/php.sh"]

# CMD ["php.sh"]