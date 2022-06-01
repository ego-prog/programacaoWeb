<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<?php
header('Content-Type: text/html; charset=utf-8');
require_once 'senhas_admin.php';
require_once 'funcoes.php';
$conexão = new mysqli($servidor, $usuario, $senha, $bd);
$tab = "usuarios";
$arq = "cadastraUsuario.php";
$sair = "sair.php";
if ($conexão->connect_error) die($conexão->connect_error);
require 'variaveis.php';
require 'head.php';
?>

<?php
// ************* Apagar dados da tabela *************
if (isset($_POST['apagar']) && isset($_POST['usuario'])) {
    $usuario = get_post($conexão, 'usuario');
    $query = "DELETE FROM $tab WHERE `login`='$usuario'";
    $resultado = $conexão->query($query);

    if (!$resultado) echo "Erro ao remover dados: $query<br>" .
        $conexão->error . "<br><br>";
    else
    echo <<<_alerta2
        <script>alert("Usuário Excluído")</script>
    _alerta2;
}
?>

<?php
// ************* Inserir dados da tabela *************
if (
    isset($_POST['usuario'])
    &&
    isset($_POST['senha'])
) {
    $usuario = get_post($conexão, 'usuario');
    $senha     = get_post($conexão, 'senha');
    $privilegio = get_post($conexão, 'privilegio');
    
    $query    = "INSERT INTO $tab VALUES" . "('$usuario', '$senha', '$privilegio')";

    $resultado     = $conexão->query($query);
    if (!$resultado) echo "Erro ao inserir dados: $query<br>" .
        $conexão->error . "<br><br>";
}
?>


<?php
echo <<<_SAIR
<div class="row">
    <div class="col-md-12">
<br>
<br>
<form name = "sair" action="$sair" method="post">
<button type="submit" name="button" class="btn btn-danger">Sair</button></form>
    </div>
</div>
_SAIR;
?>
<?php
echo <<< _HTMLCONTENT
<div class="row">
    <div class="col-md-12">
        <fieldset class="scheduler-border">
        <legend class="scheduler-border">Registro de Usuários:</legend>
        <pre>
<form action="$arq" method="post">
        Usuário:    <input type="text" name="usuario">
        
        Senha:      <input type="text" name="senha">

        Selecione:  <select name="privilegio" id="privilegio">
                <option value=1>Admistrador</option>
                <option value=2>Caixa</option>
                <option value=3>Gerente</option>
            </select>
        
        <input type = "submit" value="Registrar">
</form>
        </pre>
    </fieldset>
    </div>
</div>
_HTMLCONTENT;
?>



<?php
//  ************* Mostrar os Usuários existentes na tabela *************
$query = "SELECT * FROM $tab";

$resultado = $conexão->query($query);

if (!$resultado) die("Erro de acesso à base de dados: " . $conexão->error);

$linhas = $resultado->num_rows;
$falta=3;
echo '<div class="row">';
for ($j = 0; $j < $linhas; ++$j) {
    $resultado->data_seek($j);
    $linha = $resultado->fetch_array(MYSQLI_NUM);
    $falta--;
    if($falta<0)
        $falta = 2;
    if ($linha[2] == $administrador)
        $nivel = "Administrador";
    elseif ($linha[2] == $caixa)
        $nivel = "Caixa";
    elseif ($linha[2] == $gerente)
        $nivel = "Gerente";
    else
        $nivel = "Erro de Nível";
    echo <<<_END
<div class="col-md-4">
<pre>
    <fieldset class="scheduler-border">
Usuario:    $linha[0]
Nivel:      $nivel
	<form action="$arq" method="post"><input type="hidden" name="apagar" value="yes"><input type="hidden" name="usuario" value="$linha[0]"><button type="submit" name="button" class="btn btn-primary">Apagar</button>
	</form></fieldset></pre>
</div>
_END;
if((($j+1)%3)==0)
{
    echo '</div> <div class="row">';
}

}

for ($i = 0 ; $i < $falta ; ++$i)
		{
            echo '<div class="col-md-4"> </div>';
        }
        echo '</div> <div class="row">';
?>



<?php
	echo '</div>';
	include 'footer.php';
?>