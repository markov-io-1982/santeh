$(function (){
    /* accardeon menu start */
    $('.catalog').dcAccordion({
        speed: 300
    });
    /* accardeon menu end */

	// настройки noty
	$.noty.defaults = {
	    layout: 'topRight',
	    theme: 'relax', // or 'relax'
	    type: 'alert',
	    text: '', // can be html or string
	    dismissQueue: true, // If you want to use queue feature set this true
	    template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>',
	    animation: {
	        open: {height: 'toggle'}, // or Animate.css class names like: 'animated bounceInLeft'
	        close: {height: 'toggle'}, // or Animate.css class names like: 'animated bounceOutLeft'
	        easing: 'swing',
	        speed: 500 // opening & closing animation speed
	    },
	    timeout: 5000, // delay for closing event. Set false for sticky notifications
	    force: false, // adds notification to the beginning of queue when set to true
	    modal: false,
	    maxVisible: 5, // you can set max visible notification for dismissQueue true option,
	    killer: false, // for close all notifications before show
	    closeWith: ['click'], // ['click', 'button', 'hover', 'backdrop'] // backdrop click will close all notifications
	    callback: {
	        onShow: function() {},
	        afterShow: function() {},
	        onClose: function() {},
	        afterClose: function() {},
	        onCloseClick: function() {},
	    },
	    buttons: false // an array of buttons
	};

	// fancybox
	$(document).ready(function() {
		$(".fancybox").fancybox({
			openEffect	: 'none',
			closeEffect	: 'none'
		});
	});

	// получить GET параметр
	function $_GET(key) {
		var s = window.location.search;
		s = s.match(new RegExp(key + '=([^&=]+)'));
		return s ? s[1] : false;
	}

	// получить масив уникальных елементов
	function unique(arr) {
	  var result = [];

	  nextInput:
	    for (var i = 0; i < arr.length; i++) {
	      var str = arr[i]; // для каждого элемента
	      for (var j = 0; j < result.length; j++) { // ищем, был ли он уже?
	        if (result[j] == str) continue nextInput; // если да, то следующий
	      }
	      result.push(str);
	    }

	  return result;
	}

	console.log('load');

	// переключение языков
	$(document).on('click', '.language', function(){
		//console.log('language-frontand');
		var lang = $(this).attr('id');

		$.post('/site/language', {
			'lang':lang
		}, function(data){
			location.reload();
		});
	});

	// переключение валюты
	/*$(document).ready(function() {
		$('.currencies').click(function(){
			var curr = $(".currencies :selected").val();
			console.log(curr);
			$.post('site/currency', {
				'curr':curr
			}, function(data){
				location.reload();
			});
		});
	});*/
    // переключение валюты - новое для Nav
    $('.cash').on('click', function () {
        //var qty = document.getElementById('value-cart').value;
        var curr = $(this).data('curr');
        console.log('curr', curr);
        $.ajax({
            url: '/site/currency',
            data: {curr: curr},
            type: 'POST',
            success: function (res) {
                //console.log(res);
                location.reload();
            },
            error: function (error) {
                console.log('error', error);
                //location.reload();
            }
        });
        return false;
    });

	// при загрузке страницы отмечаются те фильтры, которые есть в адресной строке в GET запросе
	if ($_GET('filter') != false) {
		console.log('true');
		var filters = $_GET('filter');
		var filters_array = filters.split(',');
		$('input:checkbox').each(function(){
			for (var i = 0; i < filters_array.length; i++ ) {
				if ( $(this).val() == filters_array[i]) {
					$(this).attr('checked', 'checked');
					console.log($(this));
				}
			}

		});
	}

	// отфильтровать записи по атрибутам
	$(document).on('click', '.app-filter', function () {
		console.log('click');
		var parent_id = $(this).parent('.panel-body').attr('id');
		var page_url = $('.app-filters').attr('data-url');
		console.log(parent_id);
		var filters = new Array();
		$('#'+parent_id+' input:checkbox:checked').each(function(){
			filters.push( $(this).val() );
		});

		console.log(filters);

		if ($_GET('sort')) {
			var sort = '?sort='+$_GET('sort');
			var amp = '&';
		} else {
			var sort = '';
			var amp = '?';
		}

		if (filters.length  == 0) {
			location.href = page_url;
		}
		else {
			location.href = page_url + sort + amp + 'filter=' + filters.join(',');
		}

		// console.log('page_url' + page_url);
		// console.log(window.location.search);

	});



	// очистить фильтры
	$(document).on('click', '.app-clear-filter', function() {
		console.log('clear');
		var parent_id = $(this).parent('.panel-body').attr('id');
		$('#'+parent_id+' input:checkbox:checked').each(function(){
		console.log($(this));
			$(this).removeAttr('checked') ;
		});
	})




	// счетчики
    $(document).on('click', '.counter-plus', function ($this){ // добавить 1
    	var element = $(this);
    	var parent = element.parent();
    	var input = parent.children(".form-control");
    	var currentValue = Number( input.val() );

    	if (input.data('max') == NaN) {
    		return false;
    	}

    	if (input.data('max') <= currentValue) {
    		return false;
    	} else {
    		input.val(currentValue + 1);
    	}

    });
    $(document).on('click', '.counter-minus', function ($this){ // убавить на 1
    	var element = $(this);
    	var parent = element.parent();
    	var input = parent.children(".form-control");

    	if (input.data('min') == NaN) {
    		return false;
    	}

    	var currentValue = Number( input.val() );
    	if (currentValue == 1) {
        	return false;
        } else if (currentValue <= input.data('min')) {
        	return false;
        } else {
        	input.val(currentValue - 1);
        }
    });

// отзывы

	// вызов модального окна отзывов
	$(document).on('click', '#app-add-review', function (){
		$('#add-review').modal('show')
			.find('#modal-add-review-content');
			//.load($(this).attr('data-value'));
	});

	// отправить форму c отзывом
	$(document).on('click', '#add-review-submit', function () {

		var id = $('.app-add-to-cart').data('id'),
			user_name = $('#form-add-review #user-name').val(),
			stars = $('.fa-star').length,
			comment = $('#form-add-review #user-comment').val();

			//console.log(id + '-' + user_name + '-' + stars + '-' +comment);

		$.post( "/shop/review", {
			id: id,
			user_name: user_name,
			stars: stars,
			comment: comment,
		})
		  .done(function( data ) {

		  	console.log("data: " + data);
		  	var data = JSON.parse(data);
		  	console.log(data);

		    if (data.status == true) {
		    	//console.log(data);
            	$(document).find('#add-review').modal('hide');
            	$('form#form-add-review').trigger("reset");
            	$('.star').removeClass('fa-star').addClass('fa-star-o')
				noty({
					text: data.mess,
					type: 'success',
				});
		    }
		    else {
		    	//console.log (data);
				noty({
					text: data.mess,
					type: 'error',
				});
		    }
		  });

		  return false;
	});

	// поставить оценку
	// $('.fa-star-o').mouseenter(function(){
	// 	console.log('hover');
	// 	$(this).prevAll('.star')
	// 		.removeClass('fa-star-o')
	// 		.addClass('fa-star');

	// 	$(this).removeClass('fa-star-o');
	// 	$(this).addClass('fa-star');

	// 	console.log($(this));
	// });

	// $(document).on('mouseenter', '.fa-star', function (){
	// 	console.log('hover');
	// 	$(this).removeClass('fa-star');
	// 	$(this).addClass('fa-star-o');
	// });

	$(document).ready(function() {
		$('.star').click(function(event) {
			console.log('click');
			if ($(this).hasClass('fa-star-o')) {
				$(this).removeClass('fa-star-o');
				$(this).addClass('fa-star');
				$(this).prevAll('.star')
					.removeClass('fa-star-o')
					.addClass('fa-star');
			}
			else if ($(this).hasClass('fa-star')) {
				$(this).nextAll('.star')
					.removeClass('fa-star')
					.addClass('fa-star-o');
			}

		});

	});


// покупка в один клик

	// вызов модального окна покупки в один клик
	$(document).on('click', '#app-buy-one-click', function (){
		$('#buy-to-one-click').modal('show')
			.find('#modal-buy-one-click-content');
			//.load($(this).attr('data-value'));
	});

	// отправить форму покупки в один клик
	$(document).on('click', '#buy-one-click-submit', function () {

		//var id = $('.app-add-to-cart').attr('data-id');
        var id = $('#app-buy-one-click').attr('data-id');
		var amount = $('#app-product-count').val();
		var product_comb_id = $("#app-product-combination :selected").val();
		var user_phone = $('#buy-one-click-phone').val();
		var user_email = $('#buy-one-click-email').val();

		if (user_email == '') {
			$('#buy-one-click-message').text('Вы не ввели e-mail');
			return false;
		}
		var r = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		if (!r.test(user_email)) {
			$('#buy-one-click-message').text('Введите правильный e-mail');
			return false;
		}

		if (user_phone == '') {
			$('#buy-one-click-message').text('Вы не ввели номер телефона');
			return false;
		}
		if ( isNaN(user_phone) ) {
			$('#buy-one-click-message').text('Введенное Вами значение не является номером телефона' + typeof(user_phone));
			return false;
		}
		if (user_phone.length > 10) {
			$('#buy-one-click-message').text('Номер телефона слишком длинный');
			return false;
		}
		if (user_phone.length < 10) {
			$('#buy-one-click-message').text('Номер телефона слишком короткий');
			return false;
		}


		$.post( "/order/buy-one-click", {
			id: id,
			amount: amount,
			product_comb_id: (product_comb_id == undefined) ? 0 : product_comb_id,
			user_phone: user_phone,
			user_email: user_email,
		})
		  .done(function( data ) {
		  	var data = JSON.parse(data);
		    if (data.status == false) {
				var n = noty({
					text: data.mess,
					type: 'error',
				});
		    	//console.log ('error');
		    }
		    else {
		    	//console.log(data);
            	$(document).find('#buy-to-one-click').modal('hide');
            	$('form#form-buy-one-click').trigger("reset");
            	$('.buy-success').text('');
		    	if (product_comb_id != 0) {
		    		var old_product_comb_amount = parseInt( $('option[value='+product_comb_id+']').attr('data-amount') );
		    		var new_amount = old_product_comb_amount - amount;
		    		$('option[value='+product_comb_id+']').attr('data-amount', new_amount);
		    		$('#app-product-count').attr('max', new_amount);
		    	}
                $('#app-buy-one-click').hide();

		    	var product_amount = parseInt( $('#app-product-count').attr('max') );
		    	var new_product_amount = product_amount - amount;
		    	$('#app-product-count').attr('max', new_product_amount);
				var n = noty({
					text: data.mess,
					type: 'success',
				});
		    }
		  });

		  return false;
	});

	// установить максимальное количество доступное для покупки смене комбинации товара
	$( "#app-product-combination" ).change(function() {
        var select = $("#app-product-combination option:selected");
        var new_amount = select.data('amount');
  		$('#app-product-count').val(1);
        $('#app-product-count').data('max', new_amount);

        $('.price').text(select.data('price'));
        var price_old = select.data('price_old');
        if(price_old) {
            $('.price-old').text(select.data('price_old'));
            $('.price-old-wrap').show();
        } else {
            $('.price-old-wrap').hide();
        }
	});

	// если есть варианты продукта, то установить максимально количество варианта по умолчанию
	if ( $('select').is('#app-product-combination') ) {
        var product_comb_amount = $("#app-product-combination option:selected").data('amount');
        //console.log('product_comb_amount',product_comb_amount);
        $('#app-product-count').data('max', product_comb_amount);
	}

	$(document).ready(function($) {
		var cart_caount = $('.app-count-product').text();
		var cart_total_price = $('.app-count-product').attr('data-totalprice');

		$('.app-count-product-in-cart').text(cart_caount);
		$('.app-total-sum-in-cart').text(cart_total_price);
	});

	/* подсветка активного пункта меню */

	var url = document.location.href;
	var reg = /(\/|\?)/;
	var url_arr = url.split('/');

	var arr = new Array();

	for (var i = 0; i < url_arr.length; i++) {
		var new_arr = url_arr[i].split('?');
		arr = arr.concat(new_arr);
	}

	for (var i = 0; i < arr.length; i++) {
		$('.main-menu>li>a[href *="'+arr[i]+'"]').parent('li').addClass('active');
		console.log(arr[i]);
	}
	if (arr[arr.length-1] == '') {
		$('.main-menu>li>a[href="/"]').parent('li').addClass('active');
	}

	// замена телефонов на странице на ссылки
	// var regex_ph = /(?:(?:\+?[13]*\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4,6})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?/g;
 //    var body =  $('body');
 //    body = body.html();
 //    var body_re = body.replace(regex_ph, '<a href="tel:$&">$&</a>', 'g');
 //    $('body').html(body_re);


    $('.caption>.title').hover(function (){
    	$(this).toggleClass('hovered-title');
    	$(this).children('a').toggleClass('hovered-a');
    });

	// autocomplete поиска
    $( "#search-input" ).autocomplete({
      source: '/shop/autocomplete', // Страница для обработки запросов автозаполнения
      minLength: 1, // Минимальная длина запроса для срабатывания автозаполнения
      // select: function( event, ui ) { // Callback функция, срабатывающая на выбор одного из предложенных вариантов,
      //   log( "Selected: " + ui.item.value + " aka " + ui.item.id );
      // }
      delay: 200, // Задержка запроса (мсек), на случай, если мы не хотим слать миллион запросов, пока пользователь печатает.
    });


    /**/

 //    function resizeWindow () {
 //    	if (window.screen.width < 768) {
 //    		console.log(768);

 //    	}
 //    }

 //    resizeWindow ();

 //    $(window).resize(function(){
	//   	resizeWindow ();
	// });


$('ul.slides>li').hover(function (){

	$(this).children('.flex-caption').children('.flex-head').toggleClass('flex-head-hover');
	//('style', 'height: auto;');
});


});