# ldap-account-manager

Liens :

- #<http://docs.switzernet.com/3/public/101010-ldap/>
- <http://tutoriels.meddeb.net/openldap-password-policy/>
- #<https://man7.org/linux/man-pages/man8/slapcat.8.html>
- <https://gitlab.papierpain.fr/-/snippets/1>
- <https://www.howtoforge.com/community/threads/openldap-install-fails-berklydb-configure-error-bdb-hdb-berkeleydb-not-availabl.54176/>

## Setup en local

- Cloner le projet ;
- Setup composer :

```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '906a84df04cea2aa72f40b5f787e49f22d4c2f19492ac310e8cba5b96ac8b64115ac402c8cd292b8a03482574915d1a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
sudo mv composer.phar /usr/local/bin/composer
```

- Si vous changez les paths ou namespaces :

```bash
composer dump-autoload
```

Pour que cela fonctionne, il vous faut également définir les variables d'environnement dans le fichier `env.php`.
Supprimer la partie admin admin du fichier `app/models/Account.php` pour désactiver l'adminstration.
