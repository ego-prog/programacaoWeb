<?php
session_destroy();
session_start();
?>

<?php

$arq0 = "senhas.php";
$arq1 = "index.php";
$arq2 = "produtos.php";
$arq3 = "cadastraProduto.php";
$arq4 = "senhas_admin.php";
$arq5 = "registraEmprDevol.php";


require_once("$arq4");

include 'variaveis.php';

$usuarioDigitado = $_POST['usuario'];
$senhaDigitada = $_POST['senha'];
$servidor = 'localhost';
$bd = 'fatec';

if ($usuarioDigitado == "" or $senhaDigitada == "") {
    $_SESSION['error'] = 1;
    header("Location: $arq1");
    exit;
} else {
    $conexão = new mysqli($servidor, $usuario, $senha, $bd);
    if ($conexão->connect_error) die($conexão->connect_error);
    $consulta = "SELECT * FROM usuarios WHERE login='$usuarioDigitado'  AND senha = '$senhaDigitada' LIMIT 1";
    $resultado = $conexão->query($consulta);
    if (!$resultado)
        die("Erro de acesso à base de dados: " . $conexão->error);
    if (empty($resultado->data_seek(0))){
        $_SESSION['error'] = 2;
        header("Location: $arq1");
    }
    else {
        $_SESSION['user'] = $usuarioDigitado;
        $nivel = $resultado->fetch_assoc()['nivel'];
        $_SESSION['nivel'] = $nivel;
        if ($nivel == $administrador)
            header("Location: $administracao");
        else if ($nivel == $caixa) header("Location: $arq2");
        //{$arq = $arq2;	mostraLivros($tab, $arq2, $conexão);}
        else if ($nivel == $gerente) header("Location: $arq3");
        //{$arq = $arq2;	mostraLivros($tab, $arq2, $conexão);}
        else header("Location: $arq1");
    }
}
$resultado->close();
$conexão->close();
