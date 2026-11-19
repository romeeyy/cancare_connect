<?php
$dbHost = getenv('DB_HOST') ?: 'localhost';
$dbName = getenv('DB_NAME') ?: 'your_cpanel_database_name';
$dbUser = getenv('DB_USER') ?: 'your_cpanel_database_user';
$dbPass = getenv('DB_PASSWORD') ?: 'your_database_password';
$dbPort = getenv('DB_PORT') ?: '3306';

$adminUsername = getenv('ADMIN_USERNAME') ?: 'your_admin_email';
$adminPassword = getenv('ADMIN_PASSWORD') ?: 'your_admin_password';

// Copy this file to config.php on the server and replace the placeholders.
