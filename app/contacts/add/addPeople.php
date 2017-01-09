    <div class="container-fluid" style="padding-top: 50px;">
        <h2>Добавить контакт</h2>
    </div>
<?php
if ($_POST)
{
    foreach ($_POST as $key => $value)
    {
        //if (!$value) { $error[] = 'пустое поле:'. $key.'<br>'; unset($error['save']);}
        //$row[$key] = htmlspecialchars(strip_tags($value));
        if ($value == '')
        {
            $value = '0';
        }
        $row[$key] = htmlspecialchars($value);
    }
    if ($row['filial'] == '' or $row['filial'] == 0)
    {
        $error[] = 'Обязательно надо выбрать филиал';
    }
    if ($row['lastname'] == '')
    {
        $error[] = 'Нужно заполнить поле Фамилия';
    }
    if ($row['name'] == '')
    {
        $error[] = 'Нужно заполнить поле Имя';
    }
    if ($row['secondname'] == '')
    {
        $error[] = 'Нужно заполнить поле Отчество';
    }
    if ($row['job_title'] == '')
    {
        $error[] = 'Нужно заполнить поле Должность';
    }
    //if ($row['external_phone']=='') { $error[] = 'Нужно ввести номер городского телефона'; }
    //if (is_numeric($row['internal_phone'])) { $error[] = 'Внутренний телефон должен содержать только цифры'; }
//print_r($row);
//echo count($error);
    if (count($error) == 0)
    { // если нет ошибок добавляем
        if ($row['internal_phone'] == "")
        {
            $row['internal_phone'] = 0;
        } //временный костыль
        $ok = $mysqli->query("INSERT INTO `contacts`.`people` (`id`, `fid`, `did`, `oid`, `lastname`, `name`, `secondname`, `job_title`, `internal_phone`, `external_phone`, `speed_dial`, `email`,`order`) 
                   VALUES (NULL, 
                    '" . $row['filial'] . "', 
                    '" . $row['departament'] . "', 
                    '" . $row['otdel'] . "', 
                    '" . $row['lastname'] . "', 
                    '" . $row['name'] . "', 
                    '" . $row['secondname'] . "', 
                    '" . $row['job_title'] . "', 
                    '" . $row['internal_phone'] . "', 
                    '" . $row['external_phone'] . "', 
                    '" . $row['speed_dial'] . "', 
                    '" . $row['email'] . "',
                    '0'
                    )") or die($mysqli->error);
        if ($ok)
        {
            echo '
      <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4>Контакт добавлен</h4>
      </div>';
        }
    }
    else
    { // иначе выводим их
        foreach ($error as $key => $value)
        {
            echo '
      <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4>Ошибка!</h4>
        ' . $value . '
      </div>';
        }
    }
}

if (accessIp())
{  //проверяем права доступа 
    ?>



    <form method="post" enctype="multipart/form-data" class="form form-horizontal">
        <div class="col-sm-6">

            <div class="form-group">
                <label class="col-sm-2 control-label">Фамилия</label>
                <div class="col-sm-10">
                    <input type="text" name="lastname" class="form-control" placeholder="Фамилия">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Имя</label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" placeholder="Имя">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Отчество</label>
                <div class="col-sm-10">
                    <input type="text" name="secondname" class="form-control" placeholder="Отчество">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Должность</label>
                <div class="col-sm-10">
                    <input type="text" name="job_title" class="form-control" placeholder="Должность" autocomplete="">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Внутренний телефон</label>
                <div class="col-sm-10">
                    <input type="text" name="internal_phone" class="form-control" placeholder="Внутренний телефон">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Городской телефон</label>
                <div class="col-sm-10">
                    <input type="text" name="external_phone" class="form-control" placeholder="Городской телефон">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Быстрый набор</label>
                <div class="col-sm-10">
                    <input type="text" name="speed_dial" class="form-control" placeholder="Быстрый набор">
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <!-- Select Basic -->
            <div class="form-group">
                <label class="control-label">Филиал</label>
                <div class="controls">
                    <select id="filial" name="filial" class="form-control input-xlarge">
                        <option value="0">---</option>
                        <?php
                        global $mysqli;
                        $query = $mysqli->query("SELECT id,name FROM filials ORDER BY `order` DESC");
                        while ($row = $query->fetch_assoc())
                        {
                            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                        }
                        ?>
                    </select>

                </div>
            </div>

            <!-- Select Basic -->
            <div class="form-group">
                <label class="control-label">Главная группа</label>
                <div class="controls">
                    <select id="departament" name="departament" class="form-control input-xlarge">
                        <option value="0">---</option>
                        <?php
                        $query = $mysqli->query("SELECT id,name FROM departament");
                        while ($row = $query->fetch_assoc())
                        {
                            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                        }
                        ?>
                    </select>

                </div>
            </div>

            <!-- Select Basic -->
            <div class="form-group">
                <label class="control-label">Дополнительная группа</label>
                <div class="controls">
                    <select id="otdel" name="otdel" class="form-control input-xlarge">
                        <option value="0">---</option>
                        <?php
                        $query = $mysqli->query("SELECT id,name FROM otdel");
                        while ($row = $query->fetch_assoc())
                        {
                            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                        }
                        ?>
                    </select>

                </div>
            </div>
        </div> <!-- col-sm-6 -->
        <div class="col-sm-12">
            <!-- Button -->
            <div class="form-group">
                <label class="control-label"></label>
                <div class="controls">
                    <button id="save" name="save" class="btn btn-primary">Добавить контакт</button>
                </div>
            </div>
            <a href="?deleted">Посмотреть/восстановить контакты которые были удалены</a>
        </div>
    </form>

    <?php
}
else
{
    echo '<div class="alert alert-danger" role="alert">У вас нет доступа к этому разделу</div>';
}
?>