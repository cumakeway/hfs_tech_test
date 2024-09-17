FROM php:8.1-apache
RUN apt-get update && apt-get install sudo nano zip unzip
RUN docker-php-ext-install pdo pdo_mysql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer
ADD config/000-default.conf /etc/apache2/sites-available
RUN sudo a2enmod rewrite
CMD ["/bin/bash"]