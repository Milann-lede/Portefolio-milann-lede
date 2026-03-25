# Portfolio — Milann Lédé

Mon portfolio personnel, avec un espace d'administration pour gérer le contenu dynamiquement via une base de données.

---

## Stack

- **HTML / CSS / JavaScript** — frontend
- **PHP** — traitement des formulaires, logique serveur
- **MySQL / PDO** — base de données
- **MAMP** — serveur local (Apache + MySQL)

---

## Fonctionnalités

- Page d'accueil avec compétences et projets chargés depuis la BDD
- Formulaire de contact qui enregistre les messages en base de données
- Panel d'administration protégé par session pour gérer :
  - les projets
  - les spécialités
  - les compétences
  - le parcours
  - la section "à propos"
  - le CV (PDF)

---

## Installation en local

Prérequis : [MAMP](https://www.mamp.info/)

1. Cloner le projet dans le dossier `htdocs` de MAMP
   ```bash
   git clone https://github.com/Milann-lede/Portefolio-milann-lede.git
   ```

2. Démarrer MAMP et ouvrir phpMyAdmin (`localhost:8889/phpMyAdmin`)

3. Créer une base de données nommée `cv` et importer les tables

4. Accéder au site sur `localhost:8889/portfolio-admin/`

---

## Structure

```
portfolio-admin/
├── index.php                   # Page d'accueil
├── asset/
│   ├── html/
│   │   ├── a-propos.php
│   │   ├── projets.php
│   │   └── contact.php         # Formulaire de contact (PHP + BDD)
│   ├── php/
│   │   ├── header.php          # Connexion BDD + session
│   │   ├── admin.php           # Dashboard admin
│   │   ├── login.php
│   │   ├── deconnexion.php
│   │   ├── projet/
│   │   ├── competence/
│   │   ├── specialite/
│   │   ├── parcours/
│   │   ├── apropos/
│   │   └── cv/
│   ├── style/
│   │   ├── styles.css
│   │   ├── admin.css
│   │   ├── contact.css
│   │   ├── projets.css
│   │   └── a-propos.css
│   ├── js/
│   │   └── script.js
│   └── image/
```

---

## Contact

Milann Lédé — [Milann.lede@icloud.com](mailto:Milann.lede@icloud.com)
[LinkedIn](https://www.linkedin.com/in/milann-lede/) · [GitHub](https://github.com/Milann-lede)
