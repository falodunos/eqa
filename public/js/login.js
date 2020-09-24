$(function(){
    
    $('button[name="sign-up-toggler"]').click(function(){
        $('body').addClass('signupisactive');
    });
    
    $('a[name="forgot-password-toggler"]').click(function(){
        $('body').addClass('forgotpasswordisactive');
    });
    
    $('a.back-button').click(function(){
        if($('body').hasClass('signupisactive')){
            $('body').removeClass('signupisactive');
        }else if($('body').hasClass('forgotpasswordisactive')){
            $('body').removeClass('forgotpasswordisactive');
        }
    });
    
});

$(document).ready(function () {
    $('#form-submit-reset-password').on('submit', function (event) {
                event.preventDefault();
                var form = $(this);
                
                var email = $('#' + this.id + ' #email');
                if (validateEmail(email.val()) === true){
                	var formData = form.serialize();
                    $.post(form.attr('action'), formData, function (response) {
                    	alert(response.message);
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