<?php
/*
 * Груповое удаление контактов. Удаляя отдел/департамент удаляются и все контакты относящиеся к этому отделу/департаменту.
 */
include "../../../config.php";

$idGroupDep = (int)$_GET['delGroupDep']; //департамент
$idGroupOtd = (int)$_GET['delGroupOtd']; //отдел

if ($idGroupDep) $query = 'DELETE `departament`, `people` FROM `departament`, `people` WHERE `departament`.`id`= $idGroupDep and `departament`.`id`= `people`.`did`';
if ($idGroupOtd) $query = 'DELETE `otdel`, `people` FROM `otdel`, `people` WHERE `otdel`.`id`= $idGroupOtd and `otdel`.`id`= `people`.`oid`';

if ($query) $mysqli->query($query);
