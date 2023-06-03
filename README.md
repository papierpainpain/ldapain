# LDAPain

## Description

Site web de gestion de comptes LDAP.

**LDAPain** se divise en deux parties :

-   Les **API** (serveur) : Qui gère les routes pour accéder aux fonctionnalities de ldap (en PHP) ;
-   Et le **Client** : L'interface web qui permet de gérer les comptes LDAP (en React).

## Développement

Clonez le projet puis suivez les instructions suivantes pour **docker** :

-   Installez docker et docker compose avec le [lien ici](https://docs.docker.com/engine/install/) ;
-   Installez node v18.16.0 ;
-   Ajoutez le fichier de configuration des variables de l'environnement (`web/.env.development.local`) :

    ```conf
    # NOTE: THIS IS DANGEROUS!
    # It exposes your machine to attacks from the websites you visit.
    DANGEROUSLY_DISABLE_HOST_CHECK=true
    ```

    Pour avoir quelque chose de plus propre voir ici : [create-react-app.dev](https://create-react-app.dev/docs/proxying-api-requests-in-development/#invalid-host-header-errors-after-configuring-proxy)

-   Puis exécutez les commandes suivantes :

    ```bash
    docker-compose -f .gitpod/docker-compose.yml up -d # Démarre le serveur docker pour l'API
    cd web && npm install && npm run start # Démarre le serveur web
    ```
