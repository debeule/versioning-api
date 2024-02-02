FROM php:8.2-fpm-alpine3.17

USER root

WORKDIR /code

# Install container deps that apply to all target environments...
COPY deploy/components/app/setup.sh .
RUN chmod u+x /code/setup.sh && /code/setup.sh

COPY . /code

USER app

EXPOSE 9000

CMD ["php-fpm"]