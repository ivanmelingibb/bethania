<?php
/**
 * Created by PhpStorm.
 * User: HILARIWEB
 * Date: 31/1/2024
 * Time: 14:57
 */

$sql_estudiantes = "SELECT * FROM estudiantes where estado = '1' ";
$query_estudiantes = $pdo->prepare($sql_estudiantes);
$query_estudiantes->execute();
$reportes_estudiantes = $query_estudiantes->fetchAll(PDO::FETCH_ASSOC);

