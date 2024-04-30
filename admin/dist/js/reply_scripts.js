    function callCrudActionr(action, id) {
        var queryString;
        switch (action) {
            case "adminaddr":
			
                var selector = $(id).closest(".comment-list-boxr")
                var txtmessager = selector.find(".txtmessager").val()
                var postidr = selector.find(".postidr").val()
                var postm = selector.find(".postm").val()
                var unamer = document.getElementById("username").value;
                var uemailr = document.getElementById("email").value;

				
                var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                if (txtmessager.trim().length < 12) {
                    $('.errorMessager').html('<font color=\"red\">Mesaj uzunluğu 12 karakter olmalıdır.</font>').show();
                setTimeout(function(){
                    $('.errorMessager').fadeOut('slow');
                }, 3000);
                return;
                }

                queryString = 'action=' + action + '&messager=' + txtmessager + '&parentIDr=' + postidr + '&blogIDr=' +
                    postm + '&namer=' + unamer + '&emailr=' + uemailr;
					
                break;

        }
        jQuery.ajax({
            url: "controller/index_comments_controller.php",
            data: queryString,
            type: "POST",
            success: function(data) {
                switch (action) {
                    case "adminaddr":
                        //selector.append(data);
                        $(data).insertAfter(".message-wrapcm-" + postidr + ":first");
                        selector.find(".txtmessager").hide()
                        selector.find(".btnAddActionr").hide()
                        selector.find(".btnAddActionclose").hide()
                        selector.find(".add_comment").show();
                        selector.find(".ap").remove();

                        break;
                }
                $(".txtmessager").val('');
            },
            error: function() {}
        });
    }
    
    function reply_form(id, postid) {
        $('#reply_area_' + id).append('<div class="ap" id="ap_' + id +'">' +
		'<input type="hidden" value="' + id + '" name="postidr" class="postidr">' +
			'<input type="hidden" value="' + postid + '" name="postm" class="postm">' +
			'<div class="form-group">' +
				'<textarea name="txtmessager" class="txtmessager form-control" placeholder="Yorum için cevap yazın" id="textarear" cols="auto" rows="2" required></textarea>' +
				'<div class="errorMessager"></div>' +
			'</div>' +
			'<div class="row">' +
				'<div class="col-sm-12">' +
					'<p>' +
					'<button class="btnAddActionr btn bg-gradient-success btn-sm mr-1" name="submit" onClick="callCrudActionr(\'adminaddr\',this)">Cevap yaz</button>' +
					'<button class="btnAddActionclose btn btn-danger btn-sm" name="submit" onClick="closeArea(' + id + ')">Kapat</button>' +
					'</p>' +
				'</div>' +
			'</div>' +
			'</div>');
        $('#reply_' + id).hide();
		$('#delete_' + id).hide();
		$('#confirm_' + id).hide();

    }

    function closeArea(id) {
        $('#ap_' + id).remove();
        $('#reply_' + id).show();
		$('#delete_' + id).show();
		$('#confirm_' + id).show();
    }