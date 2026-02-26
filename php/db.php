<?php
// ============================================
// php/db.php — Connexion PDO + SQLite
// ============================================

define('DB_PATH', __DIR__ . '/../data/portfolio.db');
define('SCHEMA_PATH', __DIR__ . '/../data/schema.sql');
define('UPLOAD_DIR', __DIR__ . '/../uploads/drawings/');
define('MAX_FILE_SIZE', 8 * 1024 * 1024); // 8 Mo
define('ALLOWED_TYPES', ['image/jpeg', 'image/png', 'image/webp', 'image/gif']);

function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        try {
            $pdo = new PDO('sqlite:' . DB_PATH, null, null, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
            $pdo->exec('PRAGMA foreign_keys = ON;');
            $pdo->exec('PRAGMA journal_mode = WAL;');
            initDB($pdo);
        } catch (PDOException $e) {
            http_response_code(500);
            die(json_encode(['error' => 'Database connection failed']));
        }
    }
    return $pdo;
}

function initDB(PDO $pdo): void {
    // Crée les tables si elles n'existent pas encore
    $schema = file_get_contents(SCHEMA_PATH);
    $pdo->exec($schema);

    // Crée le compte admin par défaut si aucun n'existe
    $count = $pdo->query('SELECT COUNT(*) FROM admin_users')->fetchColumn();
    if ($count == 0) {
        $stmt = $pdo->prepare('INSERT INTO admin_users (username, password_hash) VALUES (?, ?)');
        // Mot de passe par défaut : "dbz_admin_2024" — À CHANGER IMMÉDIATEMENT
        $stmt->execute(['admin', password_hash('dbz_admin_2024', PASSWORD_BCRYPT)]);
    }
}

function jsonResponse(array $data, int $code = 200): void {
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

function hashIp(string $ip): string {
    return hash('sha256', $ip . 'dbz_salt_unique_2024');
}

function sanitize(string $input, int $maxLen = 500): string {
    return mb_substr(trim(strip_tags($input)), 0, $maxLen);
}
