<?php
// ============================================
// php/api/drawings.php — API publique dessins
// ============================================
require_once __DIR__ . '/../db.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

$db     = getDB();
$action = $_GET['action'] ?? 'list';

switch ($action) {

    case 'list':
        $category = sanitize($_GET['category'] ?? '');
        $search   = sanitize($_GET['q'] ?? '', 200);
        $tag      = sanitize($_GET['tag'] ?? '', 100);
        $sort     = sanitize($_GET['sort'] ?? 'recent', 20);
        $limit    = min((int)($_GET['limit'] ?? 12), 50);
        $offset   = max((int)($_GET['offset'] ?? 0), 0);

        // Ordre SQL
        $orderMap = [
            'recent'  => 'is_featured DESC, created_at DESC',
            'oldest'  => 'created_at ASC',
            'top'     => 'avg_rating DESC, vote_count DESC',
            'votes'   => 'vote_count DESC',
            'random'  => 'RANDOM()',
        ];
        $orderSQL = $orderMap[$sort] ?? $orderMap['recent'];

        // Clauses WHERE dynamiques
        $conditions = [];
        $params     = [];

        if ($category) {
            $conditions[] = 'category = ?';
            $params[]     = $category;
        }
        if ($search !== '') {
            $conditions[] = '(title LIKE ? OR description LIKE ? OR tags LIKE ?)';
            $like = '%' . $search . '%';
            $params[] = $like;
            $params[] = $like;
            $params[] = $like;
        }
        if ($tag !== '') {
            // tags stockés comme "Goku,SuperSaiyan,combat" — recherche souple
            $conditions[] = 'tags LIKE ?';
            $params[]     = '%' . $tag . '%';
        }

        $where = $conditions ? ('WHERE ' . implode(' AND ', $conditions)) : '';

        $stmt = $db->prepare("
            SELECT id, title, description, filename, category, tags,
                   avg_rating, vote_count, is_featured, created_at
            FROM drawings $where
            ORDER BY $orderSQL
            LIMIT ? OFFSET ?
        ");
        $stmtParams = array_merge($params, [$limit, $offset]);
        $stmt->execute($stmtParams);
        $drawings = $stmt->fetchAll();

        // Compte total (sans pagination)
        $totalStmt = $db->prepare("SELECT COUNT(*) FROM drawings $where");
        $totalStmt->execute($params);

        jsonResponse([
            'success'  => true,
            'drawings' => $drawings,
            'total'    => (int)$totalStmt->fetchColumn(),
            'limit'    => $limit,
            'offset'   => $offset,
            'has_more' => ($offset + $limit) < (int)$totalStmt->fetchColumn(),
        ]);
        break;

    // Retourne tous les tags uniques utilisés dans la base
    case 'tags_list':
        $stmt = $db->query("SELECT tags FROM drawings WHERE tags IS NOT NULL AND tags != ''");
        $rows = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $all  = [];
        foreach ($rows as $row) {
            foreach (explode(',', $row) as $t) {
                $t = trim($t);
                if ($t !== '') $all[$t] = ($all[$t] ?? 0) + 1;
            }
        }
        arsort($all);
        jsonResponse(['success' => true, 'tags' => $all]);
        break;

    case 'single':
        $id = (int)($_GET['id'] ?? 0);
        if (!$id) jsonResponse(['error' => 'ID requis'], 400);

        $stmt = $db->prepare('SELECT * FROM drawings WHERE id = ?');
        $stmt->execute([$id]);
        $drawing = $stmt->fetch();
        if (!$drawing) jsonResponse(['error' => 'Dessin introuvable'], 404);

        // Commentaires approuvés
        $cStmt = $db->prepare('
            SELECT id, author_name, content, created_at
            FROM comments
            WHERE drawing_id = ? AND is_approved = 1
            ORDER BY created_at DESC
            LIMIT 50
        ');
        $cStmt->execute([$id]);
        $drawing['comments'] = $cStmt->fetchAll();

        jsonResponse(['success' => true, 'drawing' => $drawing]);
        break;

    case 'vote':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') jsonResponse(['error' => 'POST requis'], 405);

        $input     = json_decode(file_get_contents('php://input'), true);
        $drawingId = (int)($input['drawing_id'] ?? 0);
        $rating    = (int)($input['rating'] ?? 0);
        $ipHash    = hashIp($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0');

        if (!$drawingId || $rating < 1 || $rating > 7) {
            jsonResponse(['error' => 'Paramètres invalides'], 400);
        }

        // Vérifie que le dessin existe
        $check = $db->prepare('SELECT id FROM drawings WHERE id = ?');
        $check->execute([$drawingId]);
        if (!$check->fetch()) jsonResponse(['error' => 'Dessin introuvable'], 404);

        try {
            $stmt = $db->prepare('
                INSERT INTO votes (drawing_id, ip_hash, rating) VALUES (?, ?, ?)
                ON CONFLICT(drawing_id, ip_hash) DO UPDATE SET rating = excluded.rating
            ');
            $stmt->execute([$drawingId, $ipHash, $rating]);

            // Récupère le nouveau score
            $score = $db->prepare('SELECT avg_rating, vote_count FROM drawings WHERE id = ?');
            $score->execute([$drawingId]);
            $data = $score->fetch();

            jsonResponse(['success' => true, 'avg_rating' => round($data['avg_rating'], 2), 'vote_count' => $data['vote_count']]);
        } catch (PDOException $e) {
            jsonResponse(['error' => 'Erreur lors du vote'], 500);
        }
        break;

    case 'comment':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') jsonResponse(['error' => 'POST requis'], 405);

        $input      = json_decode(file_get_contents('php://input'), true);
        $drawingId  = (int)($input['drawing_id'] ?? 0);
        $authorName = sanitize($input['author_name'] ?? '', 80);
        $content    = sanitize($input['content'] ?? '', 1000);
        $ipHash     = hashIp($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0');

        if (!$drawingId || strlen($authorName) < 2 || strlen($content) < 5) {
            jsonResponse(['error' => 'Champs invalides ou trop courts'], 400);
        }

        // Anti-spam basique : max 3 commentaires par IP par heure
        $spamCheck = $db->prepare('
            SELECT COUNT(*) FROM comments
            WHERE ip_hash = ? AND created_at > datetime("now", "-1 hour")
        ');
        $spamCheck->execute([$ipHash]);
        if ($spamCheck->fetchColumn() >= 3) {
            jsonResponse(['error' => 'Trop de commentaires. Réessayez plus tard.'], 429);
        }

        $stmt = $db->prepare('
            INSERT INTO comments (drawing_id, author_name, content, ip_hash)
            VALUES (?, ?, ?, ?)
        ');
        $stmt->execute([$drawingId, $authorName, $content, $ipHash]);

        jsonResponse(['success' => true, 'message' => 'Commentaire soumis pour modération. Merci, guerrier !']);
        break;

    default:
        jsonResponse(['error' => 'Action inconnue'], 400);
}
