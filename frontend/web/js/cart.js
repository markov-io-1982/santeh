	// добавить в корзину
	$(document).on('click', '.app-add-to-cart', function () {
		
		var id = $(this).attr('data-id');
		
		if ($('input').is('#app-product-count')) {
			var count = $('#app-product-count').val();
		} else {
			var count = $(this).attr('data-count');
		}

		if ( $('select').is('#app-product-combination') ) {
			var product_comb_id = $("#app-product-combination :selected").val();
		} else {
			var product_comb_id = $(this).attr('data-combination');
			if (product_comb_id == undefined) {
				product_comb_id = 0;
			}			
		}
		
		console.log('id: ' + id + 'count: ' +count);

		$.post( "/cart/add-to-cart", {
			product_id: id,
			count: count,
			product_comb: product_comb_id,
		})
		  .done(function( data ) {
		  	var data = JSON.parse(data);
		    if (data.status == false) {
		    	//alert ('error');
				var n = noty({
					text: data.mess,
					type: 'error',			
				});		
		    }
		    else {
		    	var cart = $('.app-count-product');
		    	var cur_count = Number( cart.text() );
		    	var amount = parseInt( data.amount );
		    	var new_count = cur_count + amount;
		    	cart.text( new_count );												// устанавливаем новое количество товаров
		    	$('.app-count-product-in-cart').text(new_count);					// устанавливаем новое количество товаров
		    	var cur_total_price = cart.attr('data-totalprice');					// текущая стоимость товаров
		    	var new_total_price = Number(data.price) + Number(cur_total_price);	// новая стоимость товаров
		    	cart.attr('data-totalprice', new_total_price );						// устанавливаем новую стоимость товаров в ссылке
		    	$('.app-total-sum-in-cart').text(new_total_price);					//устанавливаем новую стоимость товаров в корзине
		    	if (product_comb_id != 0) {
		    		var old_product_comb_amount = parseInt( $('option[value='+product_comb_id+']').attr('data-amount') );
		    		var new_amount = old_product_comb_amount - amount;
		    		$('option[value='+product_comb_id+']').attr('data-amount', new_amount);
		    	}
		    	var product_amount = parseInt( $('#app-product-count').attr('max') );
		    	var new_product_amount = product_amount - amount;
		    	$('#app-product-count').attr('max', new_product_amount);
				var n = noty({
					text: data.mess,
					type: 'success',			
				});		
		    	
		    }
		  });

		//console.log(id);
	});


	// удалить товар с корзины

	$(document).on('click', '.app-delete-from-cart', function () {

		var id = $(this).attr('data-cart');

		$.post('/cart/delete-from-cart' , {
			id: id
		})
			.done(function(data) {
				var data = JSON.parse(data);
				if (data.status == false) {
					//alert('Error!');
					var n = noty({
						text: data.mess,
						type: 'error',			
					});	
				}
				else {
					//console.log(data);
					var old_count = parseInt( $('.app-count-product').html() );
					var new_count = old_count - data.reserve;
					$('.app-count-product').html(new_count);
					$.pjax.reload({container: '#cart-items'});
					var n = noty({
						text: data.mess,
						type: 'success',			
					});	
				}
			});
	});

	$(document).on('click', '.app-update-cart', function (){

		var item = $(this)
			.parent('td')
			.parent('.item');

		var temp_id = item.attr('id');
		var id = temp_id.substring(5);

		var amount = item
			.children('td')
			.children('.product-amount')
			.val();

		console.log(id + '' + amount);
		
		$.post('/cart/update-cart', {
			id: 	id,
			amount: amount,
		})
			.done(function(data){
				var data = JSON.parse(data);
				if (data.status == false) {
					alert(error);
					noty({
						text: data.mess,
						type: 'error',			
					});	
				} 
				else {
					var old_count = parseInt( $('.app-count-product').html() );
					var new_count = old_count + data.diff;
					$('.app-count-product').html(new_count);
					$.pjax.reload({container: '#cart-items'});
					noty({
						text: data.mess,
						type: 'success',			
					});					
				}
			});
	});

