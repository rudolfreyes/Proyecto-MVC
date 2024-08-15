
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexión a la base de datos
$servername = "sql110.infinityfree.com";  // Nombre del servidor (o IP)
$username = "if0_37107606";         // Usuario de la base de datos
$password = "Ruud0lfpapi8";             // Contraseña del usuario
$dbname = "if0_37107606_database"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Validar y sanitizar los datos del formulario
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);
$message = trim($_POST['message']);

// Preparar la consulta SQL
$stmt = $conn->prepare("INSERT INTO contacto (nombre_completo, correo_electronico, numero_telefono, mensaje) VALUES (?, ?, ?, ?)");
if ($stmt === false) {
    die("Error preparando la consulta: " . $conn->error);
}

// Vincular los parámetros y ejecutar la consulta
$stmt->bind_param("ssss", $name, $email, $phone, $message);

if ($stmt->execute()) {
    echo "<script>alert('Datos enviados correctamente'); window.location.href = 'index.php';</script>";
} else {
    echo "Error al insertar datos: " . $stmt->error;
}

// Cerrar la consulta y la conexión
$stmt->close();
$conn->close();
?>