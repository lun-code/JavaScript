<?php
// Datos de conexión a la base de datos
$servername = "localhost"; // O la dirección de tu servidor MySQL
$username = "root"; // Tu nombre de usuario de MySQL
$password = ""; // Tu contraseña de MySQL
$dbname = "EscuelaDB";

try {
    // Crear una instancia de PDO
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);

    // Establecer el modo de error de PDO a excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar si se recibieron los datos del nuevo miembro por POST
    if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['email']) && isset($_POST['departamento_id']) && isset($_POST['fecha_ingreso'])) {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $departamentoId = $_POST['departamento_id'];
        $fechaIngreso = $_POST['fecha_ingreso'];
        $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : null; // El teléfono es opcional

        // Consulta SQL para insertar un nuevo miembro
        $sql = "INSERT INTO MiembrosDepartamento (Nombre, Apellido, Email, Telefono, DepartamentoID, FechaIngreso)
                VALUES (:nombre, :apellido, :email, :telefono, :departamento_id, :fecha_ingreso)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
        $stmt->bindParam(':departamento_id', $departamentoId, PDO::PARAM_INT);
        $stmt->bindParam(':fecha_ingreso', $fechaIngreso, PDO::PARAM_STR);

        if ($stmt->execute()) {
            // Si la inserción fue exitosa
            header('Content-Type: application/json');
            echo json_encode(array("mensaje" => "Miembro insertado correctamente con ID: " . $pdo->lastInsertId()));
        } else {
            // Si hubo un error en la inserción
            header('Content-Type: application/json');
            echo json_encode(array("error" => "Error al insertar el miembro."));
        }

    } else {
        // Si no se recibieron los datos necesarios por POST
        header('Content-Type: application/json');
        echo json_encode(array("error" => "Por favor, proporciona todos los datos requeridos del miembro mediante una petición POST (nombre, apellido, email, departamento_id, fecha_ingreso). El teléfono es opcional."));
    }

} catch (PDOException $e) {
    // En caso de error en la conexión o la consulta
    header('Content-Type: application/json');
    echo json_encode(array("error" => "Error de base de datos: " . $e->getMessage()));
}

// Cerrar la conexión PDO (opcional)
$pdo = null;
?>