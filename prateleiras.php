<?PHP
include("php/conexao.php");
include("php/funcoes.php");
session_start();
valida_sessao($conn);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://kit.fontawesome.com/d71269c410.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script src="js/script.js"></script>
<script src="js/prateleiras.js" defer></script>
<script src="js/sweetalert2.js"></script>
  <title>Prateleiras
    <?php echo " Versão PHP"; ?>
  </title>
</head>
<body>
  <header>
    <div class="nav-caixa">
      <a class="btn btn-dark" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
        <i class="fa-solid fa-bars"></i>
      </a>
      <div class="logo-menu">
        <img src="img/logo.png" alt="logo name">
      </div>
      <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
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
                <form class="formulario-logout" action="logout.php" method="POST">
                  <button type="submit" name="sair" class="btn" onclick="sair()">Sair <i class="fa-solid fa-right-from-bracket"></i></button>
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
          <h1>Prateleiras</h1>
        </div>
        <div class="topo">
          <div class="pesquisar">
            <input list="pesquisar" class="form-control" placeholder="Pesquisar" id="q" onkeyup="tablePesquisar();">
            
          </div>
          <div class="cadastro">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
              Adicionar <i class="fa-solid fa-plus"></i>
            </button>
            <div class="modal fade modal-hover" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastro de prateleiras</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="php/cadastrar-prateleira.php" method="POST" name="form-cadastrar-prateleiras" class="formulario">
                      <div class="prateleira">
                        <label for="campo-pratileira">Prateleira </label>
                        <input type="text" class="form-control mb-2" name="prateleira" id="campo-prateleira" maxlength="2" 
              placeholder="EX: B1" 
              oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
              onkeyup="replaceEspecialInput('campo-prateleira');" required>
                      </div>
                      <div class="matriz">
                        <label for="campo-matriz">Matriz </label>
                        <input type="text" class="form-control mb-2" name="matriz" id="campo-matriz" placeholder="EX: S10 A/B" 
              onkeyup="replaceEspecialInput('campo-matriz');" required>
                      </div>
                      <div class="validade">
                        <label for="campo-validade">Validade (em meses) </label>
                        <input type="number" class="form-control mb-2" name="validade" id="campo-validade" maxlength="2" placeholder="EX: 2" 
              oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>
                      </div>
                      <div class="capacidade-max">
                        <label for="campo-capacidade"> Capacidade máxima </label>
                        <input type="number" class="form-control mb-2" name="capacidade-max" id="campo-capacidade-max" placeholder="EX: 30" required>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success">Salvar</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- BAIXAR PRATELEIRA (VINICIUS, POR FAVOR NÃO CONFUNDIR OS MODAIS EDITAR E BAIXAR PRATELEIRA)-->
            <div class="modal fade modal-hover" id="baixar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Baixar prateleira</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="php/baixar-prateleira.php" method="POST" name="form-baixar-prateleira" class="formulario">
                      <div class="prateleira">
                        <label for="teste">Escolha um período </label>
                        <div class="teste mt-2">
                          <label for="campo-prateleira">Prateleira </label>
                          <input type="text" class="form-control mb-2" name="prateleira" id="campo-prateleira-baixar" maxlength="2" placeholder="EX: B1" readonly>
                          <label for="data-inicio">Início</label>
                          <input type="date" class="form-control" name="data-inicio" id="data-inicio" required>
                          <label for="data-final">Fim</label>
                          <input type="date" class="form-control" name="data-final" id="data-final" required>
                        </div>
                      </div>
                      <div class="opcoes-donwload">
                        <label>Esolha uma opção de download</label>
                        <div class="cadastrados mt-2">
                          <input type="radio" name="opcao" id="opcao" value="cadastradas">
                          <label for="opcao">Somente cadastradas</label>
                        </div>
                        <div class="cadastrados">
                          <input type="radio" name="opcao" id="opcao" value="descartadas">
                          <label for="opcao">Somente descartadas</label>
                        </div>
                        <div class="cadastrados">
                          <input type="radio" name="opcao" id="opcao" value="todas" checked>
                          <label opcao="opcao">Todas</label>
                        </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success">Salvar</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal fade modal-hover" id="editar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar prateleiras</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="php/editar-prateleira.php" method="POST" name="form-editar-prateleira" class="formulario">
                      <div class="prateleira">
                        <label for="campo-pratileira">Prateleira </label>
                        <input type="text" class="form-control mb-2" name="prateleira" id="campo-prateleira-editar" maxlength="2" readonly>
                      </div>
                      <div class="matriz">
                        <label for="campo-matriz">Matriz </label>
                        <input type="text" class="form-control mb-2" name="matriz" id="campo-matriz-editar" placeholder="EX: S10 A/B" onkeyup="replaceEspecialInput('campo-matriz-editar');" required>
                      </div>
                      <div class="validade">
                        <label for="campo-validade">Validade (em meses) </label>
                        <input type="number" class="form-control mb-2" name="validade" id="campo-validade-editar" maxlength="2" placeholder="EX: 2" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>
                      </div>
                      <div class="capacidade-max">
                        <label for="campo-capacidade"> Capacidade máxima </label>
                        <input type="number" class="form-control mb-2" name="capacidade-max" id="campo-capacidade-max-editar" placeholder="EX: 30" required>
                      </div>
                       <div class="opcao-deletar-prateleira">
                        <div class="deletar-prateleira">
                          <input type="checkbox" id="deletar-prateleira-checkbox" style="accent-color: red;" onclick="deletarPrateleiraChecked(e_value('campo-prateleira-editar'));">
                          <label for="opcao">Deletar prateleira</label>
                        </div>
                      </div>
                      <input type="hidden" id="migrar-amostras" name="migrar-amostras" value="false">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success">Salvar</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tabela">
          <table class="table table-hover table table-responsive " id="tabela">
            <thead>
              <tr>
                
                <th scope="col">Prateleira</th>
                <th scope="col">Matriz</th>
                <th scope="col">Vld (M)</th>
                <th scope="col">Qtd</th>
                <th scope="col">Opções</th>
              </tr>
            </thead>
            <tbody class="table-group-divider">
              <?php
              $prateleira_dados = pega_prateleiras($conn);
              foreach ($prateleira_dados as $prateleira){
                $prate = $prateleira['prateleira'];
                $matriz = $prateleira['matriz'];
                $validade = $prateleira['validade'];
                $capacidade_max = $prateleira['capacidade_max'];
                $capacidade_disp = $prateleira['capacidade_disp'];
                $quantidade_amostras = $capacidade_max  - $capacidade_disp;
                
                $tem_descarte = tem_amostra_pra_descarte($conn,$prate);
                $classe = $tem_descarte == true ? 'text-danger':'text-success';
              ?>
              <tr>
                <td><a href="formulario.php?prateleira=<?= $prate; ?>"><?=$prate;?></td>
                <td><?= $matriz; ?></td>
                <td><?= $validade; ?></td>
                <td class="<?= $classe;?>"><?= $quantidade_amostras."/".$capacidade_max; ?></td>
                <td class="text-center" style="vertical-align: middle;">
                  <div class="pip">
                    <i class="text-warning fa-solid fa-edit" data-bs-toggle="modal" data-bs-target="#editar" 
                      
                      onclick="modalEditarPrateleira(<?=params_js($prate,$matriz,$validade,$capacidade_max);?>);">
                    </i>
                    <i class="text-success fa-solid fa-download" data-bs-toggle="modal" data-bs-target="#baixar" 
                      onclick="modalBaixarPrateleira('<?=$prate;?>');">
                    </i>
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