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

    // Consulta SQL para obtener todos los departamentos
    $sql = "SELECT DepartamentoID, NombreDepartamento, Descripcion FROM Departamentos";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Obtener todos los resultados como un array asociativo
    $departamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Establecer el tipo de contenido a JSON
    header('Content-Type: application/json');

    // Convertir el array de departamentos a formato JSON y mostrarlo
    echo json_encode($departamentos);

} catch (PDOException $e) {
    // En caso de error en la conexión o la consulta
    header('Content-Type: application/json');
    echo json_encode(array("error" => "Error de base de datos: " . $e->getMessage()));
}

// Cerrar la conexión PDO (opcional, se cierra automáticamente al finalizar el script)
$pdo = null;
?>