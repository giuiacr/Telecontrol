<?php
session_start();

$login_nome = $_SESSION['nome'];
$login_fabrica = $_SESSION['fabrica'];
$login_usuario_id = $_SESSION['usuario_id'];


if (!isset($_SESSION['logado'])) {
    header("location:login.php");
    exit;
}

