<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заказы");
?>

<?$APPLICATION->IncludeComponent(
	"bitrix:sale.order.ajax", 
	"new_edost_rightCol", 
	array(
		"ACTION_VARIABLE" => "action",
		"ADDITIONAL_PICT_PROP_13" => "-",
		"ADDITIONAL_PICT_PROP_14" => "-",
		"ADDITIONAL_PICT_PROP_4" => "-",
		"ADDITIONAL_PICT_PROP_5" => "-",
		"ALLOW_APPEND_ORDER" => "Y",
		"ALLOW_AUTO_REGISTER" => "Y",
		"ALLOW_NEW_PROFILE" => "N",
		"ALLOW_USER_PROFILES" => "N",
		"BASKET_IMAGES_SCALING" => "adaptive",
		"BASKET_POSITION" => "after",
		"COMPATIBLE_MODE" => "Y",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"COUNT_DELIVERY_TAX" => "N",
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"DELIVERIES_PER_PAGE" => "9",
		"DELIVERY_FADE_EXTRA_SERVICES" => "N",
		"DELIVERY_NO_AJAX" => "N",
		"DELIVERY_NO_SESSION" => "N",
		"DELIVERY_TO_PAYSYSTEM" => "d2p",
		"DISABLE_BASKET_REDIRECT" => "N",
		"DISPLAY_IMG_HEIGHT" => "90",
		"DISPLAY_IMG_WIDTH" => "90",
		"MESS_ADDITIONAL_PROPS" => "Дополнительные свойства",
		"MESS_AUTH_REFERENCE_1" => "Символом \"звездочка\" (*) отмечены обязательные для заполнения поля.",
		"MESS_AUTH_REFERENCE_2" => "После регистрации вы получите информационное письмо.",
		"MESS_AUTH_REFERENCE_3" => "Личные сведения, полученные в распоряжение интернет-магазина при регистрации или каким-либо иным образом, не будут без разрешения пользователей передаваться третьим организациям и лицам за исключением ситуаций, когда этого требует закон или судебное решение.",
		"MESS_COUPON" => "Купон",
		"MESS_ECONOMY" => "Экономия",
		"MESS_INNER_PS_BALANCE" => "На вашем пользовательском счете:",
		"MESS_NEAREST_PICKUP_LIST" => "Ближайшие пункты:",
		"MESS_ORDER_DESC" => "Комментарии к заказу:",
		"MESS_PERSON_TYPE" => "Тип плательщика",
		"MESS_PICKUP_LIST" => "Пункты самовывоза:",
		"MESS_PRICE_FREE" => "бесплатно",
		"MESS_REGION_REFERENCE" => "Выберите свой город в списке. Если вы не нашли свой город, выберите \"другое местоположение\", а город впишите в поле \"Город\"",
		"MESS_REGISTRATION_REFERENCE" => "Если вы впервые на сайте, и хотите, чтобы мы вас помнили и все ваши заказы сохранялись, заполните регистрационную форму.",
		"MESS_SELECT_PICKUP" => "Выбрать",
		"MESS_SELECT_PROFILE" => "Выберите профиль",
		"MESS_USE_COUPON" => "Применить купон",
		"ONLY_FULL_PAY_FROM_ACCOUNT" => "N",
		"PATH_TO_AUTH" => SITE_DIR."auth/",
		"PATH_TO_BASKET" => SITE_DIR."test4445/order/",
		"PATH_TO_ORDER" => "",
		"PATH_TO_PAYMENT" => SITE_DIR."order/payment/",
		"PATH_TO_PERSONAL" => SITE_DIR."personal/",
		"PAY_FROM_ACCOUNT" => "N",
		"PAY_SYSTEMS_PER_PAGE" => "9",
		"PICKUPS_PER_PAGE" => "5",
		"PICKUP_MAP_TYPE" => "yandex",
		"PRODUCT_COLUMNS" => "",
		"PRODUCT_COLUMNS_HIDDEN" => "",
		"PRODUCT_COLUMNS_VISIBLE" => array(
			0 => "PREVIEW_PICTURE",
			1 => "DISCOUNT_PRICE_PERCENT_FORMATED",
			2 => "PRICE_FORMATED",
		),
		"PROPS_FADE_LIST_1" => array(
			0 => "1",
			1 => "2",
			2 => "3",
			3 => "27",
			4 => "55",
		),
		"PROP_1" => "",
		"PROP_2" => "",
		"PROP_3" => "",
		"PROP_4" => "",
		"SEND_NEW_USER_NOTIFY" => "Y",
		"SERVICES_IMAGES_SCALING" => "adaptive",
		"SET_TITLE" => "Y",
		"SHOW_BASKET_HEADERS" => "N",
		"SHOW_COUPONS_BASKET" => "N",
		"SHOW_COUPONS_DELIVERY" => "N",
		"SHOW_COUPONS_PAY_SYSTEM" => "Y",
		"SHOW_DELIVERY_INFO_NAME" => "Y",
		"SHOW_DELIVERY_LIST_NAMES" => "Y",
		"SHOW_DELIVERY_PARENT_NAMES" => "Y",
		"SHOW_MAP_IN_PROPS" => "N",
		"SHOW_NEAREST_PICKUP" => "N",
		"SHOW_NOT_CALCULATED_DELIVERIES" => "Y",
		"SHOW_ORDER_BUTTON" => "always",
		"SHOW_PAYMENT_SERVICES_NAMES" => "Y",
		"SHOW_PAY_SYSTEM_INFO_NAME" => "Y",
		"SHOW_PAY_SYSTEM_LIST_NAMES" => "Y",
		"SHOW_PICKUP_MAP" => "N",
		"SHOW_STORES_IMAGES" => "N",
		"SHOW_TOTAL_ORDER_BUTTON" => "Y",
		"SHOW_VAT_PRICE" => "N",
		"SKIP_USELESS_BLOCK" => "Y",
		"SPOT_LOCATION_BY_GEOIP" => "N",
		"TEMPLATE_LOCATION" => "popup",
		"TEMPLATE_THEME" => "blue",
		"USER_CONSENT" => "N",
		"USER_CONSENT_ID" => "1",
		"USER_CONSENT_IS_CHECKED" => "N",
		"USER_CONSENT_IS_LOADED" => "N",
		"USE_CUSTOM_ADDITIONAL_MESSAGES" => "Y",
		"USE_CUSTOM_ERROR_MESSAGES" => "N",
		"USE_CUSTOM_MAIN_MESSAGES" => "N",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_PHONE_NORMALIZATION" => "Y",
		"USE_PRELOAD" => "N",
		"USE_PREPAYMENT" => "N",
		"USE_YM_GOALS" => "N",
		"COMPONENT_TEMPLATE" => "new_edost_rightCol"
	),
	false
);?>



