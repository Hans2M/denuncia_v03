FROM php:8.0-apache

# 1. Instalar dependencias
RUN apt-get update && apt-get install -y \
    git zip unzip \
    && rm -rf /var/lib/apt/lists/*

# 2. Crear estructura completa
RUN mkdir -p /var/www/html/{includes,assets/img,data/uploads}

# 3. Copiar todo el contenido
COPY includes/ /var/www/html/includes/
COPY public/ /var/www/html/
COPY assets/img/ /var/www/html/assets/img/
COPY data/ /var/www/html/data/
COPY *.php /var/www/html/

# 4. Configurar Apache para Render.com
RUN echo 'Listen ${PORT}' > /etc/apache2/ports.conf \
    && sed -ri 's/Listen 80/Listen ${PORT}/g' /etc/apache2/ports.conf \
    && sed -ri 's/<VirtualHost \*:80>/<VirtualHost \*:${PORT}>/g' /etc/apache2/sites-available/*.conf

# 5. Configurar PHP
RUN echo 'include_path = ".:/usr/local/lib/php:/var/www/html/includes"' > /usr/local/etc/php/conf.d/include-path.ini

# 6. Permisos y módulos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/data/uploads \
    && a2enmod rewrite

# 7. Limpieza final
RUN apt-get clean && rm -rf /tmp/* /var/tmp/*
