# LDAPAIN

## Description

Site web de gestion de comptes LDAP.

LDAPAIN se divise en deux partie :

* Les **API** (serveur) : Qui gère les routes pour accéder aux fonctionnalities de ldap (en PHP) ;
* Et le **Client** : L'interface web qui permet de gérer les comptes LDAP (en React).

## Mise en place en local

Clonez le projet puis suivez les instructions suivantes pour le serveur et le client.

### Serveur (PHP)

Installation de PHP :

```bash
sudo apt install php8.1 php8.1-mbstring php8.1-ldap
```

Ensuite il faut configurer composer pour que la mise à jour des dépendances soit automatique. Pour cela vous pouvez aller directement à l'adresse suivante : <https://getcomposer.org/download/>

Ensuite si vous mettez à jour l'arborescence de votre projet (les paths ou les namespaces), il faut lancer :

```bash
composer dump-autoload
```

### Client (React)

Installation de nodejs et react :

```bash
curl -fsSL https://deb.nodesource.com/setup_16.x | sudo -E bash -
sudo apt-get install -y nodejs
npm install -g create-react-app
```

Puis suivez les instructions suivantes :

```bash
npm install
```

### Lancement de l'application

Pour lancer l'application, il faut lancer :

```bash
php -S localhost:8000 -t api/ # Pour le serveur
npm start # Pour le client
```
