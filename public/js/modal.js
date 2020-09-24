$.fn.extend({
    eqaModal: function (options) {
        // These are the defaults.
		var settings = $.extend({
            addBodyClass:"",
			headerTitle:"",
			cancelButton:true,
			cancelButtonText:"Cancel",
            cancelCallback:function(){},
			applyButton:false,
            applyButtonText:"Apply",
			applyCallback:function(){},
            customFooter:false,
            customFooterContent:""
        }, options );
        
        var customModal = $('<div class="custom-modal modal animated pulse" tabindex="-1" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="lnr lnr-cross"></i></button><h4 class="modal-title text-center"><span class="sr-only">main navigation</span></h4></div><div class="modal-body"><svg class="circle-loader progress" width="40" height="40" version="1.1" xmlns="http://www.w3.org/2000/svg"><circle cx="20" cy="20" r="15"></svg></div><div class="modal-footer"></div></div></div></div>');
        
        var title,positiveButton,negativeButton,footer;
        if(settings.headerTitle!=""){
            customModal.find('.modal-title').html(settings.headerTitle);
        }
        if(settings.cancelButton){
            customModal.find('.modal-footer').prepend('<button class="btn btn-primary" data-dismiss="modal">'+settings.cancelButtonText+'</button>');
        }
        if(settings.applyButton){
            customModal.find('.modal-footer').append('<button class="btn btn-default" data-apply="modal">'+settings.applyButtonText+'</button>');
        }
        
        if(settings.customFooter){
            customModal.find('.modal-footer').html(settings.customFooterContent);
        }

        if(settings.applyCallback){
            customModal.find('[data-apply="modal"]').click(settings.applyCallback);
        }
        
        var initModalConfig = function(){
            if(settings.addBodyClass!=""){
                $('body').addClass(settings.addBodyClass);
            }
        
            if(settings.cancelCallback){
                customModal.find('[data-dismiss="modal"]').click('hidden.bs.modal', settings.cancelCallback);
            }

            $(customModal).on('hidden.bs.modal', function(){
                $('body').removeClass(settings.addBodyClass);
                customModal.remove();
            });
        }

        return {
            show : function(){
                $('body').append(customModal);
                initModalConfig();
                $(customModal).modal('show');
                return this;
            },
            load : function(url,delay){
                setTimeout(function(){
                    customModal.find('.modal-body').load(url);
                },delay);
                return this;
            }
        }

    }
});