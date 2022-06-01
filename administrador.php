<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<?php
include "head.php";
include 'variaveis.php';
?>

<body>
        <div class="container-fluid">
            <?php
                echo <<<_SAIR
                <div class="row">
                    <div class="col-md-12">
                        <form name = "sair" action="$sair" method="post">
                            <button type="submit" name="button" class="btn btn-danger">Sair</button>
                        </form>
                    </div>
                </div>
                _SAIR;
            ?>
            <div class="row">
                <div class="col-md-12">
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">Menu</legend>
                        <div class="row">
                            <div class="col-md-4">
                                <?php echo "<a href='$cadastrausuario'>"?>
                                    <button class="btn btn-primary">Cadastra Usuário</button>
                                </a>
                            </div>
                            <div class="col-md-4">
                            <?php echo "<a href='$cadastraProduto'>"?>
                                    <button class="btn btn-warning">Cadastra Produto</button>
                                </a>
                            </div>
                            <div class="col-md-4">
                            </div>
                        </div>
                        
                    </fieldset>
                </div>
            </div>
            </div>
            <script src="./js/jquery.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/scripts.js"></script>
</body>

</html>