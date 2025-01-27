FROM registry.papierpain.fr/docker/alpine-php81-nginx:stable

LABEL Maintainer="PapierPain <papierpain4287@outlook.fr>"
LABEL Description="LDAPain container to manage OpenLDAP"

WORKDIR /ldapain

COPY ci/nginx.conf /etc/nginx/http.d/default.conf
COPY ci/www.conf /etc/php81/php-fpm.d/www.conf
COPY api /ldapain/api
COPY web/build /ldapain/web

ENV APP_ENV=prod
ENV APP_NAME="LDAPain"
ENV API_BASE="api/"

ENV LDAP_HOST="ldap.example.com"
ENV LDAP_PORT="389"
ENV LDAP_ADMIN_USER="cn=admin,dc=example,dc=com"
ENV LDAP_ADMIN_PASS="admin"
ENV LDAP_USERS_BASE="ou=users,dc=example,dc=com"
ENV LDAP_GROUPS_BASE="ou=groups,dc=example,dc=com"
ENV LDAP_ADMIN_GROUP="admin"

ENV SMTP_HOST="smtp-mail.outlook.com"
ENV SMTP_PORT="587"
ENV SMTP_USER="user"
ENV SMTP_PASS="password"

ENV JWT_SECRET="secret"
ENV JWT_ALGORITHM="HS256"
ENV JWT_ISSUER="LDAPain"
ENV JWT_AUDIENCE="LDAPain"
