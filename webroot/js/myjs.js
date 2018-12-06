
$(document).ready(function(){
    $('#pass').keyup(function(e) {
        var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
        var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
        var enoughRegex = new RegExp("(?=.{6,}).*", "g");
        if (false == enoughRegex.test($(this).val())) {
            $('#passstrength').attr('class','');
            $('#passstrength').html('More Characters');
        } else if (strongRegex.test($(this).val())) {

            $('#passstrength').attr('class','progress-bar progress-bar-success');
            $('#passstrength').attr('role','progress-bar');
            $('#passstrength').attr('aria-valuenow','40');
            $('#passstrength').attr('aria-valuemin','0');
            $('#passstrength').attr('aria-valuemax','100');
            $('#passstrength').attr('style','width: 100%;');
            $('#passstrength').html('Strong!');
        } else if (mediumRegex.test($(this).val())) {
            $('#passstrength').attr('class','progress-bar progress-bar-warning');
            $('#passstrength').attr('role','progress-bar');
            $('#passstrength').attr('aria-valuenow','40');
            $('#passstrength').attr('aria-valuemin','0');
            $('#passstrength').attr('aria-valuemax','100');
            $('#passstrength').attr('style','width: 60%;');
            $('#passstrength').html('Medium!');
        } else {
            $('#passstrength').attr('class','progress-bar progress-bar-danger');
            $('#passstrength').attr('role','progress-bar');
            $('#passstrength').attr('aria-valuenow','20');
            $('#passstrength').attr('aria-valuemin','0');
            $('#passstrength').attr('aria-valuemax','100');
            $('#passstrength').attr('style','width: 40%;');
            $('#passstrength').html('Weak!');
        }
        return true;
    });
});
