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
$tab = "produto";
$arq = "cadastraProduto.php";
$sair = "sair.php";
if ($conexão->connect_error) die($conexão->connect_error);
require 'variaveis.php';
require 'head.php';
?>

<?php
// ************* Apagar dados da tabela *************
if (isset($_POST['apagar']) && isset($_POST['produto'])) {
    $produto = get_post($conexão, 'produto');
    $query = "DELETE FROM $tab WHERE `id`='$produto'";
    $resultado = $conexão->query($query);

    if (!$resultado) echo "Erro ao remover dados: $query<br>" .
        $conexão->error . "<br><br>";
    else
    echo <<<_alerta2
        <script>alert("Produto Excluído")</script>
    _alerta2;
}
?>

<?php
// ************* Inserir dados da tabela *************
if (
    isset($_POST['produto'])
    &&
    isset($_POST['valor'])
) {
    $produto = get_post($conexão, 'produto');
    $valor     = get_post($conexão, 'valor');
    $categoria = get_post($conexão, 'categoria');
    
    $query    = "INSERT INTO $tab VALUES" . "(null, '$produto', '$valor', '$categoria')";

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
        <legend class="scheduler-border">Registro de Produtos:</legend>
        <pre>
<form action="$arq" method="post">
        Produto:    <input type="text" name="produto">
        
        Valor:      <input type="number" name="valor">

        Selecione:  <select name="categoria" id="categoria">
                <option value=1>Bebida Gelada</option>
                <option value=2>Bebida Quente</option>
                <option value=3>Salgado</option>
                <option value=3>Lanche</option>
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
    if ($linha[3] == $bebidaGelada)
        $categoria = "Bebida Gelada";
    elseif ($linha[3] == $bebidaQuente)
        $categoria = "Bebida Quente";
    elseif ($linha[3] == $salgado)
        $categoria = "Salgado";
    elseif ($linha[3] == $lanche)
        $categoria = "Lanche";
    else
        $categoria = "Categoria Inválida";
    echo <<<_END
<div class="col-md-4">
<pre>
    <fieldset class="scheduler-border">
    
produto:    $linha[1]
Valor:      $linha[2]
Categoria:  $categoria
	<form action="$arq" method="post"><input type="hidden" name="apagar" value="yes"><input type="hidden" name="produto" value="$linha[0]"><button type="submit" name="button" class="btn btn-primary">Apagar</button>
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