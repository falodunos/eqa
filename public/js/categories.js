$(function(){
    $('#menu-bar').click(function(){
        if($('.body-holder').hasClass('sidebar-is-visible')){
            $('.body-holder').removeClass('sidebar-is-visible');
        }else{
            $('.body-holder').addClass('sidebar-is-visible');
        }
        if($('#searchbar').hasClass('collapse in')){
            $('#searchbar').removeClass('in');
        }
    });

    $('[data-category]').click(function(event){
    	var selected = $(event.target).closest('.thumbnail');
    	var subjectId = selected[0].id.split('-')[1];
    	
        $(document).eqaModal({
            headerTitle:"Choose your exam type",
			cancelButton:true,
			cancelButtonText:"Cancel",
			applyButton:true,
            applyButtonText:"Next",
			applyCallback:function(){
            	$selectedExam = $('div.modal-body label.btn.btn-outline.active input[type="radio"]')[0];
            	$selectedExamId = $selectedExam.id.split('-')[1];
                $('.custom-modal').modal('hide');
                showExamYear($selectedExamId);
            },
        }).show().load('/application/question-paper/get-exams-offering-this-subject?subjectId='+subjectId, 3000);
    });

    var showExamYear = function(){
        $(document).eqaModal({
            headerTitle:"Choose your exam year",
			cancelButton:true,
			cancelButtonText:"Cancel",
			applyButton:true,
            applyButtonText:"Continue",
			applyCallback:function(){
            	var selectedYear = $('div.modal-body label.btn.btn-outline.active input[type="radio"]')[0];
                var selectedYearNumber = selectedYear.id.split('-')[1]; 
            	var form = $('div.modal-body form#question-paper-selected-year-form');
            	var subjectExamYearSelected = form.find("input[name='subjectExamYearSelected']")[0];
            	$(subjectExamYearSelected).val(selectedYearNumber);
            	
            	form.submit(); // submit the form ...
            	$('.custom-modal').modal('hide'); // hide the modal dialog
            },
        }).show().load('/application/question-paper/get-years-of-question-papers?examId='+$selectedExamId, 3000);
    }

    $('#choose-language').click(function(){
        $(document).eqaModal({
            headerTitle:"Choose your language",
			cancelButton:true,
			cancelButtonText:"Cancel",
			applyButton:true,
            applyButtonText:"Apply",
            applyCallback: function(){
                $('.custom-modal').addClass('fadeOutUp').modal('hide');
            }
        }).show().load('partials/languages.html',3000);
    });

});