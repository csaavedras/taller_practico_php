<?php
include 'funciones.php';
include 'header.php';

session_start();


// Verificar si el usuario no está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
// Obtener el nombre de usuario de la sesión
$usuario = $_SESSION['usuario'];

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores enviados desde el formulario
    $nombreArea = $_POST['nombre_area'];
    $descripcion = $_POST['descripcion'];
    $imagen = $_FILES['imagen']['name'];
    $estado = isset($_POST['publicado']) && $_POST['publicado'] == "1" ? 1 : 0;

    // Guardar la imagen en la carpeta "uploads"
    $rutaImagen = "uploads/" . basename($imagen);
    move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen);

    // Insertar los datos en la base de datos
    $sql = "INSERT INTO areas (nombre, descripcion, imagen, estado) VALUES ('$nombreArea', '$descripcion', '$imagen', $estado)";
    $conn->query($sql);
    header("Location: bienvenido.php");
    exit();
}


?>
<!DOCTYPE html>
<html>
<head>
    <title>Bienvenido</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- Bootstrap Font Icon CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
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
        <h1 class="mt-5 title">Bienvenido <?php echo $usuario; ?></h1>
        <div class="insertar_registro mb-3 d-none">
            <div class="button_hidden float-end text-danger fs-4">
                <i class="bi bi-x-circle"></i>
            </div>
            <form id="userForm" method="POST" action="" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nombre_area" class="form-label">Nombre area</label>
                    <input type="text" name="nombre_area" class="form-control " required>
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
                    <div class="form-check">
                    <input type="radio" name="publicado" value="1" id="publicado_si">
                    <label class="form-check-label" for="publicado_si">Si</label>
                    </div>
                   <div class="form-check">
                    <input type="radio" name="publicado" value="0" id="publicado_no">
                    <label class="form-check-label" for="publicado_no">No</label>
                   </div>
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
        <button class="btn btn-primary button_show d-flex align-items-center gap-2"><i class="bi bi-plus-circle"></i> Insertar registro</button>
        <table class="table mt-4 table-dark table-striped">
            <thead>
                <tr>
                    <th>Nombre area</th>
                    <th>Publicado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Obtener los registros de la tabla 'areas'
                    $sql = "SELECT * FROM areas";
                    $result = $conn->query($sql);
                ?>

                    <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['nombre']; ?></td>
                                    <td><?php echo $row['estado'] == 1 ? 'Si' : 'No'; ?></td>
                                    <td>
                                        <a href="editar.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Editar</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="3">No se encontraron registros</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="script.js"></script>
</body>
</html>