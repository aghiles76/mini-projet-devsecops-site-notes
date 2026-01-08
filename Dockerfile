FROM php:8.2-apache

# Active mod_rewrite si besoin
RUN a2enmod rewrite headers

# Copie le code
COPY . /var/www/html/

# (Optionnel) permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

