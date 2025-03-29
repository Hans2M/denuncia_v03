FROM php:8.0-apache

# Copia los archivos al contenedor
COPY . /var/www/html/

# Configura el directorio público
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Instala dependencias si las necesitas
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Permisos para archivos
RUN chown -R www-data:www-data /var/www/html