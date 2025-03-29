#!/bin/bash

# Genera el archivo de configuración de puerto usando la variable PORT
envsubst < /etc/apache2/ports.conf.template > /etc/apache2/ports.conf

# Ejecuta el comando original de Apache
exec "$@"