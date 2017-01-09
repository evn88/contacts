<!--
.ui-autocomplete-loading {
    background: white url('images/ui-anim_basic_16x16.gif') right center no-repeat;
  }
-->
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"><i class="glyphicon glyphicon-earphone"></i></a>
        </div>

        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
                        <i class="glyphicon glyphicon-wrench"></i><span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        
                        <li><a href="http://web.voenet.local/">Главное меню</a></li>
                        <li class="disabled"><a href="/?add">Админка</a></li>
                        <li class="divider"></li>
                        <li class="panel panel-body"><small>Всего контактов: <?php echo countPeople() . ' | Справочник открыли ' . page_referesh() . 'раз(а)'; ?></small></li>
                    </ul>
                </li>
                
            </ul>
            

            <form class="navbar-form ng-pristine ng-valid" role="search">
                <div class="form-group" style="display:inline;">
                    <div class="input-group" style="display:table;">
                        <span class="input-group-addon" style="width:1%;">
                            <i class="glyphicon glyphicon-search"></i>
                        </span>
                        <input class="form-control ng-pristine ng-valid ng-empty ng-touched" id="search" role="search" name="search" placeholder="Поиск" autocomplete="off" autofocus="autofocus" type="text" ng-model="query">
                    </div>
                </div>
            </form>

        </div><!--/.nav-collapse -->
    </div>
</div>


<div class="container">

    <div class="row">
        <div class="span12">
            <?php
            // controller

            if (isset($_GET['add']))
                require_once ('add/addPeople.php');
            else if (isset($_GET['import']))
                require_once ('add/importPeople.php');
            else
                echo '<div id="resSearch"></div><!--search-->';
            ?>

        </div> <!--span12-->
    </div> <!--row-fluid-->

</div>



