-- ============================================
-- SCHEMA SQLite - DBZ Portfolio Blog
-- ============================================

-- Table des dessins
CREATE TABLE IF NOT EXISTS drawings (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    title       TEXT NOT NULL,
    description TEXT,
    filename    TEXT NOT NULL,
    category    TEXT DEFAULT 'fanart',
    tags        TEXT,
    avg_rating  REAL DEFAULT 0,
    vote_count  INTEGER DEFAULT 0,
    is_featured INTEGER DEFAULT 0,
    created_at  TEXT DEFAULT (datetime('now')),
    updated_at  TEXT DEFAULT (datetime('now'))
);

-- Table des votes (Dragon Balls, 1-7)
CREATE TABLE IF NOT EXISTS votes (
    id         INTEGER PRIMARY KEY AUTOINCREMENT,
    drawing_id INTEGER NOT NULL,
    ip_hash    TEXT NOT NULL,
    rating     INTEGER NOT NULL CHECK(rating BETWEEN 1 AND 7),
    created_at TEXT DEFAULT (datetime('now')),
    FOREIGN KEY (drawing_id) REFERENCES drawings(id) ON DELETE CASCADE,
    UNIQUE(drawing_id, ip_hash)
);

-- Table des commentaires
CREATE TABLE IF NOT EXISTS comments (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    drawing_id  INTEGER NOT NULL,
    author_name TEXT NOT NULL,
    content     TEXT NOT NULL,
    ip_hash     TEXT,
    is_approved INTEGER DEFAULT 0,
    created_at  TEXT DEFAULT (datetime('now')),
    FOREIGN KEY (drawing_id) REFERENCES drawings(id) ON DELETE CASCADE
);

-- Table admin (authentification)
CREATE TABLE IF NOT EXISTS admin_users (
    id            INTEGER PRIMARY KEY AUTOINCREMENT,
    username      TEXT UNIQUE NOT NULL,
    password_hash TEXT NOT NULL,
    last_login    TEXT,
    created_at    TEXT DEFAULT (datetime('now'))
);

-- Index de performances
CREATE INDEX IF NOT EXISTS idx_drawings_featured ON drawings(is_featured);
CREATE INDEX IF NOT EXISTS idx_comments_drawing  ON comments(drawing_id);
CREATE INDEX IF NOT EXISTS idx_comments_approved ON comments(is_approved);
CREATE INDEX IF NOT EXISTS idx_votes_drawing     ON votes(drawing_id);

-- Trigger : recalcul avg_rating après chaque vote
CREATE TRIGGER IF NOT EXISTS update_avg_rating
AFTER INSERT ON votes
BEGIN
    UPDATE drawings
    SET avg_rating = (SELECT AVG(rating) FROM votes WHERE drawing_id = NEW.drawing_id),
        vote_count = (SELECT COUNT(*) FROM votes WHERE drawing_id = NEW.drawing_id)
    WHERE id = NEW.drawing_id;
END;
