function askAQuestion(x) {
    var queryString;

    var selector = $(x).closest(".question-form")

    var question = selector.find("#question").val();
    var name = selector.find("#name").val();
    var email = selector.find("#email").val();

    if (question.trim().length < 12) {
        $('.errorMessage').html('<font color=\"red\">Mesaj uzunluğu 12 karakter olmalıdır.</font>').show();
        setTimeout(function () {
            $('.errorMessage').fadeOut('slow');
        }, 3000);
        return;
    }

    if (name.trim().length < 3 || name.trim().length > 50) {
        $('.errorName').html('<font color=\"red\">İsim 3 ve 50 karakter arası olmalıdır.</font>').show();
        setTimeout(function () {
            $('.errorName').fadeOut('slow');
        }, 3000);
        return;
    }

    if (!validateEmail(email)) {
        $('.errorEmail').html('<font color=\"red\">Geçersiz mail türü (username@gmail.com)</font>').show();
        setTimeout(function () {
            $('.errorEmail').fadeOut('slow');
        }, 3000);
        return;
    }
    

    queryString = 'question=' + question + '&name=' + name + '&email=' + email;

    jQuery.ajax({
        url: "admin/controller/index_question_controller.php",
        data: queryString,
        type: "POST",
        success: function (data) {
            $("#question").val('');
            $("#name").val('');
            $("#email").val('');
        },
        error: function () { }
    });
}

function validateEmail(email) {
    var regex = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i;
    return regex.test(email);
}
