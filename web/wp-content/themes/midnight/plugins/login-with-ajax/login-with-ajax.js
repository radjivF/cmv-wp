var bwDoc = jQuery(document),
bwLWA = jQuery('#bw-lwa');

jQuery(document).ready( function($) {

 	$('form.lwa-form, form.lwa-remember, form.lwa-register-form').submit(function(event) {
 		event.preventDefault();
 		var form = $(this);
 		var statusElement = form.find('.lwa-status');
 
 		var ajaxFlag = form.find('.lwa-ajax');
 		
        if( ajaxFlag.length == 0 ){
 			ajaxFlag = $('<input class="lwa-ajax" name="lwa" type="hidden" value="1" />');
 			form.prepend(ajaxFlag);
 		}

		//Make Ajax Call
		$.ajax({
			type : 'POST',
			url : form.attr('action'),
			data : form.serialize(),
			beforeSend : function(){
                bwLWA.addClass('bw-pro-load');
            },
			success : function(data){
				lwaAjax( data, statusElement );
				bwDoc.trigger('lwa_' + data.action, [data, form]);
			},
			error : function(){ lwaAjax({}, statusElement); },
			dataType : 'jsonp'
		});
	});
 	
 	bwDoc.on('lwa_login', function(event, data, form) {
		if(data.result === true){
			//Login Successful - Extra stuff to do
			if( data.widget != null ){
				$.get( data.widget, function(widget_result) {
					var newWidget = $(widget_result); 
					form.parent('.lwa').replaceWith(newWidget);
					var lwaSub = newWidget.find('.').show();
					var lwaOrg = newWidget.parent().find('.lwa-title');
					lwaOrg.replaceWith(lwaSub);
				});
			} else {
				if (data.redirect == null) {
					window.location.reload();
				} else {
					window.location = data.redirect;
				}
			}
		}
 	});
 	
	function lwaAjax( data, statusElement ) {
		var bwLWAform = bwLWA.find('.lwa-form'),
			bwLWApass = bwLWA.find('.lwa-remember'),
			bwLWAregister = bwLWA.find('.lwa-register-form');
		statusElement = $(statusElement);
		if(data.result === true){
			statusElement.attr('class','lwa-status lwa-status-live lwa-status-confirm').html(data.message).css('display', 'block'); //modify status content
		}else if( data.result === false ){
			statusElement.attr('class','lwa-status lwa-status-live lwa-status-invalid').html(data.error).css('display', 'block'); //modify status content
			statusElement.find('a').click(function(event){
				event.preventDefault();
				bwLWAregister.add(bwLWAform).removeClass('bw-form-active');
            	bwLWApass.addClass('bw-form-active');
			});
		} else {	
			statusElement.attr('class','lwa-status lwa-status-live lwa-status-invalid').html('An error has occured. Please try again.').css('display', 'block'); //modify status content
		}
	}

});