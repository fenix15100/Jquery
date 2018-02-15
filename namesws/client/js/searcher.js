var names;
var gender;

$(function () {
    setOnChecked();
    setOnKeyUp();
});

function setOnChecked() {
    $(".radiobtn").each(function () {
        $(this).click(function () {
            $("#inNames").css("display", "inline-block");
            $("#names").css("display", "inline");
            if ($(this).prop("checked") == true) {
                gender = $(this).val();
            }
        });
    });
}

function setOnKeyUp() {
    $("#inNames").keyup(function () {
        suggestNames($(this).val());
    });
}

function suggestNames(string) {
    if (string != "") {
        $.post('index.php', 'gender=' + gender + '&string=' + string, function (data) {
            if (data != "Error") {
                names = $.parseJSON(data);
                var text = "Suggestions: ";
                for (i = 0; i < names.length; i++) {
                    if (i == 0)
                        text += names[i];
                    else
                        text += ", " + names[i];
                }
                $("#names").html(text);
            }
            else
                $("#names").html("No suggestions");
        });
    }
    else
        $("#names").html("");
}

function fillTable() {
    $.post('index.php', 'gender=' + gender, function (data) {
        names = $.parseJSON(data);
        $("#list").html("");
        $("#list").append("<tr><th>Name</th><th>Likes</th><th>Dislikes</th></tr>");
        var max = 0;
        if (names.length > ((names_x_page * page) + names_x_page)) {
            max = (names_x_page * page) + names_x_page;
            $("#btnNext").css("display", "inline-block");
        }
        else {
            max = names.length;
            $("#btnNext").css("display", "none");
        }
        if (page > 0)
            $("#btnPrevious").css("display", "inline-block");
        else
            $("#btnPrevious").css("display", "none");

        for (i = (page * names_x_page); i < max; i++) {
            var td = '<tr><td class="name">' + names[i][0] + '</td><td class="lk">' + names[i][1] + '</td><td class="dlk">' + names[i][2] + '</td><td><button class="like" ';
            if (isInArray(names[i][0], likeshidden))
                td += 'style="display:none"';
            td += '>Like</button></td><td><button class="dislike" ';
            if (isInArray(names[i][0], dislikeshidden))
                td += 'style="display:none"';
            td += '>Disike</button></td></tr>';
            $("#list").append(td);
        }

        $(".like").each(function () {
            $(this).click(function () {
                var name = $(this).closest('tr').children('td.name').text();
                $.post('index.php', 'gender=' + $(this).val() + '&like=' + name, function (data) {
                    fillTable();
                });
                likeshidden.push(name);
            });
        });

        $(".dislike").each(function () {
            $(this).click(function () {
                var name = $(this).closest('tr').children('td.name').text();
                $.post('index.php', 'gender=' + $(this).val() + '&dislike=' + name, function (data) {
                    fillTable();
                });
                dislikeshidden.push(name);
            });
        });
    });

    function isInArray(string, array) {
        array = array || [];
        for (j = 0; j < array.length; j++)
            if (string == array[j])
                return true;
        return false;
    }
}



