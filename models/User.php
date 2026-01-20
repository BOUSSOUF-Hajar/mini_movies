<?php

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function findByEmail(string $email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById(int $id) {
        $stmt = $this->db->prepare("SELECT id, name, email, created_at FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function updateName(int $id, string $name) {
        $stmt = $this->db->prepare("UPDATE users SET name = ? WHERE id = ?");
        $stmt->execute([$name, $id]);
    }

    public function getFavorites(int $userId) {
        $stmt = $this->db->prepare("
            SELECT 
                m.*,
                1 AS is_favorited
            FROM movies m
            JOIN favorites f ON f.movie_id = m.id
            WHERE f.user_id = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
