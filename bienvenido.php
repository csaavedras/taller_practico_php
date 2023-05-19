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
?>
<!DOCTYPE html>
<html>
<head>
    <title>Bienvenido</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Bienvenido <?php echo $usuario; ?></h1>
        <a href="insertar.php" class="btn btn-primary">Insertar registro</a>
        <table class="table mt-4">
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
                                    <td><?php echo $row['estado'] ? 'Si' : 'No'; ?></td>
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
</body>
</html>