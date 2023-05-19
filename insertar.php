<?php
include 'funciones.php';
session_start();

// Verificar si el usuario no está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores enviados desde el formulario
    $nombreArea = $_POST['nombre_area'];
    $descripcion = $_POST['descripcion'];
    $imagen = $_FILES['imagen']['name'];
    $publicado = isset($_POST['publicado']) ? 1 : 0;

    // Guardar la imagen en la carpeta "uploads"
    $rutaImagen = "uploads/" . basename($imagen);
    var_dump($imagen);
    move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen);

    // Insertar los datos en la base de datos
    $sql = "INSERT INTO areas (nombre, descripcion, imagen, publicado) VALUES ('$nombreArea', '$descripcion', '$imagen', $publicado)";
    $conn->query($sql);
    header("Location: bienvenido.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Insertar registro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://cdn.tiny.cloud/1/0cyh1fdw6k4o2zd92i7mcz7cv518yvjcb7ni0szxgwxdjs8x/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
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
        <h1>Insertar registro</h1>
        <form method="POST" action="" enctype="multipart/form-data novalidate">
            <div class="mb-3">
                <label for="nombre_area" class="form-label">Nombre area</label>
                <input type="text" name="nombre_area" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen</label>
                <input type="file" name="imagen" class="form-control">
            </div>
            <div class="mb-3">
                <label for="publicado" class="form-label">Publicado</label>
                <select name="publicado" class="form-control">
                    <option value="1">Si</option>
                    <option value="0">No</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
</body>
</html>


