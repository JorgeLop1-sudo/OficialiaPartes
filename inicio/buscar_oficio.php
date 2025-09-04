<?php
// buscar_oficio.php
header('Content-Type: application/json');

// Configuración de la base de datos
$servername = "127.0.0.1";
$username = "root"; // Cambia por tu usuario de MySQL
$password = ""; // Cambia por tu contraseña de MySQL
$dbname = "test";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos']);
    exit;
}

// Obtener el número de documento desde la solicitud
$numero_documento = isset($_POST['numero_documento']) ? $_POST['numero_documento'] : '';

if (empty($numero_documento)) {
    echo json_encode(['success' => false, 'message' => 'Número de documento no proporcionado']);
    exit;
}

// Consulta para obtener la información del oficio
$sql = "SELECT o.*, a_derivada.nombre as area_derivada_nombre, u_derivado.nombre as usuario_derivado_nombre
        FROM oficios o
        LEFT JOIN areas a_derivada ON o.area_derivada_id = a_derivada.id
        LEFT JOIN login u_derivado ON o.usuario_derivado_id = u_derivado.id
        WHERE o.numero_documento = ? AND o.activo = 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $numero_documento);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $oficio = $result->fetch_assoc();
    
    // Formatear los datos para la respuesta
    $response = [
        'success' => true,
        'data' => [
            'remitente' => $oficio['remitente'],
            'tipo_persona' => $oficio['tipo_persona'],
            'tipo_documento' => $oficio['tipo_documento'],
            'numero_documento' => $oficio['numero_documento'],
            'folios' => $oficio['folios'],
            'correo' => $oficio['correo'],
            'telefono' => $oficio['telefono'],
            'asunto' => $oficio['asunto'],
            'archivo_nombre' => $oficio['archivo_nombre'],
            'archivo_ruta' => $oficio['archivo_ruta'],
            'respuesta' => $oficio['respuesta'],
            'area_derivada' => $oficio['area_derivada_nombre'],
            'usuario_derivado' => $oficio['usuario_derivado_nombre'],
            'fecha_derivacion' => $oficio['fecha_derivacion'],
            'fecha_respuesta' => $oficio['fecha_respuesta'],
            'fecha_registro' => $oficio['fecha_registro'],
            'estado' => $oficio['estado']
        ]
    ];
    
    echo json_encode($response);
} else {
    echo json_encode(['success' => false, 'message' => 'No se encontró ningún oficio con ese número de documento']);
}

$stmt->close();
$conn->close();
?>