'use strict'

function checkButton() {
    return validateX() & validateY() & validateR();
}

function validateX() {
    let x = $('#field_X').val().replace(',', '.');
    if (validateStr(x) || x < -5 || x > 5) {
        $('#field_X').addClass('input-invalid');
        return false;
    } else {
        $('#field_X').removeClass();
        return true;
    }

}

function validateY() {
    let y = $('#field_Y').val().replace(',', '.');
    if (validateStr(y) || y < -3 || y > 3) {
        $('#field_Y').addClass('input-invalid');
        return false;
    } else {
        $('#field_Y').removeClass();
        return true;
    }

}

function validateR() {
    let r = $('#field_R').val().replace(',', '.');
    if (validateStr(r) || r < 2 || r > 5) {
        $('#field_R').addClass('input-invalid');
        return false;
    } else {
        $('#field_R').removeClass();
        return true;
    }
}

function validateStr(str) {
    return str.trim().length === 0 || str === "-0" || isNaN(str);
}

$('#button_submit button').on("click", function (e) {
    e.preventDefault();
    if (checkButton()) {
        $('#error').css("display", "none");
        let x = $('#field_X').val().replace(',', '.');
        let y = $('#field_Y').val().replace(',', '.');
        let r = $('#field_R').val().replace(',', '.');
        $.ajax({
                url: "script.php",
                method: "POST",
                data: {
                    coordinateX: x,
                    coordinateY: y,
                    radius: r,
                    flag: "true"
                },
                statusCode: {
                    400: function () {
                        $('#error').css("display", "block");
                    },
                    200: function (data) {
                        console.log(data);
                        $('.table-data').append(data);
                    }
                }
            }
        );
    }
});

function load() {
    $.ajax({
            url: "script.php",
            method: "POST",
            data: {
                flag: "false"
            },
            success: function (data) {
                console.log(data);
                $('.table-data').append(data);
            }
        }
    );
}
