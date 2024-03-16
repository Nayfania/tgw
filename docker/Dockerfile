FROM php_8.1

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

RUN apt-get update
RUN apt-get install -y php8.1-xdebug

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
#add token to github so we can make 5000 requests per hour
RUN composer config -g github-oauth.github.com 5130c595ab51e1c9663da29cdb0ce2a864ea0729

COPY run.sh /run.sh

RUN chmod +x /run.sh

EXPOSE 80 1080
CMD ["/run.sh"]