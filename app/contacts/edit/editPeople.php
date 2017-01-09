<?php

include "../../../config.php";

$ip = ip2long($_SERVER["REMOTE_ADDR"]);
$cid = explode(":", $_POST['id']); //делим название столбца и идентификатора
$id = $cid[1];
$column = $cid[0];
$value = htmlspecialchars($_POST['value']);

//if (accessIp()) {
    if ($column == "fio") {
        $value = trim($value); //убираем пробелы вначале и конце
        $val = explode(" ", $value);

        $lastname = $val[0];
        $name = $val[1];
        $secondname = $val[2];

        $mysqli->query("UPDATE `contacts`.`people` SET `lastname` = '$lastname', `name` = '$name', `secondname` = '$secondname' WHERE `people`.`id` = $id");
        $mysqli->query("INSERT INTO `contacts`.`logs` (`id`, `ip_user`, `action_date`, `action`) VALUES (NULL, '$ip', CURRENT_TIMESTAMP, 'upd:peopleID=$id; column=$column; value=$value;')");
        $mysqli->close();

        echo $value;
    }

    if ($cid[0] and $cid[1] !== '0' and $value and $column !== "fio") {

        $mysqli->query("UPDATE `contacts`.`people` SET `$column` = '$value' WHERE `people`.`id` = $id");
        $mysqli->query("INSERT INTO `contacts`.`logs` (`id`, `ip_user`, `action_date`, `action`) VALUES (NULL, '$ip', CURRENT_TIMESTAMP, 'upd:peopleID=$id; column=$column; value=$value;')");
        $mysqli->close();

        echo $value;
    }
/*} else {
    echo '<span style="color:red;"><b>Вам запрещено редактировать</b></span>';
}*/
?>