# 🐉 ROADMAP — Saiyan Arts Portfolio

> Feuille de route officielle du blog portfolio DBZ.  
> Les priorités sont classées par puissance de niveau (🔥 = urgent / cosmique).

---

## 📊 Tableau de bord du Projet

| Indicateur | Statut |
|---|---|
| Version actuelle | **2.0** — Design GLSL + Shader cosmique |
| Prochain jalon | **2.1** — Recherche & Tags |
| État général | 🟢 Actif |
| Stack | PHP · SQLite · Three.js · GLSL |
| Dernière mise à jour de ce fichier | Juin 2025 |

---

---

## ✅ Version 1.0 — Le Tournoi des Arts

> Socle technique fondateur. Toutes les fonctionnalités de base livrées.

- [x] Design thématique DBZ (cosmique, organique, doré)
- [x] Ciel étoilé interactif via Three.js
- [x] Galerie responsive avec filtre par catégorie
- [x] Modal lightbox avec affichage des détails
- [x] Système de notation "Dragon Balls" (1 à 7)
- [x] Commentaires avec modération admin
- [x] Upload sécurisé des dessins (PHP + PDO)
- [x] Panneau d'administration complet
- [x] Base de données SQLite avec triggers automatiques
- [x] Protection anti-spam (limite de commentaires par IP)

---

## ✅ Version 2.0 — L'Éveil du Super Saiyan *(Actuelle)*

> Refonte visuelle complète. Le site atteint un niveau de qualité production.

- [x] **Shader GLSL Shadertoy-style** : ciel cosmique multi-couches en temps réel (nébuleuses, étoiles, aura Ki)
- [x] **Réactivité souris** dans le shader (rayons Ki, parallaxe)
- [x] **Curseur Ki personnalisé** : point doré lumineux + anneau avec lag
- [x] **Dragon Balls ultra-réalistes** : radial-gradient multi-couche, points canon, animation explosion
- [x] **Speedlines radiales** en flash à l'ouverture de chaque œuvre
- [x] **Particules Ki verticales** continues (CSS pur, sans lib)
- [x] **Typographies authentiques manga** : Bebas Neue, Noto Serif JP, Sawarabi Mincho
- [x] **Logotype avec contour noir** décalé façon titre de manga
- [x] **Kanji animés** dans la section À Propos (caractère 気)
- [x] **Stats héros** dynamiques (œuvres / votes / guerriers)
- [x] **Navigation sticky** avec soulignement animé et indicateur Power Level
- [x] **Animations scroll reveal** sur toutes les sections
- [x] **Étoile filante** avec traînée dans le shader
- [x] **Section `section-chapter`** avec titres japonais par section

---

## 🔥 Version 2.1 — La Saga de la Recherche

**Priorité : Haute · Estimation : 2–3 jours**

> Rendre la galerie vraiment navigable quand la collection grossit.

### Recherche & Filtrage
- [x] **Barre de recherche live** : input qui filtre en temps réel sur titre, tags et description sans rechargement
  - Debounce 300ms sur la frappe
  - Mise en surbrillance des termes trouvés dans les titres
  - Message "Aucun résultat" thématisé DBZ si vide
- [x] **Tags cliquables** : chaque tag dans une carte ouvre le filtre correspondant
  - Affichage des tags sous le titre dans les cartes (ex : `#Goku` `#SuperSaiyan`)
  - Les tags sont stockés en JSON dans la colonne `tags` de SQLite
- [x] **Tri dynamique** : menu déroulant avec options — *Plus récents, Mieux notés, Plus votés, Aléatoire*
- [x] **URL params** : les filtres actifs se reflètent dans l'URL (`?cat=fanart&sort=rating&q=goku`) pour partage et retour arrière navigateur

### Pagination
- [x] **Infinite scroll** : détection du bas de page via `IntersectionObserver`, chargement de la page suivante automatique
- [x] **Loader thématique** : Dragon Ball rebondissante entre les lots de résultats
- [x] **Compteur visible** : "Affichage 12/47 œuvres"

---

## ⚡ Version 2.2 — Le Tournoi de l'Image

**Priorité : Haute · Estimation : 3–4 jours**

> Améliorer radicalement la présentation des œuvres elles-mêmes.

