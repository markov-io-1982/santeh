$(document).ready(function() {
	console.log('work');

	$(document).on('click', '#app-add-set', function (){
		$('#app-add-set-modal').modal('show')
			.find('#app-add-set-modal-content');
	});


	$(document).on('click', '#app-add-set-submit', function () {

		var code = $('#app-set-code').val(),
			title = $('#app-set-title').val(),
			content = $('#app-set-content').val();
		
		$.post( "/admin/setting/config-add", {
			code: code,
			title: title,
			content: content,
		})
		  .done(function( data ) {
		  	var data = JSON.parse(data);
		    if (data.status == true) {
            	$(document).find('#app-add-set-modal').modal('hide');
            	$('form#form-app-add-set').trigger("reset");
	            $.pjax.reload({container: '#app-configs'});
	            $.notify(data.mess, "success");
		    }
		    else { 
	    		$('#app-add-set-message').text(data.mess);
		    }
		  });

		  return false;
	});

	$(document).on('click', '.app-set-edit', function (){
		$('#app-add-set-modal').modal('show')
			.find('#app-add-set-modal-content');

		var tr = $(this).parent('td').parent('tr'),
			code = tr.children('td.app-code').text(),
			title = tr.children('td.app-title').text(),
			content = tr.children('td.app-content').text();

			//console.log(tr);

			$('#app-set-code').val(code).attr('readonly', 'readonly');
			$('#app-set-title').val(title);
			$('#app-set-content').val(content);
	});

	$(document).on('click', '.app-set-del', function () {
		var tr = $(this).parent('td').parent('tr'),
			code = tr.children('td.app-code').text();

		$.post( "/admin/setting/config-del", {
			code: code,
		})
		  .done(function( data ) {
		  	var data = JSON.parse(data);
		    if (data.status == true) {
	            $.pjax.reload({container: '#app-configs'});
	            $.notify(data.mess, "success");
		    }
		    else { 
	    		$('#app-add-set-message').text(data.mess);
		    }
		  });		
	});

});

