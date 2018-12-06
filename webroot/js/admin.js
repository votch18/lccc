function confirmDelete(str){
	var msg = str == "" ? "Delete?" : str;
    if ( confirm(msg)){
        return true;
    }else {
        return false;
    }
}

function confirmPayment(str){
   var msg = str == "" ? "Paid?" : str;
    if ( confirm(msg)){
        return true;
    }else {
        return false;
    }
}





//jquery upload
/*
$(document).ready(function(){

    var err = $('.err-msg');
    setTimeout(hideMsg, 20000);

    function hideMsg(){
        err.css("visibility", "hidden");
    }

    $('#file').on('change', function (e) {

        $.each(e.originalEvent.srcElement.files, function(i, file) {

            var img = $("<img class='upload_img'></div>");
            var con = $("<div class='con'></div>");
            var img_con = $("<div class='img_con'></div>");
            var detail = $("<div class='detail'></div>");
            var progress_bar = $("<div class='progress'>" +
            "<div class='progress-bar' role='progressbar' aria-valuenow='70'" +
            "aria-valuemin='0' aria-valuemax='100'>" +
            "<span class='sr-only'>0% Complete</span></div></div>");

            var txt = $("<h4></h4>");

            img.id = "image"+(i+1);
            var reader = new FileReader();
            reader.onloadend = function () {
                //img.src = reader.result;
                $(img).attr('src', reader.result);
                $(img).attr('class', 'upload_preview');
            }
            reader.readAsDataURL(file);

            txt.text(file.name);
            $("#image"+i).after(img);
            detail.append(txt);
            detail.append(progress_bar);
            img_con.append(img);
            con.append(img_con);
            con.append(detail);
            $('#preview').append(con);
        });

    });

    function readFile(input){
        for (var i = 0; i < input.files.length; i++)
        {
            alert(input.files[i].name);
            var img = $("<img id='img"+i+"'/>");
            if (input.files) {
                var reader = new FileReader();

                reader.onload = function (e) {

                }

                reader.readAsDataURL(input.files[i]);
            }

            $('#preview').after(img)

        }
    }

});
*/

$(document).ready(function(){

    var err = $('.err-msg');
    setTimeout(hideMsg, 20000);

    function hideMsg(){
        err.css("visibility", "hidden");
    }

    $('#file').on('change', function (e) {

        $.each(e.originalEvent.srcElement.files, function(i, file) {

            var img = $("<img id='user_img'>");
             var reader = new FileReader();

            reader.onloadend = function () {
                $(img).attr('src', reader.result);
                img_source = reader.result;
            }
            reader.readAsDataURL(file);
            $("#user_img").after(img);
            $("#preview").append(img);
        });
    });

    function readFile(input){
        for (var i = 0; i < input.files.length; i++)
        {
            alert(input.files[i].name);
            var img = $("<img id='img"+i+"'/>");
            if (input.files) {
                var reader = new FileReader();

                reader.onload = function (e) {

                }

                reader.readAsDataURL(input.files[i]);
            }

            $('#preview').after(img)

        }
    }

});