### Lightbox avancée
- [ ] **Zoom natif dans le modal** : molette de souris ou pinch mobile pour zoomer l'image sans quitter le modal
- [ ] **Navigation ← → dans le modal** : flèches clavier et boutons pour passer à l'œuvre suivante / précédente sans fermer
  - Transition avec effet de flash Ki doré entre chaque œuvre
  - Swipe tactile sur mobile
- [ ] **Mode plein écran** : bouton pour afficher l'image seule sans les panneaux d'info (touches `F` ou double-clic)
- [ ] **Téléchargement activable** : option admin pour autoriser ou non le téléchargement d'une œuvre spécifique

### Galerie masonry
- [ ] **Layout masonry CSS** : colonnes de hauteur variable pour mieux valoriser les formats portrait, paysage, carré
  - Implémenté en CSS Grid natif (`grid-template-rows: masonry`) avec fallback JS
  - Transition de réorganisation animée lors du changement de filtre

### Optimisation images
- [ ] **Conversion WebP automatique** à l'upload côté PHP avec `GD` ou `Imagick`
- [ ] **Génération de miniatures** : 3 tailles (thumb 300px, medium 800px, full)
  - La galerie charge les miniatures, le modal charge le medium
  - Le full n'est servi qu'en mode zoom
- [ ] **Lazy loading natif** : attribut `loading="lazy"` + placeholder blur animé pendant le chargement

---

## 🌟 Version 2.5 — La Chambre de l'Esprit et du Temps

**Priorité : Moyenne · Estimation : 1 semaine**

> Améliorer l'expérience de l'artiste (toi) dans l'administration.

### Administration enrichie
- [ ] **Éditeur inline** : modifier le titre, la description, la catégorie et les tags d'un dessin directement dans l'admin sans supprimer/réuploader
  - Interface modal AJAX dans le panneau admin
  - Confirmation visuelle avec animation dorée
- [ ] **Réorganisation drag & drop** : changer l'ordre d'affichage des dessins dans la galerie par glisser-déposer
  - Colonne `sort_order` ajoutée à la table `drawings`
  - Sauvegarde automatique en AJAX
- [ ] **Mise en avant planifiée** : champ date/heure pour programmer la publication d'un dessin en avance
  - Colonne `published_at` nullable dans SQLite
  - Cron ou vérification au chargement de la galerie
- [ ] **Galerie des commentaires approuvés** : vue dédiée dans l'admin pour relire tous les commentaires publiés (pas seulement les en attente)
- [ ] **Export CSV/JSON** : bouton pour exporter la liste complète des dessins et leurs statistiques
- [ ] **Tableau de bord statistiques** :
  - Top 5 des dessins les mieux notés (graphique à barres simple HTML/CSS)
  - Courbe du nombre de votes par semaine
  - Nombre total de commentaires approuvés vs refusés

### Sécurité renforcée
- [ ] **Rate limiting login admin** : blocage temporaire de l'IP après 5 tentatives échouées (stockage en SQLite)
- [ ] **CSRF token** sur tous les formulaires admin et API POST
- [ ] **Changelog des actions admin** : table `admin_log` enregistrant chaque action (upload, suppression, modération) avec timestamp et IP
- [ ] **Changement de mot de passe** depuis l'interface admin (sans toucher au code)

---

## 🐉 Version 3.0 — Le Tournoi du Pouvoir

**Priorité : Moyenne · Estimation : 2 semaines**

> Transformer le portfolio solo en une vraie expérience communautaire.

### Séries & Albums
- [ ] **Table `series`** dans SQLite : regrouper des dessins en arcs narratifs (ex: *Saga Freezer*, *Arc Cell*, *Buu Chronicles*)
  - Page dédiée par série avec bannière, description et liste des œuvres
  - Navigation ordonnée à l'intérieur de la série depuis le modal
- [ ] **Progression visuelle** : barre de "saga" en bas du modal indiquant la position de l'œuvre dans sa série

### Système de favoris
- [ ] **Cookie local + table `favorites`** : sauvegarder ses œuvres préférées sans compte
  - Icône cœur animée sur chaque carte (style Ki qui explose)
  - Page `/favoris` récupérant les IDs stockés localement et affichant les œuvres correspondantes
  - Compteur de favoris total sur l'œuvre (anonyme, sans lien à un utilisateur)

