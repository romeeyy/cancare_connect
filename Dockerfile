FROM php:8.2-apache

RUN docker-php-ext-install pdo_mysql \
    && a2enmod rewrite

WORKDIR /var/www/html
COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html

CMD ["bash", "-c", "render_port=${PORT:-10000}; sed -i \"s/^Listen 80/Listen ${render_port}/; s/\\*:80/\\*:${render_port}/\" /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf && apache2-foreground"]
