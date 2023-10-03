# Projet : Site communautaire pour apprendre les figures de snowboard

## Présentation

Jimmy Sweat, passionné de snowboard, a l'ambition de créer un site collaboratif dédié à l'apprentissage des figures de snowboard. Ce projet vise à promouvoir le snowboard auprès du grand public et à permettre aux utilisateurs d'apprendre, de discuter et de partager des figures (ou "tricks").

## Fonctionnalités

- Annuaire des figures de snowboard (10 figures initiales).
- Gestion des figures : création, modification, consultation.
- Espace de discussion commun pour chaque figure.

## Pages

1. Page d’accueil : Liste des figures.
2. Page de création d'une nouvelle figure.
3. Page de modification d'une figure.
4. Page de présentation d’une figure : Détails de la figure avec espace de discussion.

## URL

Les URL ont été conçues pour une compréhension rapide et un bon référencement. Par exemple:
- `/figures` pour la liste des figures.
- `/figure/nom-de-la-figure` pour les détails d'une figure.
- `/figure/nom-de-la-figure/edit` pour modifier une figure.
- `/figure/new` pour créer une nouvelle figure.

## Technologie

- **Framework** : Symfony 6.
- **Base de données** : Utilisation de Docker pour la BDD.
- **Mailer** : Docker pour le mailer.

## Installation et Configuration

1. **Clonez le repository GitHub** :


```bash
git clone https://github.com/GaetanLgt/OC-P6-Snowtricks2 
```
2. Lancer Docker pour la BDD et le Mailer :
```bash
docker-compose up -d
``` 

3. Installer les dépendances avec Composer :
```bash
composer install
```

4. Charger les données initiales des figures :
Un bundle externe a été utilisé pour charger ces données initiales.
```bash
php bin/console doctrine:fixtures:load
```

5. Démarrer le serveur Symfony :
```bash
symfony server:start
```

6. Accéder au site :  
Ouvrez votre navigateur et naviguez vers http://localhost:8000.  


-- Design --  
Le design est responsive et s'adapte à la fois aux ordinateurs et aux appareils mobiles.  

-- Contribuer --  
Les contributions sont les bienvenues! Pour contribuer :  

-- Fork le dépôt --  
Créez une nouvelle branche.  
Faites vos changements et soumettez une pull request.  


