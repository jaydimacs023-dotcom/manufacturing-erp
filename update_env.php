<?php
$env = file_get_contents('.env');

// DB_CONNECTION
$env = preg_replace('/^#?\s*DB_CONNECTION=.*$/m', 'DB_CONNECTION=mysql', $env);

// DB_HOST
$env = preg_replace('/^#?\s*DB_HOST=.*$/m', 'DB_HOST=127.0.0.1', $env);

// DB_PORT
$env = preg_replace('/^#?\s*DB_PORT=.*$/m', 'DB_PORT=3306', $env);

// DB_DATABASE
$env = preg_replace('/^#?\s*DB_DATABASE=.*$/m', 'DB_DATABASE=manufacturing_erp', $env);

// DB_USERNAME
$env = preg_replace('/^#?\s*DB_USERNAME=.*$/m', 'DB_USERNAME=root', $env);

// DB_PASSWORD
$env = preg_replace('/^#?\s*DB_PASSWORD=.*$/m', 'DB_PASSWORD=', $env);

file_put_contents('.env', $env);
echo "Environment updated successfully.\n";

