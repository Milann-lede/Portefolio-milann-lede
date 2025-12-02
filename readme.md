# 🎨 Portfolio - Milann Lédé

![Version](https://img.shields.io/badge/version-2.0.0-blue.svg)
![License](https://img.shields.io/badge/license-MIT-green.svg)
![Status](https://img.shields.io/badge/status-Active-success.svg)

Bienvenue sur le dépôt de mon **Portfolio Personnel**. Ce projet est une vitrine de mes compétences et réalisations en tant que Développeur Web. Il a évolué d'un site statique vers une **Single Page Application (SPA)** dynamique administrable.

---

## ✨ Fonctionnalités Clés

### 🚀 Expérience Utilisateur
*   **Design Moderne & Responsive** : Interface soignée, animations fluides et adaptation parfaite sur mobile/tablette.
*   **Deep Linking** : Les projets mis en avant sur l'accueil redirigent directement vers leurs détails.
*   **Formulaire de Contact** : Intégration fonctionnelle avec **EmailJS**.

### 🛠️ Panel Administrateur (Nouveau !)
Gérez le contenu du site sans toucher une ligne de code grâce au nouveau Dashboard sécurisé.
*   **Ajout de Projets** : Formulaire complet pour ajouter de nouvelles réalisations.
*   **Nouvelle Catégorie "IA" 🤖** : Créez et filtrez spécifiquement les projets liés à l'Intelligence Artificielle.
*   **Mode "Projet Phare" ⭐** : Sélectionnez les projets à afficher dans le carousel de l'accueil.
*   **Système d'Archives** : Supprimez (archivez) des projets et restaurez-les si besoin (Soft Delete).
*   **Persistance** : Toutes les données sont sauvegardées localement dans votre navigateur (`localStorage`).

---

## 💻 Stack Technique

| Technologie | Usage |
| :--- | :--- |
| ![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=flat-square&logo=html5&logoColor=white) | Structure sémantique et accessible |
| ![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=flat-square&logo=css3&logoColor=white) | Design, Flexbox, Grid, Animations |
| ![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=flat-square&logo=javascript&logoColor=black) | Logique dynamique, DOM, LocalStorage |
| ![EmailJS](https://img.shields.io/badge/EmailJS-F7DF1E?style=flat-square&logo=gmail&logoColor=black) | Envoi d'emails sans serveur backend |

---

## 🚀 Installation & Utilisation

Ce projet ne nécessite **aucune installation serveur** (Node.js, PHP, etc.). Il fonctionne directement dans le navigateur.

1.  **Cloner le projet**
    ```bash
    git clone https://github.com/Milann-lede/Portefolio-milann-lede.git
    ```
2.  **Ouvrir le site**
    *   Ouvrez simplement le fichier `index.html` dans votre navigateur.
    *   *Recommandé :* Utilisez l'extension "Live Server" de VS Code pour une meilleure expérience.

---

## 🔐 Accès Admin

Pour accéder au panel d'administration et gérer les projets :

1.  Cliquez sur le lien **"Admin"** caché tout en bas à droite du footer.
2.  Connectez-vous avec les identifiants de démonstration :
    *   **Utilisateur** : `Milann`
    *   **Mot de passe** : `1234`

> **Note :** Les données étant stockées dans le `localStorage`, si vous changez de navigateur ou videz le cache, les projets ajoutés manuellement disparaîtront (mais les projets par défaut peuvent être restaurés en un clic).

---

## 📂 Structure du Projet

```
📁 Portefolio-milann-lede/
├── 📄 index.html          # Page d'accueil
├── 📄 projets.html        # Liste des projets
├── 📄 a-propos.html       # CV et parcours
├── 📄 contact.html        # Formulaire de contact
├── 📁 admin/              # Interface d'administration
│   ├── 📄 login.html
│   ├── 📄 dashboard.html
│   └── 📄 admin.js
├── 📁 asset/
│   ├── 📁 style/          # Feuilles de style CSS
│   ├── 📁 JS/             # Scripts (projets.js, scrip.js)
│   └── 📁 image/          # Images et assets
└── 📄 RAPPORT_TECHNIQUE.html # Documentation détaillée
```

---

## 📞 Contact

**Milann Lédé**  
📧 [Milann.lede@icloud.com](mailto:Milann.lede@icloud.com)  
🔗 [LinkedIn](https://www.linkedin.com/in/milann-lede/) | [GitHub](https://github.com/Milann-lede)

---

*Fait avec ❤️ par Milann.*