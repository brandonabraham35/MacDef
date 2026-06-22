<?php
require_once __DIR__.'/includes/crud.php';

$cfg = [
    'table' => 'resources',
    'title' => 'Resource Centre',
    'singular' => 'Resource',
    'fields' => [
        ['name' => 'cover_image', 'label' => 'Cover Image', 'type' => 'image', 'list' => true],
        ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true, 'list' => true],
        ['name' => 'description', 'label' => 'Description', 'type' => 'textarea'],
        ['name' => 'resource_type', 'label' => 'Type', 'type' => 'text', 'list' => true], // Could use a select if CRUD helper supported it
        ['name' => 'file_path', 'label' => 'File', 'type' => 'file', 'list' => true],
    ]
];

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

$pageTitle = 'Resource Centre';
include __DIR__.'/includes/header.php';
crud_render($cfg);
include __DIR__.'/includes/footer.php';
?>
