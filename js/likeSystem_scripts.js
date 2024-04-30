function callLikeAction(action, id) {

    var likeTime = localStorage.getItem('likeTime' + id); // En son like zamanını al
    var currentTime = new Date().getTime(); // Şu anki zamanı al

    switch (action) {
        case "like":

        localStorage.setItem('likeTime' + id, currentTime);

            jQuery.ajax({
                url: "admin/controller/likes_controller.php",
                data: "action=" + action + "&blogID=" + id,
                type: "POST",
                success: function(data) {

                    $(".icon-heart-o").removeClass().addClass('icon-heart h1');
                    $(".like").removeClass().addClass('unlike');
                    $(".unlike").attr("onclick","callLikeAction('unlike','"+ id +"')");

                },
                error: function() {}
            });
            break;

        case "unlike":
            if (likeTime) {
                var timePassed = currentTime - likeTime;
                if (timePassed < 60000) {
                    return;
                }
            }
            
            jQuery.ajax({
                url: "admin/controller/likes_controller.php",
                data: "action=" + action + "&blogID=" + id,
                type: "POST",
                success: function(data) {
                    $(".icon-heart").removeClass().addClass('icon-heart-o h1');
                    $(".unlike").removeClass().addClass('like');
                    $(".like").attr("onclick","callLikeAction('like','"+ id +"')");

                },
                error: function() {}
            });
            break;
    }
}