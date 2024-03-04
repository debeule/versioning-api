FROM php:8.2-fpm-alpine3.17

USER root

WORKDIR /code

COPY deploy/components/cron/setup.sh .
RUN chmod u+x /code/setup.sh && /code/setup.sh

COPY deploy/components/cron/crontab etc/cron.d/crontab
RUN crontab etc/cron.d/crontab

CMD ["crond", "-f", "-d", "8"]