<?php

require_once "../../../config.php";

$query = @$_POST['search'];
$query = $mysqli->real_escape_string($query);
$query = htmlspecialchars($query);
$query = stripslashes($query);
$query = switcher($query);


//$query = str_replace(" ","%", $query);

if ($query !== '') {
    //поиск
    $search = $mysqli->query("
		SELECT *,
		(SELECT `name` FROM `filials` WHERE `people`.`fid`=`filials`.`id`) as `filial`,
		(SELECT `order` FROM `filials` WHERE `people`.`fid`=`filials`.`id`) as `order_filial`,
		(SELECT `address` FROM `filials` WHERE `people`.`fid`=`filials`.`id`) as `address`,
		(SELECT `name` FROM `departament` WHERE `people`.`did`=`departament`.`id`) as `departament`,
		(SELECT `name` FROM `otdel` WHERE `people`.`oid`=`otdel`.`id`) as `otdel`

		FROM `people`
		WHERE 
                `people`.`lastname` LIKE '$query%' AND `people`.`hide` = 0 
		OR  `people`.`name` LIKE  '$query%' AND `people`.`hide` = 0 
		OR  `people`.`secondname` LIKE  '$query%' AND `people`.`hide` = 0 
		OR  `people`.`job_title` LIKE '%$query%' AND `people`.`hide` = 0 
		OR  `people`.`internal_phone` LIKE '%$query%' AND `people`.`hide` = 0 
		OR  `people`.`external_phone` LIKE '%$query%' AND `people`.`hide` = 0 
                
		ORDER BY `order_filial` DESC, `filial`, `departament`, `otdel`, `order` DESC, `hide`, `lastname`
	");
} else {
    //выводим всех
    $search = $mysqli->query("
	SELECT *, 
		(SELECT `name` FROM `filials` WHERE `people`.`fid`=`filials`.`id`) as `filial`,
		(SELECT `order` FROM `filials` WHERE `people`.`fid`=`filials`.`id`) as `filial_order`,
		(SELECT `address` FROM `filials` WHERE `people`.`fid`=`filials`.`id`) as `address`,
		(SELECT `name` FROM `departament` WHERE `people`.`did`=`departament`.`id`) as `departament`,
		(SELECT `order` FROM `departament` WHERE `people`.`did`=`departament`.`id`) as `departament_order`,
		(SELECT `name` FROM `otdel` WHERE `people`.`oid`=`otdel`.`id`) as `otdel`
		

		FROM `people`
                WHERE `people`.`hide` = 0

		ORDER BY `filial_order` DESC, `filial`, `departament_order`, `departament`, `order` DESC, `otdel` DESC, `lastname`
	");
}


echo '
<table width="100%" class="table table-hover table-condensed table-bordered">
            <thead>
              <tr>
              	<th width="50px" style="text-align:center;"></th>
                <th width="40%" nowrap style="text-align:center">ФИО</th>
                <th width="27%" style="text-align:center">Должность</th>
                <th width="10%" style="text-align:center">Внутренний телефон</th>
                <th width="10%" style="text-align:center">Городской телефон</th>
                <th width="10%" style="text-align:center">Быстрый набор</th>
              </tr>
            </thead>

            <tbody>
	';

while ($row = $search->fetch_assoc()) {

    if (@$lostfilial !== $row['filial']) {
        echo '
                <tr>
                        <th colspan="6" bgcolor="#E6E6E6" align="left" class="bg-primary"><i class="glyphicon glyphicon-home"></i> <strong>' . $row['filial'] . '</strong> <span class="pull-right"><small class="">' . $row['address'] . '</small></span></th>
                </tr>
			';
        $lostfilial = $row['filial'];
    }

    if (@$lostDepartament !== $row['departament']) {
        if ($row['departament'])
            echo'
                <tr>
                        <th colspan="6" bgcolor="#EEEEEE" style="text-align:center" class="">' . $row['departament'] . '</th>
                </tr>';
        $lostDepartament = $row['departament'];
    }

    if (@$lostOtdel !== $row['otdel']) {
        if ($row['otdel'])
            echo'
                <tr>
                        <th colspan="6" bgcolor="#F5F5F5" style="text-align:center" class="muted"><em>' . $row['otdel'] . '</em></th>
                </tr>';
        $lostOtdel = $row['otdel'];
    }

    if ($row['email']) {
        $mail = '<a href="mailto:' . $row['email'] . '" rel="tooltip" data-placement="right" data-original-title="e-mail: ' . $row['email'] . '" class="btn btn-mini" ><i class="icon-envelope"></i></a>';
    } else {
        unset($mail);
    }
    if ($row['internal_phone'] == "0") {
        $row['internal_phone'] = "-/-";
    }
    if ($row['external_phone'] == 0) {
        $row['external_phone'] = "-/-";
    }
    if ($row['speed_dial'] == "0") {
        $row['speed_dial'] = "-/-";
    }

    echo '	
        <tr onmouseover="showDel(' . $row['id'] . ');" onmouseout="hideDel(' . $row['id'] . ');">
                <td valign="top" height="35px"; style="text-align:center; ">'.delButton($row['id']).'</td>
                <td class="editable" nowrap id="fio:' . $row['id'] . '" >' . trim($row['lastname'] . ' ' . $row['name'] . ' ' . $row['secondname']) . '</td>
                <td class="editable" id="job_title:' . $row['id'] . '">' . $row['job_title'] . '</td>
                <td class="editable" id="internal_phone:' . $row['id'] . '" style="text-align:center">' . $row['internal_phone'] . '</td>
                <td class="editable" id="external_phone:' . $row['id'] . '"style="text-align:center">' . $row['external_phone'] . '</td>
                <td class="editable" id="speed_dial:' . $row['id'] . '"style="text-align:center">' . $row['speed_dial'] . '</td>
        </tr>
    ';
} //end while

echo '
	</tbody>
	</table>';

$mysqli->close();

function delButton($id){
    if (accessIp()){
        return '<a href="#" onclick="delClik(' . $id . ');" id="delPeople' . $id . '" class="delPeople btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a>';
    }
}
?>
<script>
    <?php 
    if (accessIp()){
    ?>
    //редактируем контакт
    $(".editable").editable("/app/contacts/edit/editPeople.php",
            {
                type: 'textarea',
                event: 'dblclick',
                height: '50px',
                cancel: 'Cancel',
                submit: 'OK',
                indicator: '<img src="http://contacts.web.voenet.local/ico/loading.gif"  width="32" align="center">',
                tooltip: "Двойной клик для редактирования"
            }
    );
    <?php } ?>

    /*
     * удаление контактов
     */
    var id = 0;
    $('.delPeople').hide();
    function showDel(id) {
        $('#delPeople' + id).show();
    }
    function hideDel(id) {
        $('#delPeople' + id).hide();
    }
    function delClik(id) {
        if (confirm("Удалить контакт?")) {
            $.get('app/contacts/delete/delPeople.php?idPeople='+id, function(data){
                $.get('/app/contacts/search/ContactsSearch.php', function(data){
                    $("#resSearch").html(data);
                });
            });
            console.log('hide='+id);
        }
    }
    /*
     * КОНЕЦ_удаление контактов
     */
</script>