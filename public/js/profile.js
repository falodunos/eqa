$(document).on('click','a[href="#upload"]',function(){
    $(this).parent().find('input[type="file"]').click();
});