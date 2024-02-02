# install composer
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# # install dependencies necessary for php extensions
# apk upgrade \
# && apk --update --no-cache add \
#     libzip-dev \
#     oniguruma-dev \
#     libpng-dev \
#     freetype-dev \
#     libjpeg-turbo-dev \
#     gmp-dev

# # configure php extensions
# docker-php-ext-configure gd \
#     && docker-php-ext-install gd zip pdo_mysql mbstring gmp bcmath

RUN apk --no-cache add \
    mysql-client \
    sqlite \
    libgomp

RUN apk --no-cache add pcre-dev magemagick-dev \
      && pecl install redis \
      && docker-php-ext-enable redis \
      && pecl install imagick \
      && docker-php-ext-enable imagick \
      && apk del pcre-dev imagemagick-dev \
      && rm -rf /tmp/pear


# add group & user for running app as non root user
addgroup -g 1000 -S app \
  && adduser -u 1000 -S app -G app \
  && chown app .