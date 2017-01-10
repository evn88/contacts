<?php 
echo 'import';

if ($_POST){


	/*echo '<pre>';
	print_r (preg_split("/[\n,]+/", $_POST['value']));
	echo '</pre>';*/
	$filial = $_POST['filial'];
	$departament = $_POST['departament'];

	$val = preg_split("/[\n,]+/", $_POST['value']);
	$count = count($val);
	foreach ($val as $key => $value) {
		$count--;

		$result = explode(";", $value);
		$result['FullName'] = explode(" ", $result[1]);

		$lastname = $result['FullName'][0];
		$name = $result['FullName'][1];
		$secondname = $result['FullName'][2];
		$job_title = $result[0];
		$internal_phone = '0';
		$external_phone = $result[2];
		$speed_dial = $result[3];

		$mysqli->query (
			"INSERT INTO `contacts`.`people` (`id`, `fid`, `did`, `oid`, `lastname`, `name`, `secondname`, `job_title`, `internal_phone`, `external_phone`, `speed_dial`, `email`, `order`) 
			 VALUES (NULL, '$filial', '$departament', '0', '$lastname', '$name', '$secondname', '$job_title', '$internal_phone', '$external_phone', '$speed_dial', NULL, '$count');");

		echo '<pre>';
		print_r ($result);
		echo '</pre>';
	}
}

?>

<form name="import" method="post" action="" class="form-horizontal">

<label class="control-label">Филиал</label>
<div class="controls">
    <select id="filial" name="filial" class="input-xlarge">
      <option value="0">---</option>
      <?php
      global $mysqli;
      $query = $mysqli->query ("SELECT id,name FROM filials ORDER BY id DESC");
      while ($row = $query->fetch_assoc()){
        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
      }
      ?>
    </select>
</div>


<label class="control-label">Департамент</label>
<div class="controls">
    <select id="departament" name="departament" class="input-xlarge">
      <option value="0">---</option>
      <?php
      $query = $mysqli->query ("SELECT id,name FROM departament");
      while ($row = $query->fetch_assoc()){
        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
      }
      ?>
    </select>
</div>

<div class="control-group">
	<div class="controls">
    	<textarea rows="30" name="value" class="span10"></textarea>
	</div>
	<div class="controls">
    	<button type="submit" name="go" class="btn btn-large btn-primary span10">Импортировать</button>
	</div>
</div>
</form>