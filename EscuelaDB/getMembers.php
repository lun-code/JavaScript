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

    // Verificar si se recibió el nombre del departamento por GET
    if (isset($_GET['departamento'])) {
        $nombreDepartamento = $_GET['departamento'];

        // Consulta SQL para obtener los miembros de un departamento específico
        $sql = "SELECT m.MiembroID, m.Nombre, m.Apellido, m.Email, m.Telefono, m.FechaIngreso
                FROM MiembrosDepartamento m
                JOIN Departamentos d ON m.DepartamentoID = d.DepartamentoID
                WHERE d.NombreDepartamento = :nombreDepartamento";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombreDepartamento', $nombreDepartamento, PDO::PARAM_STR);
        $stmt->execute();

        // Obtener todos los resultados como un array asociativo
        $miembros = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Establecer el tipo de contenido a JSON
        header('Content-Type: application/json');

        // Convertir el array de miembros a formato JSON y mostrarlo
        echo json_encode($miembros);

    } else {
        // Si no se proporciona el nombre del departamento, devolver un error
        header('Content-Type: application/json');
        echo json_encode(array("error" => "Por favor, proporciona el nombre del departamento como parámetro en la URL (ej: ?departamento=NombreDepartamento)."));
    }

} catch (PDOException $e) {
    // En caso de error en la conexión o la consulta
    header('Content-Type: application/json');
    echo json_encode(array("error" => "Error de base de datos: " . $e->getMessage()));
}

// Cerrar la conexión PDO (opcional)
$pdo = null;
?>