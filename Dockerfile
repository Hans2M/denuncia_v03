FROM php:8.0-apache

# 1. Instalar dependencias esenciales
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# 2. Crear estructura de directorios
RUN mkdir -p /var/www/html/{data/uploads,assets/img,css,js}

# 3. Copiar archivos con verificación previa
COPY --chown=www-data:www-data includes/ /var/www/html/includes/
COPY --chown=www-data:www-data public/ /var/www/html/
COPY --chown=www-data:www-data assets/img/ /var/www/html/assets/img/
COPY --chown=www-data:www-data data/ /var/www/html/data/
COPY --chown=www-data:www-data *.php /var/www/html/

# 4. Copiar CSS y JS solo si existen (manera compatible)
RUN [ -d css ] && cp -r css/ /var/www/html/ || echo "Info: Directorio css no encontrado - omitiendo"
RUN [ -d js ] && cp -r js/ /var/www/html/ || echo "Info: Directorio js no encontrado - omitiendo"
RUN [ -f .htaccess ] && cp .htaccess /var/www/html/ || echo "Info: .htaccess no encontrado - omitiendo"

# 5. Configurar Apache para Render.com
RUN echo 'Listen ${PORT}' > /etc/apache2/ports.conf \
    && sed -ri 's/Listen 80/Listen ${PORT}/g' /etc/apache2/ports.conf \
    && sed -ri 's/<VirtualHost \*:80>/<VirtualHost \*:${PORT}>/g' /etc/apache2/sites-available/*.conf

# 6. Configurar PHP
RUN echo 'include_path = ".:/usr/local/lib/php:/var/www/html/includes"' > /usr/local/etc/php/conf.d/include-path.ini \
    && echo 'memory_limit = 256M' >> /usr/local/etc/php/conf.d/custom.ini

# 7. Configurar permisos
RUN chmod -R 755 /var/www/html/data/uploads

# 8. Habilitar módulos Apache
RUN a2enmod rewrite headers

# 9. Limpieza para reducir tamaño de imagen
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
