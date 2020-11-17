FROM debian:buster


RUN apt-get update && apt-get install -y nginx openssl

#######
# Setting up nginx for Travaux-API
#######

ADD nginx.conf /etc/nginx/
ADD nginx-gao.conf /etc/nginx/sites-available/gao.conf

RUN ln -s /etc/nginx/sites-available/gao.conf /etc/nginx/sites-enabled/gao
RUN rm /etc/nginx/sites-enabled/default

RUN echo "upstream php-upstream { server php:9000; }" > /etc/nginx/conf.d/upstream.conf

RUN chown -R www-data:www-data /var/www/


WORKDIR /var/www


CMD ["nginx"]

EXPOSE 80
EXPOSE 443