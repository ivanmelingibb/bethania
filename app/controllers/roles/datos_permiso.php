<?php
/**
 * Created by PhpStorm.
 * User: HILARIWEB
 * Date: 29/1/2024
 * Time: 08:40
 */

$sql_permisos = "SELECT * FROM permisos where estado = '1' AND id_permiso = '$id_permiso' ";
$query_permisos = $pdo->prepare($sql_permisos);
$query_permisos->execute();
$permisos = $query_permisos->fetchAll(PDO::FETCH_ASSOC);

foreach ($permisos as $permiso){
    $nombre_url = $permiso['nombre_url'];
    $url = $permiso['url'];
}