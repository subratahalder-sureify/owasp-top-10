FROM php:apache

COPY self-signed-ssl.conf /etc/apache2/sites-available/self-signed-ssl.conf

EXPOSE 80 443

WORKDIR /var/www/html

ADD . .

RUN a2enmod ssl
RUN a2ensite self-signed-ssl

CMD ["apache2-foreground"]
