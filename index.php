<?php
require 'conexion.php';

$mensaje = '';

// 1. Registrar un Club
if (isset($_POST['registrar_club'])) {
    $sql = "INSERT INTO Clubes (nombre, deporte, ubicacion, fecha_fundacion) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['nombre_club'],
        $_POST['deporte'],
        $_POST['ubicacion'],
        $_POST['fecha_fundacion']
    ]);
    $mensaje = "Club deportivo registrado correctamente.";
}

// 2. Registrar un Miembro
if (isset($_POST['registrar_miembro'])) {
    $sql = "INSERT INTO Miembros (nombre, apellido, email, telefono, club_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['nombre_miembro'],
        $_POST['apellido'],
        $_POST['email'],
        $_POST['telefono'],
        $_POST['club_id']
    ]);
    $mensaje = "Miembro registrado correctamente.";
}

// 3. Eliminar Club o Miembro
if (isset($_GET['eliminar_club'])) {
    $stmt = $pdo->prepare("DELETE FROM Clubes WHERE club_id = ?");
    $stmt->execute([$_GET['eliminar_club']]);
    header("Location: index.php");
    exit;
}

if (isset($_GET['eliminar_miembro'])) {
    $stmt = $pdo->prepare("DELETE FROM Miembros WHERE miembro_id = ?");
    $stmt->execute([$_GET['eliminar_miembro']]);
    header("Location: index.php");
    exit;
}

// Consultas para mostrar registros
$clubes = $pdo->query("SELECT * FROM Clubes ORDER BY club_id DESC")->fetchAll(PDO::FETCH_ASSOC);
$miembros = $pdo->query("
    SELECT m.*, c.nombre AS nombre_club 
    FROM Miembros m 
    INNER JOIN Clubes c ON m.club_id = c.club_id 
    ORDER BY m.miembro_id DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Clubs Deportivos</title>
    <link href="https://jsdelivr.net" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <h2 class="mb-4 text-center">Sistema de Gestión de Clubs Deportivos</h2>

    <?php if ($mensaje): ?>
        <div class="alert alert-success"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">Registrar Club Deportivo</div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-2">
                            <label class="form-label">Nombre del Club</label>
                            <input type="text" name="nombre_club" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Deporte</label>
                            <input type="text" name="deporte" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Ubicación</label>
                            <input type="text" name="ubicacion" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fecha de Fundación</label>
                            <input type="date" name="fecha_fundacion" class="form-control" required>
                        </div>
                        <button type="submit" name="registrar_club" class="btn btn-primary w-100">Guardar Club</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">Registrar Miembro</div>
                <div class="card-body">
                    <form method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Nombre</label>
                                <input type="text" name="nombre_miembro" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Apellido</label>
                                <input type="text" name="apellido" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Teléfono</label>
                            <input type="text" name="telefono" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Club Deportivo</label>
                            <select name="club_id" class="form-select" required>
                                <option value="">-- Seleccione un club --</option>
                                <?php foreach ($clubes as $club): ?>
                                    <option value="<?= $club['club_id'] ?>"><?= htmlspecialchars($club['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" name="registrar_miembro" class="btn btn-success w-100">Guardar Miembro</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-header bg-dark text-white">Clubes Registrados</div>
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Deporte</th>
                        <th>Ubicación</th>
                        <th>Fundación</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clubes as $c): ?>
                    <tr>
                        <td><?= $c['club_id'] ?></td>
                        <td><?= htmlspecialchars($c['nombre']) ?></td>
                        <td><?= htmlspecialchars($c['deporte']) ?></td>
                        <td><?= htmlspecialchars($c['ubicacion']) ?></td>
                        <td><?= $c['fecha_fundacion'] ?></td>
                        <td>
                            <a href="?eliminar_club=<?= $c['club_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar club?')">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-header bg-dark text-white">Miembros Registrados</div>
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Club</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($miembros as $m): ?>
                    <tr>
                        <td><?= $m['miembro_id'] ?></td>
                        <td><?= htmlspecialchars($m['nombre'] . ' ' . $m['apellido']) ?></td>
                        <td><?= htmlspecialchars($m['email']) ?></td>
                        <td><?= htmlspecialchars($m['telefono']) ?></td>
                        <td><?= htmlspecialchars($m['nombre_club']) ?></td>
                        <td>
                            <a href="?eliminar_miembro=<?= $m['miembro_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar miembro?')">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
