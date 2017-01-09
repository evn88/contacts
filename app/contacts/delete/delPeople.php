<?php
include "../../../config.php";
$ip = ip2long($_SERVER["REMOTE_ADDR"]);

$idPeople = (int)$_GET['idPeople'];
$mysqli->query("UPDATE `contacts`.`people` SET `hide` = '1' WHERE `people`.`id` = $idPeople"); //скрываем контакт
$mysqli->query("UPDATE `contacts`.`people` SET `ipDel` = $ip WHERE `people`.`id` = $idPeople"); //ставим ip того кто скрыл контакт

//echo 'ok' . $idPeople;

// восстановление выключеных контактов
$idPeopleUndelete = (int)$_GET['idPeopleUndelete']; 
$mysqli->query("UPDATE `contacts`.`people` SET `hide` = '0' WHERE `people`.`id` = $idPeopleUndelete"); //скрываем контакт
$mysqli->query("UPDATE `contacts`.`people` SET `ipDel` = $ip WHERE `people`.`id` = $idPeopleUndelete"); //ставим ip того кто скрыл контакт
$mysqli->close();