FROM php:8.0-apache

# Instala gettext para envsubst y otras dependencias
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    gettext-base

# Copia los archivos al contenedor
COPY public/ /var/www/html/

# Configura Apache para usar el puerto de la variable de entorno
RUN echo 'Listen ${PORT}' > /etc/apache2/ports.conf
RUN a2enmod rewrite

# Configura el document root
ENV APACHE_DOCUMENT_ROOT /var/www/html
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html/index.php !${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html/informacion.php!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html/denuncia.php !${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html/includes !${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html/login.php  !${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf


# Script de entrada personalizado para manejar la variable PORT
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
ENTRYPOINT ["docker-entrypoint.sh"]

# Permisos
RUN chown -R www-data:www-data /var/www/html

# Comando predeterminado para iniciar Apache
CMD ["apache2-foreground"]
