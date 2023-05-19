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
    $nombreArea = $_POST['nombre_area'];
    $descripcion = $_POST['descripcion'];
    $publicado = isset($_POST['publicado']) && $_POST['publicado'] == "1" ? 1 : 0;

    // Verificar si se ha seleccionado una nueva imagen
    if (!empty($_FILES['imagen']['name'])) {
        $imagen = $_FILES['imagen']['name'];
        // Guardar la imagen en la carpeta "uploads"
        $rutaImagen = "uploads/" . basename($imagen);
        move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen);
        // Actualizar los datos en la base de datos con la nueva imagen
        $sql = "UPDATE areas SET nombre = '$nombreArea', descripcion = '$descripcion', imagen = '$imagen', estado = $publicado WHERE id = $id";
    } else {
        // Mantener el valor actual de la imagen en la base de datos
        $sql = "UPDATE areas SET nombre = '$nombreArea', descripcion = '$descripcion', estado = $publicado WHERE id = $id";
    }
    
    $conn->query($sql);
    header("Location: bienvenido.php");
    exit();
}

// Obtener el ID del registro seleccionado
$id = $_GET['id'];

// Obtener la información del registro desde la base de datos
$sql = "SELECT * FROM areas WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $nombreArea = $row['nombre'];
    $descripcion = $row['descripcion'];
    $imagen = $row['imagen'];
    $publicado = $row['estado'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar registro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://cdn.tiny.cloud/1/0cyh1fdw6k4o2zd92i7mcz7cv518yvjcb7ni0szxgwxdjs8x/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        // Inicializar el editor TinyMCE
        tinymce.init({
            selector: 'textarea',
            height: 300,
            plugins: 'link image code',
            toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright | bullist numlist outdent indent | link image | code',
        });
    </script>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Editar registro</h1>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="mb-3">
                <label for="nombre_area" class="form-label">Nombre area</label>
                <input type="text" name="nombre_area" class="form-control" value="<?php echo $nombreArea; ?>" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" required><?php echo $descripcion; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen</label>
                <input type="file" name="imagen" class="form-control">
                <img class="img-thumbnail w-25" src="uploads/<?php echo $imagen; ?>" alt="<?php echo $nombreArea; ?>">
            </div>
            <div class="mb-3">
                <label for="publicado" class="form-label">Publicado</label>
                <div class="form-check">
                    <input type="radio" name="publicado" value="1" id="publicado_si" <?php if ($publicado == 1) echo 'checked'; ?>>
                    <label class="form-check-label" for="publicado_si">Si</label>
                </div>
                <div class="form-check">
                    <input type="radio" name="publicado" value="0" id="publicado_no" <?php if ($publicado == 0) echo 'checked'; ?>>
                    <label class="form-check-label" for="publicado_no">No</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="../prueba/bienvenido.php" class="btn btn-danger   ">Cancelar</a>
        </form>
    </div>
</body>
</html>