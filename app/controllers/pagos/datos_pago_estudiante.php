<?php
/**
 * Created by PhpStorm.
 * User: HILARIWEB
 * Date: 22/1/2024
 * Time: 09:01
 */

$sql_pagos = "SELECT * FROM pagos where estado = '1' and estudiante_id = '$id_estudiante' ";
$query_pagos = $pdo->prepare($sql_pagos);
$query_pagos->execute();
$pagos = $query_pagos->fetchAll(PDO::FETCH_ASSOC);