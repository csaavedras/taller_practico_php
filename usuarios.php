<?php
include 'funciones.php';
include 'header.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$usuario = $_SESSION['usuario'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];
    $nombre = $_POST['nombre'];
    $estado = $_POST['estado'];

    $sql = "INSERT INTO usuarios (usuario, clave, nombre, estado) VALUES ('$usuario', '$clave', '$nombre', $estado)";
    $conn->query($sql);

    header("Location: usuarios.php");
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
        <h1 class="mt-5">Bienvenido <?php echo $usuario; ?></h1>
        <div class="insertar_registro mb-3 d-none">
            <div class="button_hidden float-end text-danger fs-4">
                <i class="bi bi-x-circle"></i>
            </div>
            <form id="userForm" method="POST" action="" enctype="multipart/form-data" novalidate>
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text" name="usuario" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="clave" class="form-label">Clave</label>
                    <input type="password" name="clave" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="estado" class="form-label">Publicado</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="estado" id="estado_si" value="1" checked>
                        <label class="form-check-label" for="estado_si">
                            Si
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="estado" id="estado_no" value="0">
                        <label class="form-check-label" for="estado_no">
                            No
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
        <button class="btn btn-primary button_show">Insertar registro</button>
        <table class="table mt-4 table-dark table-striped">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Publicado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Obtener los registros de la tabla 'areas'
                    $sql = "SELECT * FROM usuarios";
                    $result = $conn->query($sql);
                ?>

                    <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['usuario']; ?></td>
                                    <td><?php echo $row['estado'] ? 'Si' : 'No'; ?></td>
                                    <td>
                                        <a href="editar_usuario.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Editar</a>
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