FROM registry.papierpain.fr/docker/alpine-php81-nginx:stable

WORKDIR /ldapain

RUN apk add --no-cache --update nodejs npm

COPY ci/nginx.conf /etc/nginx/http.d/default.conf
COPY ci/www.conf /etc/php81/php-fpm.d/www.conf

COPY package*.json ./

RUN npm install

EXPOSE 3000

STOPSIGNAL SIGTERM

CMD ["/bin/bash", "-c", "php-fpm81 && nginx -g 'daemon off;' & npm start"]
