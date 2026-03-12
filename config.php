<?php
$env_vars = [
    'DB_HOST' => $_SERVER['REDIRECT_DB_HOST'] ?? $_SERVER['DB_HOST'] ?? null,
    'DB_USER' => $_SERVER['REDIRECT_DB_USER'] ?? $_SERVER['DB_USER'] ?? null,
    'DB_PASSWORD' => $_SERVER['REDIRECT_DB_PASSWORD'] ?? $_SERVER['DB_PASSWORD'] ?? null,
    'DB_NAME' => $_SERVER['REDIRECT_DB_NAME'] ?? $_SERVER['DB_NAME'] ?? null
];

if (in_array(null, $env_vars, true))
    die('Missing required env variables');

define('DB_HOST', $env_vars['DB_HOST']);
define('DB_USER', $env_vars['DB_USER']);
define('DB_PASSWORD', $env_vars['DB_PASSWORD']);
define('DB_NAME', $env_vars['DB_NAME']);

$connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($connection->connect_error)
    die('Connection failed: ' . $connection->connect_error);
