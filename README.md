# 🐉 Saiyan Arts — Portfolio DBZ

Blog portfolio de dessins inspiré de l'univers Dragon Ball Z.  
Stack : **HTML / CSS / Three.js / PHP / SQLite**

---

## 📁 Structure du Projet

```
dbz-portfolio/
├── index.php                  ← Frontend principal
├── .htaccess                  ← Sécurité Apache
├── ROADMAP.md                 ← Feuille de route
├── README.md                  ← Ce fichier
│
├── php/
│   ├── db.php                 ← Connexion PDO + init DB
│   └── api/
│       └── drawings.php       ← API JSON (list, single, vote, comment)
│
├── admin/
│   └── index.php              ← Panneau admin (upload, modération)
│
├── data/
│   ├── schema.sql             ← Schéma SQLite
│   └── portfolio.db           ← Base SQLite (créée automatiquement)
│
├── uploads/
│   └── drawings/              ← Images uploadées (755)
│
└── assets/
    ├── css/                   ← CSS additionnels (optionnel)
    ├── js/                    ← JS additionnels (optionnel)
    └── images/                ← Images statiques du site
```

---

## ⚙️ Installation (XAMPP / MAMP)

### 1. Copier le projet

**XAMPP (Windows/Linux) :**
```
C:\xampp\htdocs\dbz-portfolio\
```

**MAMP (macOS) :**
```
/Applications/MAMP/htdocs/dbz-portfolio/
```

### 2. Activer l'extension PDO SQLite

Dans `php.ini`, vérifier que ces lignes sont actives (sans `;`) :
```ini
extension=pdo_sqlite
extension=sqlite3
extension=fileinfo
```

Redémarrer Apache après modification.

### 3. Permissions des dossiers

Sur Linux/macOS :
```bash
chmod 755 uploads/drawings/
chmod 755 data/
```

Sur Windows : clic droit → Propriétés → Sécurité → accès en écriture pour le groupe Apache/www-data.

### 4. Activer mod_headers (pour .htaccess)

**XAMPP :** Dans `httpd.conf`, décommenter :
```apache
LoadModule headers_module modules/mod_headers.so
```

### 5. Premier accès

- **Site public :** `http://localhost/dbz-portfolio/`
- **Admin :** `http://localhost/dbz-portfolio/admin/`
  - Utilisateur : `admin`
  - Mot de passe : `dbz_admin_2024` ← **À CHANGER IMMÉDIATEMENT**

La base SQLite est créée automatiquement au premier accès.

---

## 🔒 Sécurité — Actions Obligatoires

1. **Changer le mot de passe admin** via la console SQLite ou en modifiant `php/db.php` :
   ```php
   password_hash('VOTRE_NOUVEAU_MOT_DE_PASSE', PASSWORD_BCRYPT)
   ```

2. **Protéger le dossier `data/`** : vérifier que `.htaccess` bloque l'accès à `.db`.

3. **En production :** activer HTTPS et mettre `display_errors = Off`.

---

## 📡 API Publique

| Endpoint | Méthode | Description |
|---|---|---|
| `?action=list` | GET | Liste des dessins (avec `?category=fanart&limit=12&offset=0`) |
| `?action=single&id=1` | GET | Détail d'un dessin + commentaires |
| `?action=vote` | POST | Voter (body JSON : `{drawing_id, rating}`) |
| `?action=comment` | POST | Commenter (body JSON : `{drawing_id, author_name, content}`) |

---

## 🎨 Personnalisation

- **Couleurs :** éditer les variables CSS dans `index.php` (section `:root`)
- **Titre du site :** remplacer `Saiyan Arts` dans `index.php`
- **Catégories :** ajouter des options dans `admin/index.php` et `index.php`
- **Three.js :** ajuster le nombre d'étoiles et la densité de particules dans le bloc `initThree()`
