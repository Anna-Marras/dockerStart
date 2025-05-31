FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql mysqli

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copie les dossiers au bon endroit
COPY public/ /var/www/html/public/
COPY app/ /var/www/html/app/
COPY images/ /var/www/images/

EXPOSE 80
