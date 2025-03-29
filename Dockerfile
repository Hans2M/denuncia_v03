FROM php:8.0-apache

# Copia los archivos al contenedor
COPY public/ /var/www/html/

# Configura Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Instala dependencias si las necesitas
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip

# Permisos
RUN chown -R www-data:www-data /var/www/html