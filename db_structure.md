category
	id
	name_en
	name_ua
	name_ru
	parent_id
	sort_position
	slug
	seo_title_en
	seo_title_ua
	seo_title_ru
	seo_description_en
	seo_description_ua
	seo_description_ru
	seo_keywords_en
	seo_keywords_ua
	seo_keywords_ru
	date_update
	date_create
	status

stock_status 					// статусы наличия товара
	id	
	name_en
	name_ua
	name_ru
	sort_position

promo_status					// акционные статусы
	id
	name_en
	name_ua
	name_ru
	img
	sort_position

product
	id
	name_en
	name_ua
	name_ru
	category_id
	sort_position
	intro_text_en
	intro_text_ru
	intro_text_ua
	price
	price_old
	quantity					// количество
	min_order					// минимальное количество для заказа
	reserve						// в резерве
	promo_status_id             // промо статус (акция и т.п)
	promo_date_end				// окончание акции
	stock_status_id				// статус наличия
	img 						// изображение товара
	on_main
	slug
	status
	date_update
	date_create

product_detail
	id
	product_id					
	description_en					// описание
	description_ru					// описание
	description_ua					// описание
	complectation_en 				// комплектация
	complectation_ru 				// комплектация
	complectation_ua 				// комплектация
	seo_title_en
	seo_title_ru
	seo_title_ua
	seo_description_en
	seo_description_ru
	seo_description_ua
	seo_keywords_en
	seo_keywords_ru
	seo_keywords_ua
	buy							// количество проданого товара....
	count_views

product_combination
	id
	img
	quantity
	reserve
	date_create
	status
	parent_id
	sort_position
	attribute_id
	attribute_value_id
	buy							// количество проданого товара

product_images
	id
	name_en
	name_ru
	name_ua
	url
	product_id
	sort_position

relations_product_product 			// связанные товары
	id
	product_main_id
	product_rel_id

relations_product_atribute
	id
	product_id
	attribute_id
	attribute_value_id	

attribute_list
	id
	name_en
	name_ru
	name_ua
	category_id
	sort_position

attribute_value
	id
	name_en
	name_ru
	name_ua
	attribute_id
	img
	sort_position




page
	id
	name_en
	name_ru
	name_ua
	slug
	status
	img
	page_body_en
	page_body_ru
	page_body_ua
	seo_title_en
	seo_title_ru
	seo_title_ua
	seo_description_en
	seo_description_ru
	seo_description_ua
	seo_keywords_en
	seo_keywords_ru
	seo_keywords_ua
	canonical_url
	
	date_create
	date_update

order_status
	id
	name_en
	name_ru
	name_ua

order
	id
	code
	user_id
	delivery_method_id
	payment_metod_id
	user_name
	user_middlename
	user_lastname
	user_email
	user_phone
	user_adress
	user_comment
	total_sum
	order_status_id
	date_create
	date_payment

delivery_method
	id
	name_en
	name_ru
	name_ua
	description_en
	description_ru
	description_ua
	sort_position

payment_method
	id
	name_en
	name_ru
	name_ua
	description_en
	description_ru
	description_ua
	sort_position	