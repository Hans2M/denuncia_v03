FROM php:8.0-apache

# 1. Instalar dependencias
RUN apt-get update && apt-get install -y \
    git zip unzip

# 2. Crear estructura de directorios
RUN mkdir -p /var/www/html/data/uploads && \
    mkdir -p /var/www/html/assets/img

# 3. Copiar archivos principales
COPY includes/ /var/www/html/includes/
COPY public/ /var/www/html/
COPY css/ /var/www/html/css/
COPY js/ /var/www/html/js/
COPY assets/img/ /var/www/html/assets/img/
COPY data/ /var/www/html/data/
COPY *.php /var/www/html/

# 4. Copiar .htaccess si existe (manera compatible)
RUN if [ -f .htaccess ]; then \
    cp .htaccess /var/www/html/ && \
    echo ".htaccess copiado correctamente"; \
    else \
    echo "Advertencia: No se encontró .htaccess, continuando..."; \
    fi

# 5. Configurar Apache
RUN echo 'Listen ${PORT}' > /etc/apache2/ports.conf && \
    sed -ri 's/Listen 80/Listen ${PORT}/g' /etc/apache2/ports.conf && \
    sed -ri 's/<VirtualHost \*:80>/<VirtualHost \*:${PORT}>/g' /etc/apache2/sites-available/*.conf

# 6. Configurar permisos
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html/data/uploads

# 7. Configurar PHP includes
RUN echo 'include_path = ".:/usr/local/lib/php:/var/www/html/includes"' > /usr/local/etc/php/conf.d/include-path.ini

# 8. Habilitar mod_rewrite
RUN a2enmod rewrite
