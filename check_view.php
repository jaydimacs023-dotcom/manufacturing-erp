<?php
$lines = file('resources/views/admin/inventory/index.blade.php');
foreach ($lines as $i => $line) {
    echo ($i + 1) . ': ' . $line;
}

