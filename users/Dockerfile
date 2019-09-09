FROM ubuntu:16.04

RUN apt-get update

RUN apt-get -y install nginx

WORKDIR /etc/nginx
ADD nginx.conf /etc/nginx/nginx.conf

WORKDIR /var/www
RUN mkdir -p /var/www/users

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]