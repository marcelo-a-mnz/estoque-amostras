<?php
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Menu de usuários</title>
</head>

<body>
  <header>
    <div class="nav-caixa">
      <a class="btn btn-dark" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button"
        aria-controls="offcanvasExample">
        <i class="fa-solid fa-bars"></i>
      </a>
      <div class="logo-menu">
        <img src="img/logo.png" alt="name logo">
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
                <a class="nav-link" href="usuarios.php">Menu do usuário</a>
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
          <h1>Usuários</h1>
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
             Cadastrar
              <i class="fa-solid fa-plus"></i>
            </button>
            <div class="modal fade modal-hover" id="cadastrar" tabindex="-1" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="corpo">
                      <div class="cadastrar">
                        <form action="php/cadastrar-usuario.php" name="form-cadastrar-usuario" method="POST">
                          <h1 class="text-center">Cadastro <i class="fa-regular fa-user"></i></h1>
                          <input type="text" class="form-control" name="novo-usuario" id="novo-usuario"
                            placeholder="Nome de usuário" onkeyup="replaceEspecialInput('novo-usuario');"
                            onKeyPress="if(this.value.length==20) return false;" required>
                          <input type="password" class="form-control" name="senha" id="senha" placeholder="Senha"
                            onkeyup="replaceEspecialInput('senha');"
                            onKeyPress="if(this.value.length==60) return false;" required>
                          <input type="password" class="form-control" name="confirmar-senha" id="confirmar-senha"
                            placeholder="Confirmar senha" onkeyup="replaceEspecialInput('confirmar-senha');"
                            onKeyPress="if(this.value.length==60) return false;" required>
                          <label for="mostrar_senha"><input type="checkbox" name="mostrar-senha" id="mostrar-senha"
                              onclick="mostrarSenhaCadastro();"> Mostrar senha</label>

                          <div class="tipos">
                            <label for="funcao"> <input type="radio" name="funcao" id="funcao" value="1" checked>
                              Químico </label>
                            <label for="funcao"> <input type="radio" name="funcao" id="funcao" value="2"> Estagiário
                            </label>
                          </div>
                          <button type="submit" class="btn btn-success">Cadastrar usuário</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tabela">
          <table class="table table table-hover " id="tabela">
            <thead>
              <tr>
                <th col scope="col" >Usuário</th>
                <th scope="col" ><div class="espaco"></div></th>
                <th scope="col" >Cargo</th>
                <th scope="col" ><div class="espaco"></div></th>

                <th scope="col" >Opções</th>
              </tr>
            </thead>
            <tbody class="table-group-divider">
              <?php
                $query = 'select * from usuarios;';
                $dados_usuarios = mysqli_query($conn,$query);
                foreach($dados_usuarios as $usuario){
                  $usu = $usuario['usuario'];
                  $privilegio = $usuario['privilegio'];
                  $cargo = $privilegio == 1 ? "Químico":"Estagário";
              ?>
              <tr>
                <td><?=$usu?></td>
                <td><div class="espaco"></div></td>
                <td><?=$cargo?></td>
                <td><div class="espaco"></div></td>
                <td>
                  <button type="button"
                    class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editar"
                    onclick="modalEditarUsuario(<?=params_js($usu,$privilegio)?>)">
                    <i class="fa-solid fa-edit"></i>
                  </button>
                  <button type="button"
                    class="btn btn-danger"
                    onclick="deletarUsuario(<?=params_js($usu)?>)">
                    <i class="fa-solid fa-trash"></i>
                  </button>
              </tr>
            <?php } ?>
                <div class="modal fade modal-hover" id="editar" tabindex="-1" aria-labelledby="exampleModalLabel"
                  aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar usuário</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>

                      <div class="modal-body">
                        <form action="php/editar-usuario.php" method="POST" name="form-editar-usuario"
                          class="formulario">
                          <div class="usuario">
                            <label for="campo-alterar-senha">Usuário</label>
                            <input type="text" value="teste" class="form-control mb-2" name="usuario" id="usuario" readonly>
                          </div>
                          <div class="alterar-senha">
                            <label for="campo-alterar-senha">Alterar senha</label>
                            <input type="password" id="nova-senha" placeholder="Digite a nova senha" class="form-control mb-2" name="nova-senha" onkeyup="replaceEspecialInput('nova-senha');">
                            <input type="password" id="nova-senha-confirmar" placeholder="Confirme a nova senha" class="form-control mb-2" name="nova-senha-editar" onkeyup="replaceEspecialInput('nova-senha-confirmar');">
                          </div>
                          <div class="tipos">
                            <label class="mb-2">Alterar cargo</label> 
                            <label for="funcao"> <input type="radio" name="funcao" id="funcao" value="1" checked> Químico </label>
                            <label for="funcao"> <input type="radio" name="funcao" id="funcao2" value="2"> Estagiário </label>
                            
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
            </tbody>
          </table>
        </div>
      </div>

    </div>


    </div>

  </main>

  <script src="https://kit.fontawesome.com/d71269c410.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
    crossorigin="anonymous"></script>
  <script src="js/script.js"></script>
  <script src="js/usuarios.js"></script>
  <script src="js/sweetalert2.js"></script>



</body>

</html>
