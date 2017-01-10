<link href="/scripts/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="/css/main.css" rel="stylesheet">

<script type="text/javascript" src="scripts/jquery-2.2.1.min.js"></script>  
<script type="text/javascript" src="scripts/jquery-ui.js"></script> 
<script type="text/javascript" src="scripts/jquery.jeditable.js"></script>   

<script src="scripts/bootstrap/js/bootstrap.min.js"></script>

<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
<!--[if lt IE 9]>
  <script src="scripts/html5.js"></script>
<![endif]-->

<script type="text/javascript">
    $(document).ready(function () {
        $('a[rel=tooltip]').tooltip(); // всплывающие подсказки bootstrap
        $("body").css("display", "none");// плавное затухание
        $("body").fadeIn(500);
    });


    var get = location.search; //получаем из строки GET
// поиск
    $(function () {
        $(document).ready(function () {
            if (get == "?deleted") {
                $.ajax({
                    url: "/app/contacts/search/deleteSearch.php",
                    cache: false,
                    success: function (response) {
                        $("#resSearch").html(response);
                    }
                });
                return false;
            } else {
                $.ajax({
                    url: "/app/contacts/search/ContactsSearch.php",
                    cache: false,
                    success: function (response) {
                        $("#resSearch").html(response);
                    }
                });
                return false;
            }
        });

        $("#search").keyup(function () {

            var search = $("#search").val();

            if (get == "?deleted") {
                $.ajax({
                    type: "POST",
                    url: "/app/contacts/search/deleteSearch.php",
                    data: {"search": search},
                    cache: false,
                    success: function (response) {
                        $("#resSearch").html(response);
                    }
                });
                return false;
            } else {
               /* setTimeout(function () {*/
                    $.ajax({
                        type: "POST",
                        url: "/app/contacts/search/ContactsSearch.php",
                        data: {"search": search},
                        cache: false,
                        success: function (response) {
                            $("#resSearch").html(response);
                        }
                    });
               /* }, 0);*/
                return false;

            }


        });

    });
</script>