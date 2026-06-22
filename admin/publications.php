<?php
require_once __DIR__.'/includes/crud.php';

$cfg = [
    'table' => 'publications',
    'title' => 'Publications Management',
    'singular' => 'Publication',
    'fields' => [
        ['name' => 'cover_image', 'label' => 'Cover Image', 'type' => 'image', 'list' => true],
        ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true, 'list' => true],
        ['name' => 'description', 'label' => 'Description', 'type' => 'textarea'],
        ['name' => 'file_path', 'label' => 'Publication File (PDF/DOC)', 'type' => 'file', 'list' => true],
        ['name' => 'category', 'label' => 'Category', 'type' => 'text', 'list' => true],
        ['name' => 'download_count', 'label' => 'Downloads', 'type' => 'number', 'list' => true],
        ['name' => 'is_active', 'label' => 'Active', 'type' => 'checkbox', 'list' => true],
    ]
];

// Special handle for 'file' type since crud.php helper might only handle 'image' specifically for uploads in its current state
// Let's check crud.php again to see if it handles 'file'
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($cfg['fields'] as $f) {
        if ($f['type'] === 'file') {
            $n = $f['name'];
            if (!empty($_FILES[$n]['name'])) {
                $up = handle_upload($_FILES[$n], 'document');
                if ($up['ok']) {
                    $_POST[$n] = $up['path'];
                }
            }
        }
    }
}

crud_handle($cfg);

$pageTitle = 'Publications';
include __DIR__.'/includes/header.php';
crud_render($cfg);
include __DIR__.'/includes/footer.php';
?>
