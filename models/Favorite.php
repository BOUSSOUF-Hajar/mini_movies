<?php

class Favorite {

    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function movieExists(int $movieId): bool {
        $stmt = $this->db->prepare("SELECT 1 FROM movies WHERE id = ?");
        $stmt->execute([$movieId]);
        return (bool) $stmt->fetch();
    }

    public function isFavorited(int $userId, int $movieId): bool {
        $stmt = $this->db->prepare("SELECT 1 FROM favorites WHERE user_id = ? AND movie_id = ?");
        $stmt->execute([$userId, $movieId]);
        return (bool) $stmt->fetch();
    }

    public function add(int $userId, int $movieId) {
        $stmt = $this->db->prepare("INSERT IGNORE INTO favorites (user_id, movie_id) VALUES (?, ?)");
        $stmt->execute([$userId, $movieId]);
    }

    public function remove(int $userId, int $movieId) {
        $stmt = $this->db->prepare("DELETE FROM favorites WHERE user_id = ? AND movie_id = ?");
        $stmt->execute([$userId, $movieId]);
    }
}
