FROM php:7.4-fpm

COPY --from=composer /usr/bin/composer /usr/bin/composer

VOLUME /var/www/html/

USER nobody

WORKDIR /var/www/html/

EXPOSE 8000

CMD ["php -S 0.0.0.0:8000 -t public/"]

HEALTHCHECK --interval=30s --timeout=30s CMD curl --silent --fail http://127.0.0.1:8000
