<?php
require_once("conexion.php");
require_once("funciones.php");

// autentificación de usuario
verificar_sesion();

$id_usuario = $_SESSION['id_usuario'];

// el texto que se ingresa al buscar
$buscar = trim($_GET['buscar'] ?? '');


// ordena por fecha
$orden_fecha = $_GET['orden_fecha'] ?? 'nombre';
$ordenes_permitidos = [
    'nombre' => 'nombre ASC',
    'ciudad' => 'ciudad ASC, nombre ASC',
    'fecha' => 'fecha_creacion DESC',
    'favoritos' => 'nombre ASC',
];

if (!array_key_exists($orden_fecha, $ordenes_permitidos)) {
    $orden_fecha = 'nombre';
}

// consulta base: solo contactos del usuario
$sql = "SELECT id, nombre, telefono, correo, ciudad, favorito FROM contactos WHERE id_usuario = ?";

// si escribió algo, se agrega el filtro
if ($buscar !== '') {
    $sql .= " AND (nombre LIKE ? OR correo LIKE ? OR ciudad LIKE ?)";
}

// muestra solo mis contactos favoritos
if ($orden_fecha === 'favoritos') {
    $sql .= " AND favorito = 1";
}

//$sql .= " ORDER BY nombre";
$sql .= " ORDER BY " . $ordenes_permitidos[$orden_fecha];

$stmt = $conexion->prepare($sql);

if ($buscar !== '') {
    $bus_contacto = "%{$buscar}%";
    $stmt->bind_param("isss", $id_usuario, $bus_contacto, $bus_contacto, $bus_contacto);
} else {
    $stmt->bind_param("i", $id_usuario);
}

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
    <div class="container mt-5">

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
            <!--buscar contactos -->
            <form method="GET" action="panel.php" class="d-flex gap-2 mb-3">
                <input type="text" name="buscar" class="form-control" placeholder="Buscar por nombre, correo o ciudad"
                    value="<?= escape_html($buscar) ?>">

                <select name="orden_fecha" class="form-select w-auto" onchange="this.form.submit()">
                    <option value="nombre" <?= $orden_fecha === 'nombre' ? 'selected' : '' ?>>Ordenar por nombre</option>
                    <option value="ciudad" <?= $orden_fecha === 'ciudad' ? 'selected' : '' ?>>Ordenar por ciudad</option>
                    <option value="fecha" <?= $orden_fecha === 'fecha' ? 'selected' : '' ?>>Más recientes primero</option>
                    <option value="favoritos" <?= $orden_fecha === 'favoritos' ? 'selected' : '' ?>>Solo favoritos</option>
                </select>



                <button type="submit" class="btn btn-outline-primary">Buscar</button>
                <a href="panel.php" class="btn btn-outline-secondary">Limpiar</a>
            </form>

            <?php if ($contactos->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center text-nowrap" style="width: 1%;">Favorito</th>
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
                                    <td class="text-center" style="width: 1%;"><?php if ($fila['favorito'] == 1): ?>
                                            <span class="text-warning">★</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= escape_html($fila['nombre']) ?></td>
                                    <td><?= escape_html($fila['telefono']) ?></td>
                                    <td><?= escape_html($fila['correo']) ?></td>
                                    <td><?= escape_html($fila['ciudad']) ?></td>

                                    <td>
                                        <a href="editar_contacto.php?id=<?= (int) $fila['id'] ?>"
                                            class="btn btn-sm btn-warning">Editar</a>

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
                <?php if ($buscar !== ''): ?>
                    <p class="text-muted text-center mb-0">No se encontraron contactos con "<?= escape_html($buscar) ?>".
                    </p>
                <?php else: ?>
                    <p class="text-muted text-center mb-0">Todavía no tienes contactos registrados.</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
<?php
$stmt->close();
$conexion->close();
?>