$(function(){


	$(document).ready(function() {

		$('.btn-other-name').click( function () { // отобразить/скрыть имя на других языках
			$('.other-name').toggle();
		});

		$('.btn-other-intro').click( function () { // отобразить/скрыть intro на других языках
			$('.other-intro').toggle();
		});

		$('.btn-other-title').click( function () { // отобразить/скрыть intro на других языках
			$('.other-title').toggle();
		});

		$('.btn-other-description').click( function () { // отобразить/скрыть описание товара на других языках
			$('.other-description').toggle();
		});

		$('.btn-other-complectation').click( function () { // отобразить/скрыть комплектацию товара на других языках
			$('.other-complectation').toggle();
		});

		$('.btn-other-seo-title').click( function () { // отобразить/скрыть Seo title на других языках
			$('.other-seo-title').toggle();
		});

		$('.btn-other-seo-description').click( function () { // отобразить/скрыть Seo Description на других языках
			$('.other-seo-description').toggle();
		});

		$('.btn-other-seo-keywords').click( function () { // отобразить/скрыть Seo Keywords на других языках
			$('.other-seo-keywords').toggle();
		});

		$('.btn-other-name-promo-status').click( function () { // отобразить/скрыть имя промо-статуса на других языках
			$('.other-name-promo-status').toggle();
		});

		$('.btn-other-name-stock-status').click( function () { // отобразить/скрыть имя сток-статуса на других языках
			$('.other-name-stock-status').toggle();
		});

		$('.btn-other-name-attribute-list').click( function () { // отобразить/скрыть имя атрибута на других языках
			$('.other-name-attribute-list').toggle();
		});

		$('.btn-other-name-attribute-value').click( function () { // отобразить/скрыть имя значения атрибута на других языках
			$('.other-name-attribute-value').toggle();
		});

		$('.btn-other-name-category').click( function () { // отобразить/скрыть имя категории на других языках
			$('.other-name-category').toggle();
		});

		$('.btn-other-seo-title-category').click( function () { // отобразить/скрыть SEO title категории на других языках
			$('.other-seo-title-category').toggle();
		});

		$('.btn-other-seo-description-category').click( function () { // отобразить/скрыть SEO description категории на других языках
			$('.other-seo-description-category').toggle();
		});
		$('.btn-other-seo-keywords-category').click( function () { // отобразить/скрыть SEO keywords категории на других языках
			$('.other-seo-keywords-category').toggle();
		});

		if ('#product-isset_product_combination:checked') {
			$(".after-isset-product-combination").show();
			console.log('checked');
		} else {
			$(".after-isset-product-combination").hide();
			console.log('non checked');
		}
		$('#product-isset_product_combination').click(function() { // отобразить/скрыть комбинации продукта
	    	$(".after-isset-product-combination").toggle(this.checked);
	    });

		$(document).on('click', '.btn-other-name-img', function () { // отобразить/скрыть имя изображения на других языках
			$('.other-name-img').toggle();
		});
	 
	// page form
		$('.btn-other-name-page').click( function () { // отобразить/скрыть имя страницы на других языках
			$('.other-name-page').toggle();
		});
		$('.btn-other-page-body').click( function () { // отобразить/скрыть тело страницы на других языках
			$('.other-page-body').toggle();
		});
		$('.btn-other-seo-title-page').click( function () { // отобразить/скрыть seo-title на других языках
			$('.other-seo-title-page').toggle();
		});
		$('.btn-other-seo-description-page').click( function () { // отобразить/скрыть seo-description на других языках
			$('.other-seo-description-page').toggle();
		});
		$('.btn-other-seo-keywords-page').click( function () { // отобразить/скрыть seo-keywords на других языках
			$('.other-seo-keywords-page').toggle();
		});


		$('.btn-other-name-payment-method').click( function () { // отобразить/скрыть имя
			$('.other-name-payment-method').toggle();
		});
		$('.btn-other-description-payment-method').click( function () { // отобразить/скрыть description
			$('.other-description-payment-method').toggle();
		});

		$('.btn-other-name-delivery-method').click( function () { // отобразить/скрыть имя
			$('.other-name-delivery-method').toggle();
		});
		$('.btn-other-description-delivery-method').click( function () { // отобразить/скрыть description
			$('.other-description-delivery-method').toggle();
		});

		// отобразить/скрыть информацию на других язиках в view
		$('#open-more-detail').click( function () {
			console.log('click');
			$('#more-detail').toggle();
		});



		// счетчики
	    $(document).on('click', '.counter-plus', function ($this){ // добавить 1
	    	var element = $(this);
	    	var parent = element.parent();
	    	var input = parent.children(".form-control");
	    	var currentValue = Number( input.val() );
	    	input.val(currentValue + 1); 	
	    });
	    $(document).on('click', '.counter-minus', function ($this){ // убавить на 1
	    	var element = $(this);
	    	var parent = element.parent();
	    	var input = parent.children(".form-control");
	    	var currentValue = Number( input.val() );
	    	if (currentValue == 1) {
	        	input.val('');
	        	return false
	        }
	        if (currentValue == '') {
	        	return false;
	        }
	    	input.val(currentValue - 1); 	
	    });
		
	});

});