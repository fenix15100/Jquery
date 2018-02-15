var names;
var names_x_page = 10;
var page = 0;
var gender;
var likeshidden = [];
var dislikeshidden = [];

$(function () {
    setOnChecked();
    setOnClick();
});

function setOnChecked() {
    $(".radiobtn").each(function () {
        $(this).click(function () {
            if ($(this).prop("checked") == true) {
                $.post('index.php', 'hidden=get', function (data) {
                    array = $.parseJSON(data);
                    likeshidden = array[0];
                    dislikeshidden = array[1];
                });
                gender = $(this).val();
                fillTable();
            }
        });
    });
}

function setOnClick() {
    $("#btnNext").click(function () {
        page++;
        fillTable();
    });
    $("#btnPrevious").click(function () {
        page--;
        fillTable();
    });
}

function fillTable() {
    $.post('index.php', 'gender=' + gender, function (data) {
        names = $.parseJSON(data);
        $("#list").html("");
        $("#list").append('<tr><th>Name</th><th>Likes</th><th>Dislikes</th></tr>');
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
                $.post('index.php', 'likes=' + name);
            });
        });

        $(".dislike").each(function () {
            $(this).click(function () {
                var name = $(this).closest('tr').children('td.name').text();
                $.post('index.php', 'gender=' + $(this).val() + '&dislike=' + name, function (data) {
                    fillTable();
                });
                dislikeshidden.push(name);
                $.post('index.php', 'dislikes=' + name);
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



