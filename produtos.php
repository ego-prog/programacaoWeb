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
$arq = "produtos.php";
if ($conexão->connect_error) die($conexão->connect_error);
require 'variaveis.php';
require 'head.php';
?>

<?php
if (
    isset($_POST['produto'])
    &&
    isset($_POST['editar'])
) {
    $produto = get_post($conexão, 'produto');
    $quantidade = get_post($conexão, 'quantidade');
       
    $query    = "UPDATE $tab SET qtd=$quantidade WHERE id=$produto";

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
    <fieldset class="scheduler-border"><form action="$arq" method="post">    
Produto:    $linha[1]
Valor:      $linha[2]
Categoria:  $categoria
Quantidade: <input type="number" name="quantidade" value="$linha[4]">

	<input type="hidden" name="editar" value="yes"><input type="hidden" name="produto" value="$linha[0]"><button type="submit" name="button" class="btn btn-primary">Editar</button>
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