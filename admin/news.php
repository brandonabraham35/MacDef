<?php
require_once __DIR__.'/includes/crud.php';

$cfg = [
    'table' => 'news',
    'title' => 'News Management',
    'singular' => 'News Article',
    'order' => 'published_at DESC, created_at DESC',
    'fields' => [
        ['name' => 'featured_image', 'label' => 'Featured Image', 'type' => 'image', 'list' => true],
        ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true, 'list' => true],
        ['name' => 'slug', 'label' => 'Slug (Unique)', 'type' => 'text', 'required' => true],
        ['name' => 'excerpt', 'label' => 'Excerpt (Short Summary)', 'type' => 'textarea', 'list' => true],
        ['name' => 'content', 'label' => 'Content', 'type' => 'textarea'],
        ['name' => 'author', 'label' => 'Author', 'type' => 'text'],
        ['name' => 'published_at', 'label' => 'Publish Date', 'type' => 'date', 'list' => true],
        ['name' => 'is_active', 'label' => 'Published', 'type' => 'checkbox', 'list' => true],
    ]
];

// Custom slug generation if empty
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST['slug']) && !empty($_POST['title'])) {
    $_POST['slug'] = slugify($_POST['title']);
}

crud_handle($cfg);

$pageTitle = 'News Management';
include __DIR__.'/includes/header.php';
?>

<script>
// Auto-slugify
document.addEventListener('DOMContentLoaded', function() {
    const title = document.querySelector('input[name="title"]');
    const slug = document.querySelector('input[name="slug"]');
    if (title && slug) {
        title.addEventListener('blur', function() {
            if (!slug.value) {
                slug.value = title.value.toLowerCase()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/[\s_-]+/g, '-')
                    .replace(/^-+|-+$/g, '');
            }
        });
    }
});
</script>

<?php
crud_render($cfg);
include __DIR__.'/includes/footer.php';
?>
