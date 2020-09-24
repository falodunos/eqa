$(document).ready(function () {
    $('#form-submit-reset-password').on('submit', function (event) {
                event.preventDefault();
                var form = $(this);
                
                var email = $('#' + this.id + ' #email');
                if (validateEmail(email.val()) === true){
                	var formData = form.serialize();
                    $.post(form.attr('action'), formData, function (response) {
                    	alert(response.message);
//                    	if(response.status == true){
//                    		$('#password-reset-form-container').html(response.message);
//                    		return;
//                    	}else{
//                    		$('#password-reset-error-container').html(response.message);
//                    	}
                    });
                }else{
                	email.val('');
                	alert('Please enter a valid email address !');
                } 
            });

    function validateEmail(sEmail) {
        var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
        if (filter.test(sEmail)) {
            return true;
        } else {
            return false;
        }
    }
});