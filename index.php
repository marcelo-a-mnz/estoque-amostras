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

  <script src="https://kit.fontawesome.com/d71269c410.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
    crossorigin="anonymous"></script>
  <script src="js/script.js"></script>
  <script src="js/index.js" defer></script>
  <script src="js/sweetalert2.js"></script>

  <title>Cadastro de Amostras</title>
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
                <a class="nav-link" href="usuarios.php">Menu de usuários</a>
              </li>
              <li class="nav-item">
                <form class="formulario-login" action="logout.php" method="POST">
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
    <div class="principal">
      <div class="col">
        <div class="row">
          <div class="titulo text-center">
            <h1>Início</h1>
          </div>
        </div>
        <div class="row">
          <div class="botoes">
            <div class="row mt-5">
              <div class="cadastro">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#cadastrar">
                  Cadastrar amostra
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
                              maxlength="2" value="A1" placeholder="EX: A1"
                              oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                               onkeyup="replaceEspecialInput('campo-prateleira');" required>
                          </div>
                          <div class="data-amostra">
                            <label for="campo-data-amostra"> Data de amostragem </label>
                            <input type="date" class="form-control mb-2" name="data" id="campo-data-amostra"
                              max="2024-01-20" required>
                          </div>
                          <div class="lacre">
                            <label for="campo-lacre">Lacre</label>
                            <input type="number" class="form-control mb-2" name="lacre" id="campo-lacre" minlengh="5"
                              value="" placeholder="EX: 12345" onKeyPress="if(this.value.length==5) return false;" required>
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
            <div class="row mt-5">
              <div class="descarte">
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#descarte">
                  Descartar amostras <i class="fa-solid fa-trash"></i>
                </button>
                <div class="modal fade modal-hover" id="descarte" tabindex="-1" aria-labelledby="exampleModalLabel"
                  aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Descarte de amostras</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form action="php/descartar-amostra.php" method="POST" name="form-descartar-amostra"
                          class="formulario">
                          <div class="opcoes">
                            <div class="unico" onclick="descarteUnicoChecked()">
                              <input type="radio" name="unico" id="unico" checked>
                              <label for="Descarte único">Descarte único</label>
                            </div>
                            <div class="massivo" onclick="descarteMassivoChecked()">
                              <input type="radio" name="massivo" id="massivo">
                              <label for="Descarte massivo">Descarte massivo</label>
                            </div>
                          </div>
                          <div class="lacre" id="lacre" style="display: block">
                            <label for="campo-lacre-descarte">Lacre da amostra </label>
                            <input type="number" name="lacre" class="form-control mb-3 mt-2" placeholder="ex: 12345"
                              name="lacre" id="campo-lacre-descarte" maxlength="5"
                              oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                              required>
                          </div>

                          <div class="prateleira" id="prateleira" style="display :none">
                            <label for="campo-prateleira-descarte">Prateleira</label>
                            <input type="text" class="form-control mb-3 mt-2" placeholder="ex: A1" name="prateleira"
                              id="campo-prateleira-descarte" maxlength="2"
                               onkeyup="replaceEspecialInput('campo-prateleira-descarte');" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                          </div>

                          <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Descartar <i
                                class="fa-solid fa-trash"></i></button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mt-5">
              <div class="consulta">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#consultar">
                  Consultar amostra <i class="fa-solid fa-search"></i>
                </button>
                <div class="modal fade modal-hover" id="consultar" tabindex="-1" aria-labelledby="exampleModalLabel"
                  aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Consultar amostra</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>

                      <div class="modal-body">
                        <form action="php/consultar-amostra.php" method="POST" name="form-consultar-amostra"
                          class="formulario">
                          <div class="lacre">
                            <label for="campo-lacre">Lacre</label>
                            <input type="number" class="form-control mb-2" name="lacre" id="campo-lacre-consultar" minlengh="5"
                              placeholder="EX: 12345" onKeyPress="if(this.value.length==5) return false;" required>
                          </div>

                          <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-success">Consultar</button>
                          </div>
                        </form>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mt-5">
              <div class="edicao">
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editar">
                  Editar amostras <i class="fa-solid fa-edit"></i>
                </button>
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
                              maxlength="2" value="A1" placeholder="EX: A1" 
                              oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                              required>
                          </div>
                          <div class="data-amostra">
                            <label for="campo-data-amostra"> Data de amostragem </label>
                            <input type="date" class="form-control mb-2" name="data" id="campo-data-amostra-editar"
                              max="2024-01-20" required>
                          </div>
                          <div class="lacre">
                            <label for="campo-lacre">Lacre</label>
                            <input type="number" class="form-control mb-2" name="lacre" id="campo-lacre-editar" minlengh="5"
                              value="" placeholder="EX: 12345" onKeyPress="if(this.value.length==5) return false;" required>
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
            

          </div>

        </div>
      </div>
    </div>
    </div>
  </main>
</body>

</html>