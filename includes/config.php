<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'estacionamento');
\ = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if (\->connect_error) { die('Conexão falhou: ' . \->connect_error); }
?>
