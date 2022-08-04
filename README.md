# LDAPAIN

## Description

Site web de gestion de comptes LDAP.

LDAPAIN se divise en deux partie :

* Les **API** (serveur) : Qui gère les routes pour accéder aux fonctionnalities de ldap (en PHP) ;
* Et le **Client** : L'interface web qui permet de gérer les comptes LDAP (en React).

## Développement

Clonez le projet puis suivez les instructions suivantes pour docker :

* Installez docker et docker compose avec le [lien ici](https://docs.docker.com/engine/install/) ;
* Puis dans le dossier du projet exécutez les commandes suivantes :

    ```bash
    docker-compose up --build -d # Build et démarre le serveur docker
    docker-compose up -d # Démarre le serveur docker seulement
    ```

* Ajoutez le fichier de configuration des variables de l'environnement (`.env.local`) :

    ```conf
    APP_ENV="dev"

    LDAP_HOST="<votre-ldap-host>"
    LDAP_USERS_BASE="<votre-ldap-users-base>"
    LDAP_GROUPS_BASE="<votre-ldap-groups-base>"

    LDAP_ADMIN_USER="<votre-ldap-admin-user>"
    LDAP_ADMIN_PASS="<votre-ldap-admin-pass>"

    SMTP_HOST="smtp-mail.outlook.com"
    SMTP_PORT="587"
    SMTP_USER="<votre-mail>"
    SMTP_PASS="<votre-mot-de-passe>"

    JWT_SECRET="<votre-secret>"
    JWT_AUDIENCE="ldapain.papierpain.fr"
    ```

## Sources

* [React local development with docker compose](https://medium.com/bb-tutorials-and-thoughts/react-local-development-with-docker-compose-5a247710f997)
