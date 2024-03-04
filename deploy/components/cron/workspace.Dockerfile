FROM php:8.2-fpm-alpine3.17

USER root

COPY deploy/components/cron/crontab etc/cron.d/crontab
RUN crontab etc/cron.d/crontab

CMD ["crond", "-f", "-d", "8"]