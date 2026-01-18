<?php
require './config/database.php';
require './core/helpers.php';
require './core/csrf.php';

$userId = $_SESSION['user_id'] ?? null;

/* ---------- Params ---------- */
$q      = $_GET['q'] ?? '';
$genre  = $_GET['genre'] ?? '';
$sort   = $_GET['sort'] ?? '';
$page   = max(1, (int) ($_GET['page'] ?? 1));
$limit  = 6;
$offset = ($page - 1) * $limit;

/* ---------- Sort ---------- */
$orderBy = "m.title ASC";
if ($sort === 'rating_desc') {
    $orderBy = "m.rating DESC";
} elseif ($sort === 'year_desc') {
    $orderBy = "m.release_year DESC";
} elseif ($sort === 'title_asc') {
    $orderBy = "m.title ASC";
}

/* ---------- Filters ---------- */
$where = [];
$params = [];

if ($q !== '') {
    $where[] = "m.title LIKE ?";
    $params[] = "%$q%";
}

if ($genre !== '') {
    $where[] = "m.genre = ?";
    $params[] = $genre;
}

$whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

/* ---------- Movies + favorites ---------- */
$sql = "
SELECT 
    m.*,
    IF(f.user_id IS NULL, 0, 1) AS is_favorited
FROM movies m
LEFT JOIN favorites f 
    ON f.movie_id = m.id AND f.user_id = ?
$whereSql
ORDER BY $orderBy
LIMIT $limit OFFSET $offset
";

$stmt = $pdo->prepare($sql);
$stmt->execute(array_merge([$userId], $params));
$movies = $stmt->fetchAll();

/* ---------- Total count ---------- */
$countSql = "SELECT COUNT(*) FROM movies m $whereSql";
$stmt = $pdo->prepare($countSql);
$stmt->execute($params);
$total = $stmt->fetchColumn();

$totalPages = ceil($total / $limit);

/* ---------- Genres list ---------- */
$genres = $pdo->query("SELECT DISTINCT genre FROM movies ORDER BY genre")->fetchAll();
?>

<?php include './partials/header.php'; ?>

<div class="container mt-4">

    <!-- 🔍 Filter bar -->
    <form class="row g-2 mb-4">
        <div class="col-md-4">
            <input
                type="text"
                name="q"
                class="form-control"
                placeholder="Search by title"
                value="<?= e($q) ?>">
        </div>

        <div class="col-md-3">
            <select name="genre" class="form-select">
                <option value="">All genres</option>
                <?php foreach ($genres as $g): ?>
                    <option value="<?= e($g['genre']) ?>" <?= $genre === $g['genre'] ? 'selected' : '' ?>>
                        <?= e($g['genre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3">
            <select name="sort" class="form-select">
                <option value="">Sort by</option>
                <option value="rating_desc" <?= $sort === 'rating_desc' ? 'selected' : '' ?>>Rating ↓</option>
                <option value="year_desc" <?= $sort === 'year_desc' ? 'selected' : '' ?>>Year ↓</option>
                <option value="title_asc" <?= $sort === 'title_asc' ? 'selected' : '' ?>>Title A–Z</option>
            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-dark w-100">Filter</button>
        </div>
    </form>

    <!-- 🎬 Movies grid -->
    <div class="row">
        <?php
        foreach ($movies as $movie):
            include './partials/movie_card.php';
        endforeach; ?>
    </div>

    <!-- 📄 Pagination -->
    <?php if ($totalPages > 1): ?>
        <nav>
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                        <a class="page-link"
                            href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>

</div>

<?php include './partials/footer.php'; ?>