### Partage social
- [ ] **Boutons de partage natifs** : Twitter/X, Pinterest, Mastodon, copier le lien
  - URL de partage avec `og:image`, `og:title`, `og:description` générés dynamiquement par PHP
  - Chaque dessin a sa propre URL shareable : `/dessin/12-goku-ssj3`
- [ ] **Balises Open Graph complètes** : prévisualisation riche sur Discord, WhatsApp, iMessage

### Flux RSS
- [ ] **`/rss.xml` généré dynamiquement** par PHP depuis SQLite
  - Les 20 derniers dessins publiés avec miniature et description
  - Lien RSS dans le `<head>` de chaque page

---

## 🌌 Version 4.0 — L'Arc de la Survie de l'Univers *(Long Terme)*

**Priorité : Basse · Vision sur 6–12 mois**

> Le portfolio devient une plateforme robuste, installable et multilingue.

### Progressive Web App (PWA)
- [ ] **`manifest.json`** : icône, couleur thème, affichage standalone
- [ ] **Service Worker** : cache des assets statiques pour accès hors-ligne
  - Stratégie *cache-first* pour les images
  - Stratégie *network-first* pour l'API JSON
- [ ] **Installation mobile** : prompt "Ajouter à l'écran d'accueil" avec branding DBZ

### Internationalisation
- [ ] **Fichiers de traduction JSON** : `lang/fr.json`, `lang/en.json`, `lang/ja.json`
  - Détection automatique de la langue navigateur
  - Toggle manuel FR / EN / 日本語 dans la nav
- [ ] **Furigana dynamiques** : affichage de la prononciation romaji au survol des titres japonais

### Performances & Infrastructure
- [ ] **Cache HTTP agressif** : headers `Cache-Control`, `ETag`, `Last-Modified` sur les images et l'API
- [ ] **Minification automatique** : script PHP de minification CSS/JS lors du déploiement
- [ ] **Migration optionnelle MySQL** : remplacement de SQLite par MySQL/MariaDB si le trafic le justifie (switch via constante de config)
- [ ] **Logs d'erreurs structurés** : fichier `data/errors.log` avec niveau, message, trace et date

