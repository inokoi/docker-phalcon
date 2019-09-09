FROM ubuntu:16.04

RUN apt-get update
RUN apt-get install net-tools
RUN apt-get install -y curl
RUN curl -s "https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh" | bash
RUN apt-get -y install php7.0-phalcon php7.0-sqlite3 php7.0-fpm

RUN echo 'listen = 9000' >> /etc/php/7.0/fpm/pool.d/www.conf

RUN mkdir /run/php/
RUN chmod -R 777 /run/php/

RUN chmod -R +x /usr/sbin/
ENTRYPOINT /usr/sbin/php-fpm7.0 --nodaemonize