<!-- file_list.php -->
<h2>Archivos Subidos</h2>
<?php
if (!empty($files)) {
    foreach ($files as $file) {
        echo '<div>';
        echo '<a href="uploads/' . htmlspecialchars($file['nombre']) . '" download>' . htmlspecialchars($file['nombre']) . '</a>';
        echo '</div>';
    }
} else {
    echo 'No hay archivos disponibles.';
}
?>
