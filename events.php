<?php
$page_title = "Events";
require_once 'includes/header.php';
?>
<section class="page-header bg-navy text-white py-5"><div class="container py-4 text-center"><h1 class="display-4 fw-bold mb-3">Community Events</h1></div></section>
<main class="container py-5">
    <div class="row g-4">
        <?php
        if ($pdo) {
            $stmt = $pdo->query("SELECT * FROM events ORDER BY created_at DESC");
            while ($row = $stmt->fetch()) {
                echo "<div class='col-md-6'><div class='card p-4'><h4>{$row['title']}</h4><p>{$row['event_date']}</p><p>{$row['description']}</p></div></div>";
            }
        }
        ?>
    </div>
</main>
<?php require_once 'includes/footer.php'; ?>
