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
                setTimeout(function () {
                    $.ajax({
                        type: "POST",
                        url: "/app/contacts/search/ContactsSearch.php",
                        data: {"search": search},
                        cache: false,
                        success: function (response) {
                            $("#resSearch").html(response);
                        }
                    });
                }, 500);
                return false;

            }


        });

    });


