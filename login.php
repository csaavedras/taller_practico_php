<?php
include 'funciones.php';

session_start();


// Verificar si el usuario ya está autenticado
if (isset($_SESSION['usuario'])) {
    header("Location: bienvenido.php");
    exit();
}

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores enviados desde el formulario
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];
    // Validar el usuario y la contraseña en la base de datos
    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    $result = $conn->query($sql);
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if ($clave === $row['clave']) {
            // Autenticación exitosa, almacenar el usuario en la sesión
            $_SESSION['usuario'] = $usuario;
            header("Location: bienvenido.php");
            exit();
        } else {
            $mensaje = "Clave incorrecta";
        }
    } else {
        $mensaje = "Este usuario no existe ⛔";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
     <!-- Bootstrap  -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- Bootstrap Font Icon CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body>
    <section class="vh-100 d-flex flex-column justify-content-center bg-ligth text-dark">
       <div class="w-50 m-auto">
           <h1 class="text-center">Inicio sesión</h1>
           <?php if (isset($mensaje)) echo "<div class='alert alert-danger text-center' role='alert'> $mensaje</div>"; ?>
           <form method="POST" action="" class="d-flex flex-column justify-content-center ">
               <div class="mb-3">
                   <label for="usuario" class="form-label">Usuario</label>
                   <input type="text" name="usuario" class="form-control" required>
               </div>
               <div class="mb-3">
                   <label for="clave" class="form-label">Contraseña</label>
                   <input type="password" name="clave" class="form-control" required>
               </div>
               <button type="submit" class="btn btn-primary">Ingresar</button>
           </form>
       </div>
    </section>
</body>
</html>