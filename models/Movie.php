<?php

class Movie
{

    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function all() {
        return $this->db->query("SELECT * FROM movies ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id) {
        $stmt = $this->db->prepare("SELECT * FROM movies WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(string $title, string $genre, int $year, float $rating) {
        $stmt = $this->db->prepare("INSERT INTO movies (title, genre, release_year, rating) VALUES (?, ?, ?, ?)");
        $stmt->execute([$title, $genre, $year, $rating]);
    }

    public function update(int $id, string $title, string $genre, int $year, float $rating) {
        $stmt = $this->db->prepare("UPDATE movies SET title=?, genre=?, release_year=?, rating=? WHERE id=?");
        $stmt->execute([$title, $genre, $year, $rating, $id]);
    }

    public function delete(int $id) {
        $stmt = $this->db->prepare("DELETE FROM movies WHERE id=?");
        $stmt->execute([$id]);
    }

    public function getAll(array $filters)
    {

        $where   = [];
        $params  = [];

        if ($filters['q']) {
            $where[]  = "m.title LIKE ?";
            $params[] = '%' . $filters['q'] . '%';
        }

        if ($filters['genre']) {
            $where[]  = "m.genre = ?";
            $params[] = $filters['genre'];
        }

        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

        $orderBy = match ($filters['sort']) {
            'rating_desc' => 'm.rating DESC',
            'year_desc'   => 'm.release_year DESC',
            default       => 'm.title ASC'
        };

        $sql = "
            SELECT 
                m.*,
                IF(f.user_id IS NULL, 0, 1) AS is_favorited
            FROM movies m
            LEFT JOIN favorites f
                ON f.movie_id = m.id AND f.user_id = ?
            $whereSql
            ORDER BY $orderBy
            LIMIT {$filters['limit']} OFFSET {$filters['offset']}
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(array_merge([$filters['userId']], $params));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll(string $q = '', string $genre = '')
    {

        $where  = [];
        $params = [];

        if ($q) {
            $where[]  = "title LIKE ?";
            $params[] = "%$q%";
        }

        if ($genre) {
            $where[]  = "genre = ?";
            $params[] = $genre;
        }

        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

        $stmt = $this->db->prepare("SELECT COUNT(*) FROM movies $whereSql");
        $stmt->execute($params);

        return $stmt->fetchColumn();
    }

    public function getGenres()
    {
        return $this->db
            ->query("SELECT DISTINCT genre FROM movies ORDER BY genre")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findWithFavoriteStatus(int $movieId, ?int $userId)
    {

        $stmt = $this->db->prepare("
            SELECT 
                m.*,
                EXISTS (
                    SELECT 1
                    FROM favorites f
                    WHERE f.movie_id = m.id
                      AND f.user_id = ?
                ) AS is_favorited
            FROM movies m
            WHERE m.id = ?
        ");

        $stmt->execute([
            $userId ?? 0,
            $movieId
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
