<!DOCTYPE html>
<?PHP
session_start();
$_SESSION["logado"] = 0;
?>

<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <script src="js/script.js"></script>
  <script src="js/login.js" defer></script>
  <script src="js/sweetalert2.js"></script>

  <title>Página de login
    <?php echo "Versão PHP";?>
  </title>
</head>

<body class="corpo">

  <div class="logo">
    <img src="img/logo.png" alt="logo name">
  </div>

  <div class="login">
    <form action="php/faz-login.php" method="POST" name="form-login">
      <h1 class="text-center">Login <i class="fa-regular fa-user"></i></h1>
      <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuário"
        onkeyup="replaceEspecialInput('usuario');" value="teste" required>
      <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" 
      onkeyup="replaceEspecialInput('senha');" value="teste" required>
      <label for="mostrar_senha" onclick="mostrarSenhaLogin()"><input type="checkbox" name="mostrar-senha" id="mostrar-senha"> Mostrar senha</label>
      <input type="hidden" name="modo" value="sistema-protegido">
      <button type="submit" class="btn btn-primary">Entrar</button>
    </form>

  </div>
</body>

</html>