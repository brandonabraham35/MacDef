<?php
require_once __DIR__.'/includes/crud.php';

$cfg = [
    'table' => 'downloads',
    'title' => 'Downloads Centre',
    'singular' => 'Downloadable Item',
    'fields' => [
        ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true, 'list' => true],
        ['name' => 'description', 'label' => 'Description', 'type' => 'textarea'],
        ['name' => 'file_path', 'label' => 'File', 'type' => 'file', 'list' => true],
        ['name' => 'category', 'label' => 'Category', 'type' => 'text', 'list' => true],
        ['name' => 'download_count', 'label' => 'Download Count', 'type' => 'number', 'list' => true],
        ['name' => 'is_active', 'label' => 'Active', 'type' => 'checkbox', 'list' => true],
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

$pageTitle = 'Downloads Centre';
include __DIR__.'/includes/header.php';
crud_render($cfg);
include __DIR__.'/includes/footer.php';
?>