<div>
	<?/*
	$APPLICATION->IncludeComponent(
		"h2o:buyoneclick", 
		"default_old_basketajax", 
		array(
			"ADD_NOT_AUTH_TO_ONE_USER" => "N",
			"ALLOW_ORDER_FOR_EXISTING_EMAIL" => "Y",
			"BUY_CURRENT_BASKET" => "Y",
			"CACHE_TIME" => "8640",
			"CACHE_TYPE" => "N",
			"COMPOSITE_FRAME_MODE" => "A",
			"COMPOSITE_FRAME_TYPE" => "AUTO",
			"DEFAULT_DELIVERY" => "32",
			"DEFAULT_PAY_SYSTEM" => "10",
			"DELIVERY" => array(
				0 => "32",
			),
			"IBLOCK_ID" => "4",
			"IBLOCK_TYPE" => "1c_catalog",
			"ID_FIELD_PHONE" => array(
				0 => "individualPERSONAL_PHONE",
				1 => "",
			),
			"LIST_OFFERS_PROPERTY_CODE" => array(
				0 => "size",
				1 => "",
			),
			"MASK_PHONE" => "(999) 999-9999",
			"MODE_EXTENDED" => "Y",
			"NEW_USER_GROUP_ID" => array(
				0 => "6",
			),
			"NOT_AUTHORIZE_USER" => "Y",
			"OFFERS_SORT_BY" => "ACTIVE_FROM",
			"OFFERS_SORT_ORDER" => "DESC",
			"PATH_TO_PAYMENT" => "/personal/order/payment/",
			"PAY_SYSTEMS" => array(
				0 => "10",
			),
			"PERSON_TYPE_ID" => "1",
			"PRICE_CODE" => array(
				0 => "BASE",
			),
			"SEND_MAIL" => "N",
			"SEND_MAIL_REQ" => "N",
			"SHOW_DELIVERY" => "N",
			"SHOW_OFFERS_FIRST_STEP" => "N",
			"SHOW_PAY_SYSTEM" => "N",
			"SHOW_PROPERTIES" => array(
				0 => "1",
			),
			"SHOW_PROPERTIES_REQUIRED" => array(
				0 => "1",
			),
			"SHOW_QUANTITY" => "Y",
			"SHOW_USER_DESCRIPTION" => "Y",
			"SUCCESS_ADD_MESS" => "",
			"SUCCESS_HEAD_MESS" => "",
			"USER_CONSENT" => "N",
			"USER_CONSENT_ID" => "0",
			"USER_CONSENT_IS_CHECKED" => "N",
			"USER_CONSENT_IS_LOADED" => "N",
			"USER_DATA_FIELDS" => array(
				0 => "EMAIL",
				1 => "PERSONAL_PHONE",
			),
			"USER_DATA_FIELDS_REQUIRED" => array(
				0 => "PERSONAL_PHONE",
			),
			"USE_CAPTCHA" => "N",
			"USE_OLD_CLASS" => "N",
			"COMPONENT_TEMPLATE" => ".default"
		),
		false
	);/**/
	?>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>