//    Main script of ExamsQA
//
    "use strict";
//START : This code fetch question sections that are associated to a particular question paper
    function initializeDependentDropdowm(url, independentSelectElementKey, dependentSelectElementKey, initOptionMessage) {
        $(document).on('change', independentSelectElementKey, function (e) {
            e.preventDefault();
            var value = parseInt(this.value, 10);
            if ($.isNumeric(value) && value > 0) { // default or empty select option with value '' are not handled.  
                $.post(url, {id: value}, function (data) {
                    $(dependentSelectElementKey).html($('<option>', {value: ''})
                            .text(initOptionMessage));
                    if (data.status == true) {
                        $.each(data.selected, function (key, option) {
                            $(dependentSelectElementKey).append($('<option>', {value: option.id})
                                    .text(option.value));
                        });
                    } else {
                        alert('No record was found !');
                    }
                });
            } else {
                $(dependentSelectElementKey).html($('<option>', {value: ''})
                        .text(initOptionMessage));
            }

        });
    }
    
    function copyContent(element, contentId, message){
    	var content = $('#'+contentId).val();
    	if (content == ''){
    		if (message == ''){
    			alert('Description is empty !');
    			return ;
    		}
    		alert(message);
    		return ;
    		}
    	new Clipboard('#'+element.id, {
    	    text: function(trigger) {
    		    return content;
    	    }
    	});
    	alert('Copied !');
    }
    
//    $(document).on('click', '#global-system-search-icon', function(event){
//    	var search = $('#global-system-search');
//    	var token = search.val();
//    	if (token != ''){
//    		$.get('/admin/permission/assign-admin', {token : token}, function(event){
//    			
//    		});
//    	}
//    });
//END : This code fetch question sections that are associated to a particular question paper

  //START : This code helps super-admin to assign admin to a particular departments 
    $(document).on('change', "select[data-key='data-link-assign-admin-to-department']", function(event){
    	var value = this.value;
        if (value == '') { // if selected option value is empty, do not process data
            return false;
        }
        var splitVal = value.split('-');
        var userId = splitVal[splitVal.length - 1];
        var deptId = splitVal[splitVal.length - 2];
    	var url = buildControllerUrl(value, 'assign-department');
    	$.post(url, {userId : userId, deptId : deptId}, function(response){
    		if (response.status == true){
    			alert(response.message);
    		}else{
    			alert('Oops! Something went wrong, please try again later.');
    		}
    	});
    });
  //END : This code helps super-admin to assign admin to a particular departments 
    
//START : This code help populate form for edit / update operation
    $(document).on('change', "select[data-key='data-link-to-edit-form']", function () {
        var value = this.value;
        if (value == '') { // if selected option value is empty, do not process data
            return false;
        }
        var splitVal = value.split('-');
        if (splitVal[1] == 'delete') {
            var url = buildControllerUrl(value, 'delete');
            var confirmation = confirm('Delete action is not reversible, are you sure ?');
            if (confirmation == true) {
                $.get(url, {id: splitVal[2]}, function (data) {
                    $.each(data, function (i, option) {
                        var element = $('#' + option.id);
                        if (element.is("select")) {
                            element.prop('selectedIndex', option.value);
                        } else {
                            element.val(option.value);
                        }
                    });
                });
            }
        } else if (splitVal[1] == 'image') { // this used for image modal dialog form ...
            var url = buildControllerUrl(splitVal[0] + '_' + splitVal[1], 'upload');
            var valArray = value.split('-');
            var parentEntityId = valArray[valArray.length - 1];
            $('#modal-imgupload').load(url, {'parentEntityId' : parentEntityId}).modal('show');
        }
        else {
            var url = buildControllerUrl(value);
            $.get(url, {id: splitVal[2]}, function (data) {
                $.each(data, function (i, option) {
                    var element = $('#' + option.id);
                    if (element.is("select")) {
                        if (url == '/admin/question/entry' && option.id == 'questionSection') { // populate empty select element b4 setting selected option
                            $.post('/admin/question-section/section', function (data) {
                                var sectionOption;

                                $(element).html($('<option>', {value: ''})
                                        .text('- Select Section -'));
                                $.each(data.selected, function (key, section) {
                                    sectionOption = section.id == option.value ? "<option selected = 'selected'>" : "<option>";
                                    $(element).append($(sectionOption).val(section.id).text(section.value));
                                });
                            });
                        } else {
                            element.val(option.value); //set selected option value
                        }
                    } else {
                        element.val(option.value);
                    }
                });
            });
        }
        this.value = ''; // reset action select button back to the default ...
    });
//END : This code help populate form for edit / update operation

