$(function(){
    var explanations = $(document).eqaModal({
                            headerTitle:"Explanation",
                            cancelButton:true,
                            cancelButtonText:"Ok, Got it",
                        });
    $('#show-answer').on('click',function(){
    	var hiddenInput = $(this).find('input[id="currentQuestionId"]')[0];
    	var value = hiddenInput.value;
        explanations.show().load('/application/question-paper/get-answer-and-explanation?questionId='+value, 3000);
    });
    var comments = $(document).eqaModal({
                            addBodyClass:"comments",
                            headerTitle:"Comments",
                            cancelButton:false,
                            customFooter:true,
                            customFooterContent:'<form class="form-inline" role="form"><div class="row"><div class="col-md-10 col-md-offset-1"><div class="input-group"><input class="form-control" type="text" placeholder="Your comments" /><span class="input-group-btn"><button class="btn btn-default"><i class="flaticon-send"></i></button></span></div></div></div></form>'
                        });
    $('#show-comments').on('click',function(){
        comments.show().load('/application/question-paper/show-question-comments',3000);
    });
});