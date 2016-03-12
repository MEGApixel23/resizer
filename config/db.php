<?php

$url = parse_url(getenv('CLEARDB_DATABASE_URL'));

$scheme = isset($url['scheme']) ? $url['scheme'] : 'mysql';
$server = isset($url['host']) ? $url['host'] : 'localhost';
$username = isset($url['user']) ? $url['user'] : 'root';
$password = isset($url['pass']) ? $url['pass'] : '';
$db = isset($url['path']) && substr($url['path'], 1) ? substr($url['path'], 1) : 'resizer';

return [
    'class' => 'yii\db\Connection',
    'dsn' => "{$scheme}:host={$server};dbname={$db}",
    'username' => $username,
    'password' => $password,
    'charset' => 'utf8',
];