    function callCrudAction(action, id) {
        var queryString;
        switch (action) {
            case "add":
                
                var selector = $(id).closest(".comment-list-box")
                
                var txtmessage = selector.find("#message").val();
                var postid = selector.find(".blogID").val();
                var uname = selector.find("#name").val();
                var uemail = selector.find("#email").val();
				
				if (txtmessage.trim().length < 12) {
                    $('.errorMessage').html('<font color=\"red\">Mesaj uzunluğu 12 karakter olmalıdır.</font>').show();
                setTimeout(function(){
                    $('.errorMessage').fadeOut('slow');
                }, 3000);
                return;
                } 
				
                queryString = 'action=' + action + '&message=' + txtmessage + '&blogID=' + postid + '&name=' +
                    uname + '&email=' + uemail;

                break;
        }
        jQuery.ajax({
            url: "admin/controller/index_comments_controller.php",
            data: queryString,
            type: "POST",
            success: function(data) {
                switch (action) {
                    case "add":
                        $(data).insertAfter(".comment-form-wrap");
                        break;
                }
                $("#message").val('');
                $("#name").val('');
                $("#email").val('');
            },
            error: function() {}
        });
    }
    $(document).ready(function() {
        $(".add_new_comment").click(function() {
            $(".new_comment_area").show();
            $('#alert').remove();
        });
    });