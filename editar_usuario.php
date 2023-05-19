<?php
include 'header.php';
include 'funciones.php';
session_start();

// Verificar si el usuario no está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores enviados desde el formulario
    $id = $_POST['id'];
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];
    $estado = isset($_POST['estado']) ? 1 : 0;

    $sql = "UPDATE usuarios SET usuario = '$usuario', clave = '$clave', estado = '$estado' WHERE id = $id";
    
    $conn->query($sql);
    header("Location: usuarios.php");
    exit();
}

// Obtener el ID del registro seleccionado
$id = $_GET['id'];

// Obtener la información del registro desde la base de datos
$sql = "SELECT * FROM usuarios WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $usuario = $row['usuario'];
    $clave = $row['clave'];
    $estado = $row['estado'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar registro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Editar usuario</h1>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" name="usuario" class="form-control" value="<?php echo $usuario; ?>" required>
            </div>
            <div class="mb-3">
                <label for="clave" class="form-label">clave</label>
                <input type="text" name="clave" class="form-control" value="<?php echo $clave; ?>" required>
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Publiado</label>
                <select name="estado" class="form-control">
                    <option value="1" <?php if ($estado == 1) echo 'selected'; ?>>Si</option>
                    <option value="0" <?php if ($estado == 0) echo 'selected'; ?>>No</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="../prueba/usuarios.php" class="btn btn-danger   ">Cancelar</a>
        </form>
    </div>
</body>
</html>