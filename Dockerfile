FROM php:8.0-apache

# Instala dependencias
RUN apt-get update && apt-get install -y \
    git zip unzip

# Copia TODOS los archivos necesarios
COPY public/ /var/www/html/
COPY includes/ /var/www/html/includes/

# Configura Apache para usar el puerto dinámico
RUN echo 'Listen ${PORT}' > /etc/apache2/ports.conf && \
    sed -ri 's/Listen 80/Listen ${PORT}/g' /etc/apache2/ports.conf && \
    sed -ri 's/<VirtualHost \*:80>/<VirtualHost \*:${PORT}>/g' /etc/apache2/sites-available/*.conf

# Configura el document root
ENV APACHE_DOCUMENT_ROOT /var/www/html
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Permisos
RUN chown -R www-data:www-data /var/www/html

# Configura el include_path de PHP
RUN echo 'include_path = ".:/usr/local/lib/php:/var/www/html/includes"' > /usr/local/etc/php/conf.d/include-path.ini
