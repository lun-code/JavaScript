<?php
header('Content-Type: application/json');
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

    // Verificar si se recibieron los datos del nuevo departamento por POST
    if (isset($_POST['nombre_departamento']) && isset($_POST['descripcion'])) {
        $nombreDepartamento = $_POST['nombre_departamento'];
        $descripcion = $_POST['descripcion'];

        // Consulta SQL para insertar un nuevo departamento
        $sql = "INSERT INTO Departamentos (NombreDepartamento, Descripcion) VALUES (:nombre, :descripcion)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombreDepartamento, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);

        if ($stmt->execute()) {
            // Si la inserción fue exitosa
            header('Content-Type: application/json');
            echo json_encode(array("mensaje" => "Departamento insertado correctamente con ID: " . $pdo->lastInsertId()));
        } else {
            // Si hubo un error en la inserción
            header('Content-Type: application/json');
            echo json_encode(array("error" => "Error al insertar el departamento."));
        }

    } else {
        // Si no se recibieron los datos necesarios por POST
        header('Content-Type: application/json');
        echo json_encode(array("error" => "Por favor, proporciona el nombre del departamento y la descripción mediante una petición POST."));
    }

} catch (PDOException $e) {
    // En caso de error en la conexión o la consulta
    header('Content-Type: application/json');
    echo json_encode(array("error" => "Error de base de datos: " . $e->getMessage()));
}

// Cerrar la conexión PDO (opcional)
$pdo = null;
?>