<?php
require_once("conexion.php");
require_once("funciones.php");

// autentificación de usuario
verificar_sesion();

$id_usuario = $_SESSION['id_usuario'];

// lista contacto del usuario que inicio sesión
$stmt = $conexion->prepare("SELECT id, nombre, telefono, correo, ciudad FROM contactos WHERE id_usuario = ? ORDER BY nombre");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$contactos = $stmt->get_result();

// 3. MENSAJE DE ÉXITO O ERROR (viene de guardar, actualizar o borrar)
$mensaje = $_SESSION['mensaje'] ?? '';
unset($_SESSION['mensaje']);

// token para formulario de borrar 
$token = obtener_token();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> AGENDA DE <?= escape_html($_SESSION['nombre']) ?></title>
    <link href="css/estilos.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div  class="container mt-5">

        <!-- Datos del usuario -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2>Hola, <?= escape_html($_SESSION['nombre']) ?></h2>
                <p class="text-muted mb-0"><?= escape_html($_SESSION['correo']) ?></p>
            </div>
            <a href="logout.php" class="btn btn-outline-danger">Cerrar sesión</a>
        </div>

        <?php if ($mensaje !== ''): ?>
            <div class="alert alert-info"><?= escape_html($mensaje) ?></div>
        <?php endif; ?>

        <!-- Lista de contactos -->
        <div class="card shadow p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">Mis contactos</h4>
                <a href="nuevo_contacto.php" class="btn btn-primary">+ Nuevo contacto</a>
            </div>

            <?php if ($contactos->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Nombre</th>
                                <th>Teléfono</th>
                                <th>Correo</th>
                                <th>Ciudad</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($fila = $contactos->fetch_assoc()): ?>
                                <tr>
                                    <td><?= escape_html($fila['nombre']) ?></td>
                                    <td><?= escape_html($fila['telefono']) ?></td>
                                    <td><?= escape_html($fila['correo']) ?></td>
                                    <td><?= escape_html($fila['ciudad']) ?></td>
                                    <td>
                                        <a href="editar_contacto.php?id=<?= (int) $fila['id'] ?>" class="btn btn-sm btn-warning">Editar</a>

                                        <form method="POST" action="borrar_contacto.php" class="d-inline"
                                              onsubmit="return confirm('¿Seguro que desea eliminar este contacto?');">
                                            <input type="hidden" name="id" value="<?= (int) $fila['id'] ?>">
                                            <input type="hidden" name="token" value="<?= escape_html($token) ?>">
                                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-muted text-center mb-0">Todavía no tienes contactos registrados.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
<?php
$stmt->close();
$conexion->close();
?>