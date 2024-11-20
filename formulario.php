<?php

include("php/conexao.php");
include("php/funcoes.php");

session_start();
valida_sessao($conn);

if (isset($_GET["prateleira"])){
	$prateleira = strtoupper($_GET["prateleira"]);
	if (!prateleira_existe($conn,$prateleira)){
		header("Location: formulario.php");
	}
}

$matriz = pega_matriz($conn,$prateleira);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <script src="https://kit.fontawesome.com/d71269c410.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
    crossorigin="anonymous"></script>
  <script src="js/script.js"></script>
  <script src="js/formulario.js" defer></script>
  <script src="js/sweetalert2.js"></script>

  <title>Formulário</title>
</head>

<body>
  <header>
    <div class="nav-caixa">
      <a class="btn btn-dark" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button"
        aria-controls="offcanvasExample">
        <i class="fa-solid fa-bars"></i>
      </a>
      <div class="logo-menu">
        <img src="img/logo.png" alt="logo name">
      </div>

      <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
        aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
          <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <div class="nav-pacote">
            <ul class="nav-lista">
              <li class="nav-item">
                <a class="nav-link active" href="index.php">Início</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="prateleiras.php">Prateleiras</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="formulario.php">Formulário</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="usuarios.php">Menu de usuários</a>
              </li>
              <li class="nav-item">
                <form class="formulario-login" action="login.php">
                  <button type="submit" name="sair" class="btn" onclick="sair()">Sair <i
                      class="fa-solid fa-right-from-bracket"></i></button>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </header>
  <main>

    <div class="container">
      <div class="content">
        <div class="titulo">
          <h1>Formulário <h3><span><?php echo $prateleira;?></span></h3></h1><h5>(<?php echo $matriz;?>)</h5>
		  
      <?php
      $resultado_prateleiras = pega_prateleiras($conn);
      $prateleiras_html = "";
      while ($row = mysqli_fetch_array($resultado_prateleiras)){
        $nome_prateleira = $row["prateleira"];
        $prateleiras_html .= '<a href="formulario.php?prateleira='.$nome_prateleira.'">'.$nome_prateleira.'</a> ';
      }
      echo $prateleiras_html;
		  ?>
          
        </div>
        <div class="topo">
          <div class="pesquisar">
            <input list="pesquisar" class="form-control" placeholder="Pesquisar" id="q" onkeyup="tablePesquisar();">
            <datalist id="pesquisar">
              <option value="op1"></option>
              <option value="op2"></option>
              <option value="op3"></option>
              <option value="op4"></option>
            </datalist>
          </div>
          <div class="cadastro">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#cadastrar">
              Adicionar
              <i class="fa-solid fa-plus"></i>
            </button>
            <div class="modal fade modal-hover" id="cadastrar" tabindex="-1" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastro de amostra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="php/cadastrar-amostra.php" method="POST" name="form-cadastrar-amostra"
                      class="formulario">
                      <div class="prateleira">
                        <label for="campo-pratileira">Prateleira </label>
                        <input type="text" class="form-control mb-2" name="prateleira" id="campo-prateleira"
                          maxlength="2" value="<?php echo $prateleira;?>" readonly>
                      </div>
                      <div class="data-amostra">
                        <label for="campo-data-amostra"> Data de amostragem </label>
                        <input type="date" class="form-control mb-2" name="data" id="campo-data-amostra"
                          max="2024-01-20" required>
                      </div>
                      <div class="lacre">
                        <label for="campo-lacre">Lacre</label>
                        <input type="number" class="form-control mb-2" name="lacre" id="campo-lacre" minlengh="5" placeholder="EX: 12345" onKeyPress="if(this.value.length==5) return false;"
                          required>
                      </div>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-success">Salvar</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="edicao">
            <div class="modal fade modal-hover" id="editar" tabindex="-1" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar amostra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="php/editar-amostra.php" method="POST" name="form-editar-amostra"
                      class="formulario">
                      <div class="prateleira">
                        <label for="campo-pratileira">Prateleira </label>
                        <input type="text" class="form-control mb-2" name="prateleira" id="campo-prateleira-editar"
                          maxlength="2" value="<?php echo $prateleira;?>">
                      </div>
                      <div class="data-amostra">
                        <label for="campo-data-amostra"> Data de amostragem </label>
                        <input type="date" class="form-control mb-2" name="data" id="campo-data-amostra-editar"
                          max="2024-01-20" required>
                      </div>
                      <div class="lacre">
                        <label for="campo-lacre">Lacre</label>
                        <input type="number" class="form-control mb-2" name="lacre" id="campo-lacre-editar" minlengh="5" placeholder="EX: 12345" onKeyPress="if(this.value.length==5) return false;"
                          readonly>
                      </div>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-success">Salvar</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>


        <div class="tabela">
          <table class="table table table-hover " id="tabela">
            <thead>
              <tr>
                <th scope="col">Lacre</th>
                <th scope="col">Data de entrada</th>
                <th scope="col">Responsável </th>
                <th scope="col">Opções</th>
              </tr>
            </thead>
            <tbody class="table-group-divider">
			         <?php
                 $amostras_dados = pega_amostras_presentes($conn,$prateleira);
                foreach($amostras_dados as $amostra){
                  $lacre = $amostra['lacre'];
                  $data_amostragem = $amostra['data_amostragem'];
                  $assinatura_cadastro = $amostra['assinatura_cadastro'];
                  $date = date("d/m/Y",strtotime(str_replace('-','/',$data_amostragem)));
               ?>
               <tr>
                  <td colspan="1"><div class="pip"><?= $lacre;?></div></td>
                  <td colspan="1"><?= $date;?></td>
                  <td colspan="1"><?= $assinatura_cadastro;?></td>
                  <td colspan="2">
                    <div class="pip">
                      <button type="button"
                        data-bs-toggle="modal" data-bs-target="#editar" class="btn btn-warning"
                        onclick="editAmostraFormulario(<?=params_js($prateleira,$lacre,$data_amostragem);?>);">
                        <i class="fa-solid fa-edit"></i>
                      </button>
                      <button type="button" class="btn btn-danger"
                        onclick="deletarAmostra(<?=$lacre;?>)">
                        <i class="fa-solid fa-trash"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              <?php } ?>

            </tbody>
          </table>
        </div>
      </div>

    </div>


    </div>

  </main>
</body>

</html>