### Monétisation éthique *(optionnel)*
- [ ] **Boutique prints** : lien affilié vers Redbubble/Society6 sur chaque dessin (opt-in par œuvre dans l'admin)
- [ ] **Page Commissions** : formulaire de demande avec détail (type, format, délai, budget)
  - Stockage dans table `commission_requests` SQLite
  - Notification email via `mail()` PHP
  - Statut de la commissions ouvertes/fermées contrôlable depuis l'admin
- [ ] **Ko-fi / Patreon widget** : encart optionnel dans le footer pour soutenir l'artiste

---

## 🛠️ Référence Technique

### Architecture des fichiers cible (v3.0)

```
dbz-portfolio/
├── index.php                    ← Frontend principal
├── dessin.php                   ← Page individuelle (SEO + og:tags)
├── favoris.php                  ← Page des favoris locaux
├── rss.php                      ← Flux RSS dynamique
├── manifest.json                ← PWA manifest
├── sw.js                        ← Service Worker
├── .htaccess                    ← Sécurité Apache + URL rewriting
│
├── php/
│   ├── db.php                   ← Connexion PDO SQLite
│   ├── config.php               ← Constantes et configuration
│   ├── auth.php                 ← Fonctions d'authentification
│   └── api/
│       ├── drawings.php         ← API dessins (list, single, vote, comment)
│       ├── series.php           ← API séries/albums
│       └── favorites.php        ← API favoris
│
├── admin/
│   ├── index.php                ← Dashboard admin
│   ├── edit.php                 ← Éditeur inline AJAX
│   ├── stats.php                ← Statistiques
│   └── log.php                  ← Journal des actions
│
├── data/
│   ├── schema.sql               ← Schéma SQLite complet
│   ├── portfolio.db             ← Base de données
│   └── errors.log               ← Logs d'erreurs
│
├── uploads/drawings/            ← Images originales
├── uploads/thumbs/              ← Miniatures 300px
├── uploads/medium/              ← Médiums 800px
│
├── lang/
│   ├── fr.json
│   ├── en.json
│   └── ja.json
│
└── assets/
    ├── css/                     ← CSS additionnels
    ├── js/                      ← JS additionnels
    └── images/                  ← Assets statiques
```

### Schéma SQLite cible (v3.0)

```sql
-- Tables à ajouter par rapport à la v2
CREATE TABLE series (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    title       TEXT NOT NULL,
    slug        TEXT UNIQUE NOT NULL,
    description TEXT,
    banner      TEXT,
    sort_order  INTEGER DEFAULT 0,
    created_at  TEXT DEFAULT (datetime('now'))
);

CREATE TABLE drawing_series (
    drawing_id INTEGER REFERENCES drawings(id) ON DELETE CASCADE,
    series_id  INTEGER REFERENCES series(id)  ON DELETE CASCADE,
    position   INTEGER DEFAULT 0,
    PRIMARY KEY (drawing_id, series_id)
);

CREATE TABLE favorites (
    id         INTEGER PRIMARY KEY AUTOINCREMENT,
    drawing_id INTEGER REFERENCES drawings(id) ON DELETE CASCADE,
    session_id TEXT NOT NULL,
    created_at TEXT DEFAULT (datetime('now')),
    UNIQUE(drawing_id, session_id)
);

CREATE TABLE admin_log (
    id         INTEGER PRIMARY KEY AUTOINCREMENT,
    admin_user TEXT NOT NULL,
    action     TEXT NOT NULL,
    target     TEXT,
    ip_hash    TEXT,
    created_at TEXT DEFAULT (datetime('now'))
);

CREATE TABLE commission_requests (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    name        TEXT NOT NULL,
    email       TEXT,
    type        TEXT,
    description TEXT,
    budget      TEXT,
    status      TEXT DEFAULT 'pending',
    created_at  TEXT DEFAULT (datetime('now'))
);

-- Colonnes à ajouter à `drawings`
ALTER TABLE drawings ADD COLUMN sort_order  INTEGER DEFAULT 0;
ALTER TABLE drawings ADD COLUMN published_at TEXT;
ALTER TABLE drawings ADD COLUMN allow_download INTEGER DEFAULT 0;
ALTER TABLE drawings ADD COLUMN view_count  INTEGER DEFAULT 0;
```

### Bonnes pratiques & Rappels de sécurité

| Sujet | Recommandation |
|---|---|
| PHP | Toujours valider côté serveur, jamais uniquement côté client |
| Mots de passe | Changer `dbz_admin_2024` **immédiatement** après installation |
| Uploads | Vérifier le MIME type via `finfo_file()`, jamais l'extension seule |
| SQLite WAL | `PRAGMA journal_mode = WAL` activé — ne pas désactiver |
| Sessions | `session_regenerate_id(true)` obligatoire après toute connexion |
| CSRF | Ajouter un token sur tous les `<form>` dès la v2.5 |
| HTTPS | Obligatoire en production — Let's Encrypt est gratuit |
| Backups | Sauvegarder `data/portfolio.db` et `uploads/` au minimum 1x/semaine |
| Images | Ne jamais servir un fichier uploadé sans passer par `readfile()` ou un `.htaccess` qui désactive l'exécution PHP dans `uploads/` |
| `.htaccess uploads/` | Ajouter `php_flag engine off` dans `uploads/drawings/.htaccess` |

---

---

## 📅 Journal des Versions

| Version | Nom de code | Contenu résumé | Statut |
|---|---|---|---|
| 1.0 | Le Tournoi des Arts | Socle PHP/SQLite, galerie, notation, commentaires | ✅ Livré |
| 2.0 | L'Éveil du Super Saiyan | Shader GLSL, curseur Ki, Dragon Balls HD, typo manga | ✅ Livré |
| 2.1 | La Saga de la Recherche | Recherche live, tags, tri, infinite scroll | 🔜 Prochain |
| 2.2 | Le Tournoi de l'Image | Zoom, navigation modal, masonry, WebP | 📋 Planifié |
| 2.5 | Chambre de l'Esprit et du Temps | Admin enrichi, drag & drop, CSRF, changelog | 📋 Planifié |
| 3.0 | Le Tournoi du Pouvoir | Séries, favoris, partage social, RSS | 🌙 Futur |
| 4.0 | L'Arc de la Survie de l'Univers | PWA, i18n, performances, commissions | 🌙 Futur |

---

*"Le pouvoir véritable ne vient pas de la force, mais de la volonté de transcender ses limites."*  
**— Son Goku**

*"Je n'ai pas besoin d'encouragements. Je surpasse mes limites par moi-même."*  
**— Vegeta**
