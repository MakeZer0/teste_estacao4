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

            if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $nome != "") {
                try {
                    $stmt = $con->prepare("INSERT INTO produtos (nome, descricao, preco) VALUES (?, ?, ?)");
                    $stmt->bindParam(1, $nome);
                    $stmt->bindParam(2, $descricao);
                    $stmt->bindParam(3, $preco);

                    if ($stmt->execute()) {
                        if ($stmt->rowCount() > 0) {
                            //header("Refresh: 20; url = cadastro.php");
                            //echo "Dados cadastrados com sucesso!";
                            echo  "<div class='alert alert-success' role='alert'>";
                            echo  "Dados cadastrados com sucesso!";
                            echo  "</div>";
                            $id = null;
                            $nome = null;
                            $descricao = null;
                            $preco = null;

                        } else {
                            echo "Erro ao tentar efetivar cadastro";
                        }
                    } else {
                           throw new PDOException("Erro: Não foi possível executar a declaração sql");
                    }


                } catch (PDOException $erro) {
                    echo "Erro: " . $erro->getMessage();
                }
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
              <a class="dropdown-item" href="listagem.php">Listagem</a>
              <a class="dropdown-item" href="#">Atualizar</a>
              <a class="dropdown-item" href="#">Deletar</a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
    <form action="?act=save" method="POST" name="form1">
      <input type="hidden" name="id" <?php
        // Preenche o id no campo id com um valor "value"
        if (isset($id) && $id != null || $id != "") {
            echo "value=\"{$id}\"";
        }
        ?> />
      <div class="form-group row">
        <label for="colFormLabel" class="col-sm-2 col-form-label">Nome</label>
        <div class="col-sm-10">
          <input type="descricao" class="form-control form-control-label" id="colFormLabel1" placeholder="Digite o nome do produto" name="nome" <?php
            // Preenche o nome no campo nome com um valor "value"
            if (isset($nome) && $nome != null || $nome != ""){
                echo "value=\"{$nome}\"";
            }
            ?>>
        </div>
      </div>
      <div class="form-group row">
        <label for="colFormLabel" class="col-sm-2 col-form-label">Descrição</label>
        <div class="col-sm-10">
          <input type="descricao" class="form-control" id="colFormLabel2" placeholder="Digite a descrição do produto" name="descricao" <?php
            // Preenche o descricao no campo descricao com um valor "value"
            if (isset($descricao) && $descricao != null || $descricao != ""){
                echo "value=\"{$descricao}\"";
            }
            ?> >
        </div>
      </div>
      <div class="form-group row">
        <label for="colFormLabel" class="col-sm-2 col-form-label">Preço</label>
        <div class="col-sm-10">
          <input type="descricao" class="form-control form-control-label" id="colFormLabel3" placeholder="Digite o preço do produto" name="preco" <?php
            // Preenche o preco no campo preco com um valor "value"
            if (isset($preco) && $preco != null || $preco != ""){
                echo "value=\"{$preco}\"";
            }
            ?> >
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