//START : This code help build controller url
    function buildControllerUrl(targetId, action) {
        var ctrlAction = (typeof action !== 'undefined') ? action : 'entry';
        var idParts = (targetId).split('-');
        var firstPart = idParts[0].split('_');
        var url = '/admin/';
        if (firstPart.length > 1) {
            for (var i = 0; i < firstPart.length; i++) {
            	if (isNaN(firstPart[i]) == true){
                url += firstPart[i];
                url += (i < firstPart.length - 1) && isNaN(firstPart[i+1]) == true ? '-' : '';            		
            	}
            }
            url += '/' + ctrlAction;
        } else {
            url += idParts[0] + '/' + ctrlAction;
        }
        return url;
    }
//END : This code help build controller url

//START : This code help submit form for insert / update operation 
    function submitForm(buttonId, formId) {
        $('#' + buttonId).on('click', function (e) {
            e.preventDefault();
            var formObj = $('#' + formId);
            var target_id = e.target.id.toString();
            if (target_id === 'submit-btn') {
                // START : check for empty form fields ...
                var has_empty = false;
                $(formObj).find('input[type!="hidden"]')
                        .each(function () {
                            if (!$(this).val()) {
                                alert('Please fill every neccessary details!');
                                has_empty = true;
                                return false;
                            }
                        });
                if (has_empty) {
                    return false;
                }
                // END : check for empty form fields ...
                // Perform the submit
                formObj.ajaxSubmit({
                            beforeSubmit: function (arr, $form, options) {
                                arr.push({
                                    name: "isAjax",
                                    value: "1"
                                }); // Notify backend that submit is
                                // via ajax
                            },
                            success: function (response, statusText, xhr, $form) {
                                if (response.status === true) {
                                	typeof(response.message) != 'undefined' ? alert(response.message) : alert('It is done, registration was successful !');
                                    clearForm();
                                    $('#data-table-answer-option-container-body-id tr').html('');// clear existing options in answer options data table
                                } else {
                                    alert('Oops! Something unusual occurs, this operation was not completed successfully !');
                                }
                            },
                            error: function (a, b, c) {
                                alert('Something unusal happened !');
                                console.log(a, b, c);
                            }
                        });
            } else if (target_id === 'clear-btn') {
                clearForm();
            } else if (target_id === 'add-option-btn') {
                $("#" + optionListContainerId).html(target_id);
            }

        });
        function clearForm() {
            $(':input').not(':button, :submit, :reset, :checkbox, :radio, #user, #institution').val('');
            $(':checkbox, :radio').prop('checked', false);
        }
    }
//END : This code help submit form for insert / update operation


    function loadEntryFromList(entryClass) {
        $('.' + entryClass).on('click', function (e) {
            e.preventDefault();
            var url = buildControllerUrl(e.target.id);
            $.get(url, {
                id: idParts[2]
            }, function (data) {
                $.each(data, function (i, option) {
                    var element = $('#' + option.id);
                    if (element.is("select")) {
                        element.prop('selectedIndex', option.value);
                    } else {
                        element.val(option.value);
                    }
                });
            });
        });
    }


    function findEntry(entryId) {
        $('#' + entryId).on('change', function (e) {
            e.preventDefault();
            var url = buildControllerUrl(e.target.id);
            $.get(url, {id: e.target.value}, function (data) {
                $.each(data, function (i, option) {
                    var element = $('#' + option.id);
                    if (element.is("select")) {
                        element.prop('selectedIndex', option.value);
                    } else {
                        element.val(option.value);
                    }
                });
            });
        });
    }


    function submitFormAction(buttonId, formId, content) {
        $('#' + buttonId).on('click', function (e) {
            e.preventDefault();
            var form = $('#' + formId);
            var formData = form.serialize() + '&formButton=' + encodeURI(e.target.id);
            $.post(form.attr('action'), formData, function (data) {
                $('#' + content).html(data.html);
            });
        });
    }

    $(document).on('click', '.form-element-checkbox-toggle-switch', function () {
        var value = $(this).prop('checked') == true ? 1 : 0;
        var id = this.id;
        var idParts = id.split('-');
        var url = '';
        if ($.inArray('active', idParts) != -1) {
            url = buildControllerUrl(id, 'update-active-status');
        } else if ($.inArray('correct', idParts) != -1) {
            url = buildControllerUrl(id, 'update-correct-status');
        } else if ($.inArray('admin', idParts) != -1) {
            url = buildControllerUrl(id, 'update-admin-status');
        } else
            ;
        $.post(url, {'value': value, 'entity_id': idParts[1]}, function (data) {
            if (data.status == true) {
                alert('It is done, request changes had been effected!');
            } else {
                alert('Oops, something went wrong, changes was not effected!');
            }
        });
    });