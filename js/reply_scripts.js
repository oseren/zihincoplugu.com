    function callCrudActionr(action, id) {
        var queryString;
        switch (action) {
            case "addr":
			
                var selector = $(id).closest(".comment-list-boxr")

                var txtmessager = selector.find(".txtmessager").val()
                var postidr = selector.find(".postidr").val()
                var postm = selector.find(".postm").val()
                var unamer = selector.find(".unamer").val()
                var uemailr = selector.find(".uemailr").val()
				
                var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                if (txtmessager.trim().length < 12) {
                    $('.errorMessager').html('<font color=\"red\">Mesaj uzunluğu 12 karakter olmalıdır.</font>').show();
                setTimeout(function(){
                    $('.errorMessager').fadeOut('slow');
                }, 3000);
                return;
                } else if (unamer.length < 3 || unamer.length > 50) {
                    $('.errorNamer').html('<font color=\"red\">İsim 3 ve 50 karakter arası olmalıdır.</font>').show();
                setTimeout(function(){
                    $('.errorNamer').fadeOut('slow');
                }, 3000);
                return;
                } else if (reg.test(uemailr) == false) {
                    $('.errorEmailr').html('<font color=\"red\">Geçersiz mail türü (username@gmail.com)</font>').show();
                setTimeout(function(){
                    $('.errorEmailr').fadeOut('slow');
                }, 3000);
                return;
                }

                queryString = 'action=' + action + '&messager=' + txtmessager + '&parentIDr=' + postidr + '&blogIDr=' +
                    postm + '&namer=' + unamer + '&emailr=' + uemailr;
					
                break;

        }
        jQuery.ajax({
            url: "admin/controller/index_comments_controller.php",
            data: queryString,
            type: "POST",
            success: function(data) {
                switch (action) {
                    case "addr":
                        //selector.append(data);
                        $(data).insertAfter(".message-wrapcm-" + postidr + ":first");
                        selector.find(".txtmessager").hide()
                        selector.find(".unamer").hide()
                        selector.find(".uemailr").hide()
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
		'<div class="row">' +
			'<div class="col-sm-6">' +
			'<div class="form-group">' +
				'<input type="text" id="unamer" placeholder="İsim" class="unamer form-control" autocomplete="off" required>' +
				'<div class="errorNamer"></div>' +
			'</div>' +
		'</div>' +
		'<div class="col-sm-6">' +
			'<div class="form-group">' +
				'<input type="email" id="uemailr" class="uemailr form-control"placeholder="Email" autocomplete="off" required>' +
				'<div class="errorEmailr"></div>' +
			'</div>' +
		'</div>' +
		'</div>' +
		'<input type="hidden" value="' + id + '" name="postidr" class="postidr">' +
			'<input type="hidden" value="' + postid + '" name="postm" class="postm">' +
			'<div class="form-group">' +
				'<textarea name="txtmessager" class="txtmessager form-control" placeholder="Yorum için cevap yazın" id="textarear" cols="auto" rows="2" autocomplete="off" required></textarea>' +
				'<div class="errorMessager"></div>' +
			'</div>' +
			'<div class="row">' +
				'<div class="col-sm-12">' +
					'<button class="btnAddActionr btn btn-primary btn-md mr-1" name="submit" onClick="callCrudActionr(\'addr\',this)">Cevap yaz</button>' +
					'<button class="btnAddActionclose btn btn-primary btn-md" name="submit" onClick="closeArea(' + id + ')">Kapat</button>' +
				'</div>' +
			'</div>' +
			'</div>');
        $('#reply_' + id).hide();
        $('#alert').remove();

    }

    function closeArea(id) {
        $('#ap_' + id).remove();
        $('#reply_' + id).show();
    }