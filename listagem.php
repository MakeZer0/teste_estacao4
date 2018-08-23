<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Cadastro de Produtos</title>
  </head>
  <body>

    <?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
        $nome = (isset($_POST["nome"]) && $_POST["nome"] != null) ? $_POST["nome"] : "";
        $descricao = (isset($_POST["descricao"]) && $_POST["descricao"] != null) ? $_POST["descricao"] : "";
        $preco = (isset($_POST["preco"]) && $_POST["preco"] != null) ? $_POST["preco"] : NULL;
    } else if (!isset($id)) {
        $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
        $nome = NULL;
        $descricao = NULL;
        $preco = NULL;
    }
      try {
          $con = new PDO("mysql:host=localhost;dbname=db_produtos","root","");
          $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $con->exec("set names utf8");

      } catch (PDOException $ex) {
          echo 'Error: ' . $ex->getMessage();
      }
    ?>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">Produtos</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="index.php">Menu <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Opções
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="cadastro.php">Cadastrar</a>
              <a class="dropdown-item" href="#">Buscar</a>
              <a class="dropdown-item" href="#">Atualizar</a>
              <a class="dropdown-item" href="#">Deletar</a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">NOME</th>
          <th scope="col">DESCRIÇÃO</th>
          <th scope="col">PREÇO</th>
        </tr>
      </thead>
        <?php
        // Bloco que realiza o papel do Read - recupera os dados e apresenta na tela
        try {
            $stmt = $con->prepare("SELECT id,nome,descricao,preco FROM produtos ORDER BY nome ASC");
                if ($stmt->execute()) {
                    while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                        echo "<tbody>";
                        echo "<tr>";
                        echo "<th>".$rs->id."</th><th>".$rs->nome."</th><th>".$rs->descricao."</th><th>".$rs->preco
                                   ."</th><th><center><a href='cadastro.php'>[Alterar]</a>"
                                   ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                                   ."<a href=\"\">[Excluir]</a></center></th>";
                        echo "</tr>";
                        echo "</tbody>";
                    }
                } else {
                    echo "Erro: Não foi possível recuperar os dados do banco de dados";
                }
        } catch (PDOException $erro) {
            echo "Erro: ".$erro->getMessage();
        }
        ?>
    </table>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
