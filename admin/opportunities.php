<?php
require_once __DIR__.'/includes/crud.php';

$cfg = [
    'table' => 'opportunities',
    'title' => 'Opportunities Management',
    'singular' => 'Opportunity',
    'order' => 'deadline ASC, created_at DESC',
    'fields' => [
        ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true, 'list' => true],
        ['name' => 'type', 'label' => 'Type', 'type' => 'text', 'list' => true],
        ['name' => 'deadline', 'label' => 'Deadline', 'type' => 'date', 'list' => true],
        ['name' => 'description', 'label' => 'Description', 'type' => 'textarea'],
        ['name' => 'attachment', 'label' => 'Attachment (PDF/DOC)', 'type' => 'file', 'list' => true],
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

$pageTitle = 'Opportunities';
include __DIR__.'/includes/header.php';
crud_render($cfg);
include __DIR__.'/includes/footer.php';
?>
