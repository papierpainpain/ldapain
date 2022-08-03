FROM alpine:latest

WORKDIR /ldapain


RUN apk update && apk upgrade \
    && apk add bash nginx \
    && apk add php81 php81-fpm php81-opcache \
    && apk add php81-gd php81-zlib php81-curl \
    && apk add php81-mbstring php81-ldap php81-openssl \
    && apk add php81-session php81-tokenizer \
    && apk add nodejs npm

RUN npm install -g npm@8.15.1

COPY ci/nginx.conf /etc/nginx/http.d/default.conf
COPY ci/www.conf /etc/php81/php-fpm.d/www.conf

COPY package*.json ./


ENV APP_ENV=prod
ENV APP_NAME="LDAPain"
ENV API_BASE="api/"

ENV LDAP_HOST=""
ENV LDAP_PORT="389"
ENV LDAP_ADMIN_USER=""
ENV LDAP_ADMIN_PASS=""
ENV LDAP_USERS_BASE=""
ENV LDAP_GROUPS_BASE=""
ENV LDAP_ADMIN_GROUP="admin"

ENV SMTP_HOST=""
ENV SMTP_PORT="587"
ENV SMTP_USER=""
ENV SMTP_PASS=""

ENV JWT_SECRET=""
ENV JWT_ALGORITHM="HS256"
ENV JWT_ISSUER="LDAPain"
ENV JWT_AUDIENCE=""


RUN npm install

EXPOSE 3000

STOPSIGNAL SIGTERM

CMD ["/bin/bash", "-c", "php-fpm81 && nginx -g 'daemon off;' & npm start"]
