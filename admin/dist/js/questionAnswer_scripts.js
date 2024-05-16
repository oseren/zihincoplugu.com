function questionAnswer(action, id) {
    var queryString;
    switch (action) {
        case "answer":
        
            var selector = $(id).closest(".answer-box")
            var answerText = selector.find(".answerText").val()
            var questionID = selector.find(".questionID").val()

            if (answerText.trim().length < 12) {
                $('.errorMessager').html('<font color=\"red\">Mesaj uzunluğu 12 karakter olmalıdır.</font>').show();
            setTimeout(function(){
                $('.errorMessager').fadeOut('slow');
            }, 3000);
            return;
            }

            queryString = 'islem=' + action + '&answer=' + answerText + '&questionID=' + questionID;
                
            break;

    }
    jQuery.ajax({
        url: "controller/question_controller.php",
        data: queryString,
        type: "POST",
        success: function(data) {
            switch (action) {
                case "answer":
                    
                    $(data).insertAfter(".message-wrapcm-" + questionID + ":first");
                    selector.find(".answerText").hide()
                    selector.find(".btnAddActionr").hide()
                    selector.find(".btnAddActionclose").hide()
                    selector.find(".ap").remove();

                    break;
            }
            $(".answerText").val('');
        },
        error: function() {}
    });
}

function answer_form(id) {
    $('#answer_area_' + id).append('<div class="ap" id="ap_' + id +'">' +
    '<input type="hidden" value="' + id + '" name="questionID" class="questionID">' +
        '<div class="form-group">' +
            '<textarea name="answerText" class="answerText form-control" placeholder="Sorulan soru için cevap yazın" id="textarear" cols="1000" rows="2" required></textarea>' +
            '<div class="errorMessager"></div>' +
        '</div>' +
        '<div class="row">' +
            '<div class="col-sm-12">' +
                '<p>' +
                '<button class="btnAddActionr btn bg-gradient-success btn-sm mr-1" name="submit" onClick="questionAnswer(\'answer\',this)">Cevap yaz</button>' +
                '<button class="btnAddActionclose btn btn-danger btn-sm" name="submit" onClick="closeArea(' + id + ')">Kapat</button>' +
                '</p>' +
            '</div>' +
        '</div>' +
        '</div>');
    $('#answer_' + id).hide();
    $('#delete_' + id).hide();

}

function closeArea(id) {
    $('#ap_' + id).remove();
    $('#answer_' + id).show();
    $('#delete_' + id).show();
}