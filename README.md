# LDAPain

## Description

Site web de gestion de comptes LDAP.

**LDAPain** se divise en deux partie :

-   Les **API** (serveur) : Qui gère les routes pour accéder aux fonctionnalities de ldap (en PHP) ;
-   Et le **Client** : L'interface web qui permet de gérer les comptes LDAP (en React).

## Release note

### Version 2.0.0

Début de la release : _06.08.22_

| Type  | Ticket | Sujet                                                                                       |
| ----- | ------ | ------------------------------------------------------------------------------------------- |
| Story | PAP-13 | Réinitialiser le mot de passe d’un utilisateur                                              |
| Bug   | PAP-76 | Correction de l'affichage des notifications                                                 |
| Bug   | PAP-75 | Corriger les erreurs du linter                                                              |
| Story | PAP-5  | Playbook de déploiement de LDAPain                                                          |
| Story | PAP-74 | Linter sur les merge requests                                                               |
| Story | PAP-72 | Revue du CICD                                                                               |
| Story | PAP-11 | Supprimer un utilisateur                                                                    |
| Story | PAP-10 | Ajouter un utilisateur                                                                      |
| Story | PAP-9  | Page des utilisateurs                                                                       |
| Story | PAP-19 | Gif dans le menu                                                                            |
| Story | PAP-7  | Refaire le README                                                                           |
| Story | PAP-4  | Création d’un Dockerfile de développement (fichier en local avec environnement fonctionnel) |
| Story | PAP-30 | Gestion des appels aux APIs sans le fichier .env                                            |
| Story | PAP-65 | Creation de l'application React                                                             |
| Story | PAP-64 | Initialisation des APIs php                                                                 |
| Bug   | PAP-6  | Suppression des fichiers de mots de passe de l’historique du git                            |

### Version 1.0.0

Début de la release : _Il y a plus de 2 mois_

| Type  | Ticket | Sujet            |
| ----- | ------ | ---------------- |
| Story | /      | Première version |

## Développement

Clonez le projet puis suivez les instructions suivantes pour **docker** :

-   Installez docker et docker compose avec le [lien ici](https://docs.docker.com/engine/install/) ;
-   Ajoutez le fichier de configuration des variables de l'environnement (`.env.local`) :

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

-   Puis dans le dossier du projet exécutez les commandes suivantes :

    ```bash
    docker-compose up --build -d # Build et démarre le serveur docker
    docker-compose up -d # Démarre le serveur docker seulement
    ```
