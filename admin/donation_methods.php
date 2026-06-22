<?php
require_once __DIR__.'/includes/crud.php';

$cfg = [
    'table' => 'donation_methods',
    'title' => 'Donation Methods',
    'singular' => 'Method',
    'fields' => [
        ['name' => 'method_name', 'label' => 'Method Name', 'type' => 'text', 'required' => true, 'list' => true],
        ['name' => 'account_details', 'label' => 'Account Details', 'type' => 'textarea', 'list' => true],
        ['name' => 'instructions', 'label' => 'Instructions', 'type' => 'textarea'],
        ['name' => 'is_active', 'label' => 'Active', 'type' => 'checkbox', 'list' => true],
    ]
];

crud_handle($cfg);
$pageTitle = 'Donation Methods';
include __DIR__.'/includes/header.php';
crud_render($cfg);
include __DIR__.'/includes/footer.php';
?>
