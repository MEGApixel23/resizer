<?php

$url = parse_url(getenv('CLEARDB_DATABASE_URL'));

$server = isset($url['host']) ? $url['host'] : 'localhost';
$username = isset($url['user']) ? $url['user'] : 'root';
$password = isset($url['pass']) ? $url['pass'] : '';
$db = isset($url['path']) && substr($url['path'], 1) ? substr($url['path'], 1) : 'resizer';


echo "<pre>"; print_r($url); echo "</pre>"; die();
return [
    'class' => 'yii\db\Connection',
    'dsn' => "mysqli:host={$server};dbname={$db}",
    'username' => $username,
    'password' => $password,
    'charset' => 'utf8',
];