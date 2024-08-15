<?php

class FileController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para subir archivos
    public function uploadFile($file) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($file["name"]);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Verificar si el archivo ya existe
        if (file_exists($targetFile)) {
            echo "El archivo ya existe.";
            $uploadOk = 0;
        }

        // Verificar el tamaño del archivo
        if ($file["size"] > 500000) {
            echo "El archivo es demasiado grande.";
            $uploadOk = 0;
        }

        // Permitir ciertos formatos de archivo
        if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg"
            && $fileType != "gif" && $fileType != "pdf") {
            echo "Solo se permiten los formatos JPG, JPEG, PNG, GIF, y PDF.";
            $uploadOk = 0;
        }

        // Intentar subir el archivo
        if ($uploadOk == 1) {
            if (move_uploaded_file($file["tmp_name"], $targetFile)) {
                // Guardar la referencia del archivo en la base de datos
                $sql = "INSERT INTO archivos (nombre, ruta) VALUES (?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("ss", $file["name"], $targetFile);
                $stmt->execute();

                echo "El archivo " . basename($file["name"]) . " ha sido subido.";
            } else {
                echo "Hubo un error al subir tu archivo.";
            }
        }
    }

    // Método para obtener todos los archivos
    public function getFiles() {
        $sql = "SELECT * FROM archivos";
        $result = $this->conn->query($sql);

        $files = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $files[] = $row;
            }
        }
        return $files;
    }
}
?>
