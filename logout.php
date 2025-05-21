<?php
include_once("conexao.php");

session_start();
session_destroy();
header("Location: login.php");
exit();
?>