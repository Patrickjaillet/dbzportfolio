<?php
// ============================================
// admin/index.php — Panneau d'administration
// ============================================
require_once __DIR__ . '/../php/db.php';

session_start();

$db      = getDB();
$message = '';
$error   = '';

// ─── Authentification ──────────────────────────────────
if (isset($_POST['action']) && $_POST['action'] === 'login') {
    $username = sanitize($_POST['username'] ?? '', 80);
    $password = $_POST['password'] ?? '';

    $stmt = $db->prepare('SELECT * FROM admin_users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_user']      = $username;
        $db->prepare('UPDATE admin_users SET last_login = datetime("now") WHERE id = ?')->execute([$user['id']]);
        header('Location: index.php');
        exit;
    } else {
        $error = 'Identifiants incorrects. Puissance insuffisante !';
        sleep(1); // Anti brute-force basique
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}

$isLoggedIn = !empty($_SESSION['admin_logged_in']);

// ─── Actions admin ─────────────────────────────────────
if ($isLoggedIn) {

    // Upload d'un dessin
    if (isset($_POST['action']) && $_POST['action'] === 'upload') {
        $title       = sanitize($_POST['title'] ?? '', 200);
        $description = sanitize($_POST['description'] ?? '', 2000);
        $category    = sanitize($_POST['category'] ?? 'fanart', 50);
        $tags        = sanitize($_POST['tags'] ?? '', 200);
        $featured    = isset($_POST['is_featured']) ? 1 : 0;

        if (!$title) {
            $error = 'Le titre est obligatoire.';
        } elseif (empty($_FILES['image']['name'])) {
            $error = 'Aucune image sélectionnée.';
        } else {
            $file     = $_FILES['image'];
            $finfo    = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);

            if (!in_array($mimeType, ALLOWED_TYPES)) {
                $error = 'Type de fichier non autorisé (JPG, PNG, WebP, GIF uniquement).';
            } elseif ($file['size'] > MAX_FILE_SIZE) {
                $error = 'Fichier trop volumineux (max 8 Mo).';
            } else {
                $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = uniqid('dbz_', true) . '.' . strtolower($ext);
                $dest     = UPLOAD_DIR . $filename;

                if (move_uploaded_file($file['tmp_name'], $dest)) {
                    $stmt = $db->prepare('
                        INSERT INTO drawings (title, description, filename, category, tags, is_featured)
                        VALUES (?, ?, ?, ?, ?, ?)
                    ');
                    $stmt->execute([$title, $description, $filename, $category, $tags, $featured]);
                    $message = '✅ Dessin "' . htmlspecialchars($title) . '" ajouté avec succès !';
                } else {
                    $error = 'Erreur lors du déplacement du fichier. Vérifiez les permissions du dossier uploads/.';
                }
            }
        }
    }

    // Modération commentaires
    if (isset($_POST['action']) && $_POST['action'] === 'moderate_comment') {
        $commentId = (int)($_POST['comment_id'] ?? 0);
        $approve   = (int)($_POST['approve'] ?? 0);

        if ($commentId) {
            if ($approve === -1) {
                $db->prepare('DELETE FROM comments WHERE id = ?')->execute([$commentId]);
                $message = '🗑️ Commentaire supprimé.';
            } else {
                $db->prepare('UPDATE comments SET is_approved = ? WHERE id = ?')->execute([$approve, $commentId]);
                $message = $approve ? '✅ Commentaire approuvé.' : '❌ Commentaire refusé.';
            }
        }
    }

    // Suppression d'un dessin
    if (isset($_POST['action']) && $_POST['action'] === 'delete_drawing') {
        $id = (int)($_POST['drawing_id'] ?? 0);
        if ($id) {
            $stmt = $db->prepare('SELECT filename FROM drawings WHERE id = ?');
            $stmt->execute([$id]);
            $drawing = $stmt->fetch();
            if ($drawing) {
                $filePath = UPLOAD_DIR . $drawing['filename'];
                if (file_exists($filePath)) unlink($filePath);
                $db->prepare('DELETE FROM drawings WHERE id = ?')->execute([$id]);
                $message = '🗑️ Dessin supprimé.';
            }
        }
    }

    // Données pour affichage
    $drawings = $db->query('SELECT * FROM drawings ORDER BY created_at DESC LIMIT 20')->fetchAll();
    $pending  = $db->query('
        SELECT c.*, d.title as drawing_title
        FROM comments c
        JOIN drawings d ON d.id = c.drawing_id
        WHERE c.is_approved = 0
        ORDER BY c.created_at DESC
    ')->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — DBZ Portfolio</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --gold: #f5c518;
            --orange: #ff8c00;
            --dark: #0d0d0d;
            --surface: #1a1a1a;
            --border: #333;
            --text: #e0e0e0;
        }
        body { background: var(--dark); color: var(--text); font-family: 'Segoe UI', sans-serif; min-height: 100vh; }
        .header { background: linear-gradient(135deg, #1a0a00, #2a1500); border-bottom: 2px solid var(--gold); padding: 16px 24px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { color: var(--gold); font-size: 1.4rem; }
        .container { max-width: 1200px; margin: 24px auto; padding: 0 16px; }
        .card { background: var(--surface); border: 1px solid var(--border); border-radius: 8px; padding: 24px; margin-bottom: 24px; }
        .card h2 { color: var(--gold); margin-bottom: 16px; font-size: 1.1rem; border-bottom: 1px solid var(--border); padding-bottom: 8px; }
        label { display: block; margin-bottom: 4px; font-size: 0.85rem; color: #aaa; }
        input[type=text], input[type=password], textarea, select {
            width: 100%; background: #111; border: 1px solid var(--border); color: var(--text);
            padding: 10px; border-radius: 4px; margin-bottom: 12px; font-size: 0.9rem;
        }
        input[type=file] { color: var(--text); margin-bottom: 12px; }
        button, .btn {
            background: linear-gradient(135deg, var(--orange), var(--gold));
            color: #000; border: none; padding: 10px 20px; border-radius: 4px;
            cursor: pointer; font-weight: bold; font-size: 0.9rem;
        }
        .btn-danger { background: linear-gradient(135deg, #c0392b, #e74c3c); color: #fff; }
        .btn-sm { padding: 5px 12px; font-size: 0.8rem; }
        .alert { padding: 12px 16px; border-radius: 4px; margin-bottom: 16px; }
        .alert-success { background: #1a3d1a; border: 1px solid #2ecc71; color: #2ecc71; }
        .alert-error { background: #3d1a1a; border: 1px solid #e74c3c; color: #e74c3c; }
        table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
        th { background: #111; padding: 10px; text-align: left; color: var(--gold); }
        td { padding: 10px; border-bottom: 1px solid var(--border); vertical-align: top; }
        img.thumb { width: 60px; height: 60px; object-fit: cover; border-radius: 4px; }
        .login-box { max-width: 400px; margin: 80px auto; }
        .login-box h1 { text-align: center; color: var(--gold); margin-bottom: 24px; font-size: 2rem; }
        .checkbox-row { display: flex; align-items: center; gap: 8px; margin-bottom: 12px; }
        a { color: var(--gold); text-decoration: none; }
    </style>
</head>
<body>

<?php if (!$isLoggedIn): ?>
<div class="container">
    <div class="login-box card">
        <h1>⚡ Admin DBZ</h1>
        <?php if ($error): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
        <form method="POST">
            <input type="hidden" name="action" value="login">
            <label>Nom d'utilisateur</label>
            <input type="text" name="username" required autofocus>
            <label>Mot de passe</label>
            <input type="password" name="password" required>
            <button type="submit" style="width:100%">Entrer dans la salle d'entraînement</button>
        </form>
    </div>
</div>

<?php else: ?>
<div class="header">
    <h1>⚡ DBZ Portfolio — Administration</h1>
    <a href="?logout=1">Déconnexion</a>
</div>
<div class="container">
    <?php if ($message): ?><div class="alert alert-success"><?= htmlspecialchars($message) ?></div><?php endif; ?>
    <?php if ($error): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

    <!-- Upload -->
    <div class="card">
        <h2>➕ Ajouter un dessin</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="upload">
            <label>Titre *</label>
            <input type="text" name="title" required maxlength="200">
            <label>Description</label>
            <textarea name="description" rows="3" maxlength="2000"></textarea>
            <label>Catégorie</label>
            <select name="category">
                <option value="fanart">Fan Art</option>
                <option value="original">Original</option>
                <option value="sketch">Croquis</option>
                <option value="colored">Colorié</option>
            </select>
            <label>Tags (séparés par des virgules)</label>
            <input type="text" name="tags" placeholder="Goku, Super Saiyan, combat...">
            <div class="checkbox-row">
                <input type="checkbox" name="is_featured" id="featured">
                <label for="featured" style="margin:0">Mettre en avant (héros)</label>
            </div>
            <label>Image (JPG/PNG/WebP/GIF, max 8Mo) *</label>
            <input type="file" name="image" accept="image/*" required>
            <button type="submit">⬆️ Uploader le dessin</button>
        </form>
    </div>

    <!-- Commentaires en attente -->
    <?php if ($pending): ?>
    <div class="card">
        <h2>⏳ Commentaires en attente (<?= count($pending) ?>)</h2>
        <table>
            <tr><th>Dessin</th><th>Auteur</th><th>Contenu</th><th>Date</th><th>Actions</th></tr>
            <?php foreach ($pending as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['drawing_title']) ?></td>
                <td><?= htmlspecialchars($c['author_name']) ?></td>
                <td><?= htmlspecialchars(mb_substr($c['content'], 0, 120)) ?>...</td>
                <td><?= $c['created_at'] ?></td>
                <td>
                    <form method="POST" style="display:inline">
                        <input type="hidden" name="action" value="moderate_comment">
                        <input type="hidden" name="comment_id" value="<?= $c['id'] ?>">
                        <input type="hidden" name="approve" value="1">
                        <button class="btn btn-sm">✅</button>
                    </form>
                    <form method="POST" style="display:inline">
                        <input type="hidden" name="action" value="moderate_comment">
                        <input type="hidden" name="comment_id" value="<?= $c['id'] ?>">
                        <input type="hidden" name="approve" value="-1">
                        <button class="btn btn-danger btn-sm">🗑️</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php endif; ?>

    <!-- Liste dessins -->
    <div class="card">
        <h2>🖼️ Dessins publiés (<?= count($drawings) ?>)</h2>
        <table>
            <tr><th>Image</th><th>Titre</th><th>Catégorie</th><th>Note</th><th>Date</th><th>Action</th></tr>
            <?php foreach ($drawings as $d): ?>
            <tr>
                <td><img class="thumb" src="../uploads/drawings/<?= htmlspecialchars($d['filename']) ?>" alt=""></td>
                <td><?= htmlspecialchars($d['title']) ?><?= $d['is_featured'] ? ' ⭐' : '' ?></td>
                <td><?= htmlspecialchars($d['category']) ?></td>
                <td>⚡ <?= number_format($d['avg_rating'], 1) ?>/7 (<?= $d['vote_count'] ?> votes)</td>
                <td><?= substr($d['created_at'], 0, 10) ?></td>
                <td>
                    <form method="POST" onsubmit="return confirm('Supprimer ce dessin ?')">
                        <input type="hidden" name="action" value="delete_drawing">
                        <input type="hidden" name="drawing_id" value="<?= $d['id'] ?>">
                        <button class="btn btn-danger btn-sm">🗑️</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<?php endif; ?>
</body>
</html>
