<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();





/* ===================================================================== */

/*                                MV                                     */

/* ===================================================================== */





$this->setFrameMode(true);
$templateLibrary = array('popup');
$currencyList = '';
if (!empty($arResult['CURRENCIES'])) {
    $templateLibrary[] = 'currency';
    $currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}
$templateData = array(
    'TEMPLATE_THEME' => $this->GetFolder() . '/themes/' . $arParams['TEMPLATE_THEME'] . '/style.css',
    'TEMPLATE_CLASS' => 'bx_' . $arParams['TEMPLATE_THEME'],
    'TEMPLATE_LIBRARY' => $templateLibrary,
    'CURRENCIES' => $currencyList
);
unset($currencyList, $templateLibrary);

$strMainID = $this->GetEditAreaId($arResult['ID']);
$arItemIDs = array(
    'ID' => $strMainID,
    'PICT' => $strMainID . '_pict',
    'DISCOUNT_PICT_ID' => $strMainID . '_dsc_pict',
    'STICKER_ID' => $strMainID . '_stricker',
    'BIG_SLIDER_ID' => $strMainID . '_big_slider',
    'SLIDER_CONT_ID' => $strMainID . '_slider_cont',
    'SLIDER_LIST' => $strMainID . '_slider_list',
    'SLIDER_LEFT' => $strMainID . '_slider_left',
    'SLIDER_RIGHT' => $strMainID . '_slider_right',
    'OLD_PRICE' => $strMainID . '_old_price',
    'PRICE' => $strMainID . '_price',
    'DISCOUNT_PRICE' => $strMainID . '_price_discount',
    'SLIDER_CONT_OF_ID' => $strMainID . '_slider_cont_',
    'SLIDER_LIST_OF_ID' => $strMainID . '_slider_list_',
    'SLIDER_LEFT_OF_ID' => $strMainID . '_slider_left_',
    'SLIDER_RIGHT_OF_ID' => $strMainID . '_slider_right_',
    'QUANTITY' => $strMainID . '_quantity',
    'QUANTITY_DOWN' => $strMainID . '_quant_down',
    'QUANTITY_UP' => $strMainID . '_quant_up',
    'QUANTITY_MEASURE' => $strMainID . '_quant_measure',
    'QUANTITY_LIMIT' => $strMainID . '_quant_limit',
    'BUY_LINK' => $strMainID . '_buy_link',
    'ADD_BASKET_LINK' => $strMainID . '_add_basket_link',
    'COMPARE_LINK' => $strMainID . '_compare_link',
    'PROP' => $strMainID . '_prop_',
    'PROP_DIV' => $strMainID . '_skudiv',
    'DISPLAY_PROP_DIV' => $strMainID . '_sku_prop',
    'OFFER_GROUP' => $strMainID . '_set_group_',
    'ZOOM_DIV' => $strMainID . '_zoom_cont',
    'ZOOM_PICT' => $strMainID . '_zoom_pict'
);
$strObName = 'ob' . preg_replace("/[^a-zA-Z0-9_]/i", "x", $strMainID);

?>
<? //if($USER->IsAdmin()) {echo '<pre>'; print_r($arResult); echo '</pre>';}?>


<div class="bx_item_detail" id="<? echo $arItemIDs['ID']; ?>">
    <h1>
        <?
        if ('Y' == $arParams['USE_VOTE_RATING']) {
            ?>
            <?
            $APPLICATION->IncludeComponent(
                "bitrix:iblock.vote",
                "stars",
                array(
                    "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
                    "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                    "ELEMENT_ID" => $arResult['ID'],
                    "ELEMENT_CODE" => "",
                    "MAX_VOTE" => "5",
                    "VOTE_NAMES" => array("1", "2", "3", "4", "5"),
                    "SET_STATUS_404" => "N",
                    "DISPLAY_AS_RATING" => $arParams['VOTE_DISPLAY_AS_RATING'],
                    "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                    "CACHE_TIME" => $arParams['CACHE_TIME']
                ),
                $component,
                array("HIDE_ICONS" => "Y")
            ); ?>
            <?
        }
        ?>
        <a style="font-size: 15px; font-weight: bold"><? echo $arResult['NAME']; ?></a>
    </h1>

    <!-- ASDSA-start image container -->
    <div class="bx_item_container">
        <div class="bx_lt">
            <div class="bx_item_slider" id="<? echo $arItemIDs['BIG_SLIDER_ID']; ?>">
                <div class="bx_bigimages">
                    <!-- Edit- 27-11-2017 -->
                    <div class="bx_bigimages_imgcontainer" data-toggle="modal" data-target="#b-modal-big-img-show">
                        <span class="bx_bigimages_aligner"></span>
                        <img
                                id="<? echo $arItemIDs['PICT']; ?>"
                                src="<? echo $arResult['DETAIL_PICTURE']['SRC']; ?>"
                                alt="<?= $arResult["DETAIL_PICTURE"]["ALT"] ?>"
                                title="<?= $arResult["DETAIL_PICTURE"]["TITLE"] ?>"
                                id="image_<?= $arResult["DETAIL_PICTURE"]["ID"] ?>"
                        >
                        <?
                        if ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']) {
                            ?>
                            <div class="bx_stick_disc" id="<? echo $arItemIDs['DISCOUNT_PICT_ID'] ?>"
                                 style="display: none;"></div>
                            <?
                        }
                        if ($arResult['LABEL']) {
                            ?>
                            <div class="bx_stick new"
                                 id="<? echo $arItemIDs['STICKER_ID'] ?>"><? echo $arResult['LABEL_VALUE']; ?></div>
                            <?
                        };
                        // Edit- modal window 
                        $bxListBigImages = "<div class='item active'><img class='b_modal_images' src='".
                            $arResult['DETAIL_PICTURE']['SRC']."'></div>"; 
                        ?>                        
                    </div>
                </div>

                <?
                    // если свойство MORE_PHOTO2 заполнено - отобразить дополнительные картинки MORE_PHOTO2
                    /* if(isset($arResult["PROPERTIES"]["MORE_PHOTO2"]["VALUE"]) && is_array($arResult["PROPERTIES"]["MORE_PHOTO2"]["VALUE"]))
                       {

                        $morePhoto2 = array();
                        $morePhoto2 = $arResult["PROPERTIES"]["MORE_PHOTO2"]["VALUE"];
                        $morePhoto2count = count($morePhoto2);

                        if (5 < $morePhoto2count)
                            {
                                $strClass = 'bx_slider_conteiner full';
                                $strOneWidth = (100/$morePhoto2count).'%';
                                $strWidth = (20*$morePhoto2count).'%';
                                $strSlideStyle = '';
                            }
                            else
                            {
                                $strClass = 'bx_slider_conteiner';
                                $strOneWidth = '20%';
                                $strWidth = '100%';
                                $strSlideStyle = 'display: none;';
                            }
                    ?>
                    <div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['SLIDER_CONT_ID']; ?>">
                        <div class="bx_slider_scroller_container">
                            <div class="bx_slide">
                                <ul style="width: <? echo $strWidth; ?>;" id="<? echo $arItemIDs['SLIDER_LIST']; ?>">
                                    <?
                                        foreach($morePhoto2 as $arPhoto)
                                        {
                                            $oneMoreFoto2 = CFile::GetFileArray($arPhoto);
                                    ?>
                                            <li style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>;"><a href="javascript:void(0)"><span style="background-image:url('<? echo $oneMoreFoto2['SRC']; ?>');"></span></a></li>
                                    <?
                                        }
                    } // < ---- end if isset
                            unset($morePhoto2);
                    ?>
                                </ul>
                            </div>
                                <div class="bx_slide_left" id="<? echo $arItemIDs['SLIDER_LEFT']; ?>" style="<? echo $strSlideStyle; ?>"></div>
                                <div class="bx_slide_right" id="<? echo $arItemIDs['SLIDER_RIGHT']; ?>" style="<? echo $strSlideStyle; ?>"></div>
                        </div>
                    </div>

                    <? */
                    // если свойство MORE_PHOTO2 заполнено - отобразить дополнительные картинки MORE_PHOTO2
                ?>

                <?
                if ($arResult['SHOW_SLIDER']) {
                    if (!isset($arResult['OFFERS']) || empty($arResult['OFFERS'])) {
                        if (5 < $arResult['MORE_PHOTO_COUNT']) {
                            $strClass = 'bx_slider_conteiner full';
                            $strOneWidth = (100 / $arResult['MORE_PHOTO_COUNT']) . '%';
                            $strWidth = (20 * $arResult['MORE_PHOTO_COUNT']) . '%';
                            $strSlideStyle = '';
                        } else {
                            $strClass = 'bx_slider_conteiner';
                            $strOneWidth = '20%';
                            $strWidth = '100%';
                            $strSlideStyle = 'display: none;';
                        }
                        ?>
                        <div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['SLIDER_CONT_ID']; ?>">
                            <div class="bx_slider_scroller_container">
                                <div class="bx_slide">
                                    <ul style="width: <? echo $strWidth; ?>;"
                                        id="<? echo $arItemIDs['SLIDER_LIST']; ?>">                                        
                                        <li style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>;">
                                            <a href="javascript:void(0)">
                                                <span data-src="<? echo $arResult['DETAIL_PICTURE']['SRC']; ?>" 
                                                    style="background-image:url('<? echo $arResult['DETAIL_PICTURE']['SRC']; ?>');">
                                                </span>
                                            </a>
                                        </li>
                                        <?                                        
                                        foreach ($arResult['MORE_PHOTO'] as &$arOnePhoto) {
                                            ?>
                                            <li style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>;">
                                                <a href="javascript:void(0)">
                                                    <span data-src="<? echo $arOnePhoto['SRC']; ?>" 
                                                        style="background-image:url('<? echo $arOnePhoto['SRC']; ?>');">
                                                    </span>
                                                </a>
                                            </li>
                                            <?
                                            // Edit- modal window
                                            $bxListBigImages = $bxListBigImages."<div class='item'><img class='b_modal_images' src='".$arOnePhoto['SRC']."'></div>";
                                        }
                                        unset($arOnePhoto);
                                        ?>
                                    </ul>
                                </div>
                                <div class="bx_slide_left" id="<? echo $arItemIDs['SLIDER_LEFT']; ?>"
                                     style="<? echo $strSlideStyle; ?>"></div>
                                <div class="bx_slide_right" id="<? echo $arItemIDs['SLIDER_RIGHT']; ?>"
                                     style="<? echo $strSlideStyle; ?>"></div>
                            </div>
                        </div>
                        <?
                    } else {
                        foreach ($arResult['OFFERS'] as $key => $arOneOffer) {
                            if (!isset($arOneOffer['MORE_PHOTO_COUNT']) || 0 >= $arOneOffer['MORE_PHOTO_COUNT'])
                                continue;
                            $strVisible = ($key == $arResult['OFFERS_SELECTED'] ? '' : 'none');
                            if (5 < $arOneOffer['MORE_PHOTO_COUNT']) {
                                $strClass = 'bx_slider_conteiner full';
                                $strOneWidth = (100 / $arOneOffer['MORE_PHOTO_COUNT']) . '%';
                                $strWidth = (20 * $arOneOffer['MORE_PHOTO_COUNT']) . '%';
                                $strSlideStyle = '';
                            } else {
                                $strClass = 'bx_slider_conteiner';
                                $strOneWidth = '20%';
                                $strWidth = '100%';
                                $strSlideStyle = 'display: none;';
                            }
                            ?>
                            <div class="<? echo $strClass; ?>"
                                 id="<? echo $arItemIDs['SLIDER_CONT_OF_ID'] . $arOneOffer['ID']; ?>"
                                 style="display: <? echo $strVisible; ?>;">
                                <div class="bx_slider_scroller_container">
                                    <div class="bx_slide">
                                        <ul style="width: <? echo $strWidth; ?>;"
                                            id="<? echo $arItemIDs['SLIDER_LIST_OF_ID'] . $arOneOffer['ID']; ?>">
                                            <?
                                            foreach ($arOneOffer['MORE_PHOTO'] as &$arOnePhoto) {
                                                ?>
                                                <li data-value="<? echo $arOneOffer['ID'] . '_' . $arOnePhoto['ID']; ?>"
                                                    style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>">
                                                    <a href="javascript:void(0)"><span
                                                                style="background-image:url('<? echo $arOnePhoto['SRC']; ?>');"></span></a>
                                                </li>
                                                <?
                                            }
                                            unset($arOnePhoto);
                                            ?>
                                        </ul>
                                    </div>
                                    <div class="bx_slide_left"
                                         id="<? echo $arItemIDs['SLIDER_LEFT_OF_ID'] . $arOneOffer['ID'] ?>"
                                         style="<? echo $strSlideStyle; ?>"
                                         data-value="<? echo $arOneOffer['ID']; ?>"></div>
                                    <div class="bx_slide_right"
                                         id="<? echo $arItemIDs['SLIDER_RIGHT_OF_ID'] . $arOneOffer['ID'] ?>"
                                         style="<? echo $strSlideStyle; ?>"
                                         data-value="<? echo $arOneOffer['ID']; ?>"></div>
                                </div>
                            </div>
                            <?
                        }
                    }
                }
                ?>
            </div>
        </div>        
        
        <!-- Modal -->
        <div id="b-modal-big-img-show" class="fade b_modal_big_imag_show" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span class="glyphicon glyphicon-remove"></span>                            
                        </button>
                        <h4 class="modal-title">
                            <a style="font-size: 15px; font-weight: bold"><? echo $arResult['NAME']; ?></a>
                        </h4>
                    </div>
                    <div class="modal-body">
                                                        
                            <!-- Slider -->
                            <div id="myCarousel_slider" class="carousel slide" data-ride="carousel" data-interval="false"> 
                                <!-- Wrapper for slides -->
                                <div class="carousel-inner">
                                  <? echo $bxListBigImages; ?>
                                  <!-- Left and right controls -->
                                  <a class="left carousel-control" href="#myCarousel_slider" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left"></span>                                    
                                  </a>
                                  <a class="right carousel-control" href="#myCarousel_slider" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right"></span>                                    
                                  </a>
                                </div>
                            </div>
                        
                    </div>
                </div>            
            </div>
        </div>

        <script>
            ;
            (function(){                
                try 
                {
                    // 1. show image in container                
                    var bxPict = document.getElementById('<? echo $arItemIDs['PICT']; ?>'),                    
                        bxSliderList = document.getElementById('<? echo $arItemIDs['SLIDER_LIST']; ?>');
                    if (bxSliderList != null ){
                        var bxSliderListImg = bxSliderList.getElementsByTagName('SPAN'),
                            i, l = bxSliderListImg.length;
                        for(i = 0; i < l; i++){
                            bxSliderListImg[i].onmouseover = function(event){
                                bxPict.src = event.target.getAttribute('data-src');
                            };
                        };
                    };

                    // 2. modal window resize              
                    var bModalBigImgShow = document.getElementById('b-modal-big-img-show'),
                        bModalBigImgShow_Dialogwh = bModalBigImgShow.getElementsByClassName('modal-dialog')[0],
                        bModalBigImgShow_Contentwh = bModalBigImgShow.getElementsByClassName('modal-content')[0],
                        bModalBigImgShow_carouselInner = bModalBigImgShow.getElementsByClassName('carousel-inner')[0],
                        bModalBigImgShow_img = bModalBigImgShow_carouselInner.getElementsByTagName('IMG'),
                        bxBigimagesImgcontainer = document.getElementsByClassName('bx_bigimages_imgcontainer')[0];

                    window.addEventListener("resize", setWindowsSize);
                    function setWindowsSize(event){
                        bModalBigImgShow_Dialogwh.style.width = window.innerWidth-40 + 'px';
                        bModalBigImgShow_Contentwh.style.height = window.innerHeight-40 + 'px';                    
                        bModalBigImgShow_carouselInner.style.height = window.innerHeight-130 + 'px';
                        adaptiveImageSize();
                    };
                    $(document).ready(function() {
                        bModalBigImgShow_Dialogwh.style.width = window.innerWidth-40 + 'px';
                        bModalBigImgShow_Contentwh.style.height = window.innerHeight-40 + 'px';                    
                        bModalBigImgShow_carouselInner.style.height = window.innerHeight-130 + 'px';                    
                    });                                

                    bxBigimagesImgcontainer.onclick = function(){                      
                        adaptiveImageSize(); 
                    };
                    
                    // 3. image resize 
                    function adaptiveImageSize(){
                        $('.carousel-inner img').each(function() {
                            var ch = bModalBigImgShow_carouselInner.style.height;                        
                                ch = parseInt(ch.replace("px", ""));
                            var cw = bModalBigImgShow_Dialogwh.style.width;
                                cw = parseInt(cw.replace("px", ""));

                            var maxWidth = cw;
                            var maxHeight = ch;
                            var ratio = 0;
                            var width = $(this).prop('naturalWidth');
                            var height = $(this).prop('naturalHeight');

                            if(width > maxWidth){
                                ratio = maxWidth / width;
                                $(this).css("width", maxWidth);
                                $(this).css("height", height * ratio);
                                height = height * ratio;
                                width = width * ratio;
                            }
                            
                            if(height > maxHeight){
                                ratio = maxHeight / height;
                                $(this).css("height", maxHeight);
                                $(this).css("width", width * ratio);
                                width = width * ratio;
                                height = height * ratio;
                            }

                            $(this).css("margin-top", Math.round((maxHeight-height)/2) );
                        });
                    };
                    console.log('AS-function Slider: Start');
                }
                catch(err) {
                    console.log('AS-function Slider Error: ' + err.message);
                };
            })();   
        </script>
        <!-- ASDSA-end image container -->

        <div class="bx_rt">
            <div class="item_price">
                <table>
                    <tr>
                        <td style="width: 275px; padding-top: 18px;">
                            <div class="item_price_arhi">Цена:</div>
                            <?
                            $boolDiscountShow = (0 < $arResult['MIN_PRICE']['DISCOUNT_DIFF']);
                            ?>
                            <div class="item_old_price" id="<? echo $arItemIDs['OLD_PRICE']; ?>"
                                 style="display: <? echo($boolDiscountShow ? '' : 'none'); ?>"><? echo($boolDiscountShow ? $arResult['MIN_PRICE']['PRINT_VALUE'] : ''); ?></div>
                            <? if (($arResult['MIN_PRICE']['DISCOUNT_VALUE']) == ($arResult['MIN_PRICE']['VALUE'])) {
                                ?>
                                <div class="item_current_price_all"
                                     id="<? echo $arItemIDs['PRICE']; ?>"><? echo $arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE']; ?></div>
                                <div style="font-size: 10px; padding-left: 10px;"><b>при покупке в интернет магазине</b>
                                </div>
                                <?
                            } else {
                                ?>
                                <div class="item_current_price_arhi"
                                     id="<? echo $arItemIDs['PRICE']; ?>"><? echo $arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE']; ?></div>
                                <div style="font-size: 10px;padding-left: 10px;"><b>при покупке в интернет магазине</b>
                                </div>
                                <?
                            };
                            ?>
                            <div class="item_economy_price" id="<? echo $arItemIDs['DISCOUNT_PRICE']; ?>"
                                 style="display: <? echo($boolDiscountShow ? '' : 'none'); ?>"><? echo($boolDiscountShow ? GetMessage('ECONOMY_INFO', array('#ECONOMY#' => $arResult['MIN_PRICE']['PRINT_DISCOUNT_DIFF'])) : ''); ?></div>
                        </td>
                        <td style="vertical-align: top;">
                            <!-- КУПИТЬ-->
                            <div class="item_info_section_nosku">
                                <?
                                if ((isset($arResult['OFFERS']) && !empty($arResult['OFFERS'])) || $arResult["CAN_BUY"]) {
                                    if ('Y' == $arParams['USE_PRODUCT_QUANTITY']) {
                                        ?>
                                        <span class="item_section_name_gray"><? echo GetMessage('CATALOG_QUANTITY'); ?></span>
                                        <div class="item_buttons vam">
                                            <span class="item_buttons_counter_block">
                                                <a href="javascript:void(0)" class="bx_bt_white bx_small bx_fwb"
                                                   id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>">-</a>
                                                <input id="<? echo $arItemIDs['QUANTITY']; ?>" type="text"
                                                       class="tac transparent_input"
                                                       style="display: inline-block;width: 20px;"
                                                       value="<? echo(isset($arResult['OFFERS']) && !empty($arResult['OFFERS'])
                                                           ? 1
                                                           : $arResult['CATALOG_MEASURE_RATIO']
                                                       ); ?>">
                                                <a href="javascript:void(0)" class="bx_bt_white bx_small bx_fwb"
                                                   id="<? echo $arItemIDs['QUANTITY_UP']; ?>">+</a>
                                                <span id="<? echo $arItemIDs['QUANTITY_MEASURE']; ?>"><? echo(isset($arResult['CATALOG_MEASURE_NAME']) ? $arResult['CATALOG_MEASURE_NAME'] : ''); ?></span>
                                            </span>
                                            <span class="item_buttons_counter_block">
                                                <a href="javascript:void(0);" class="bx_big bx_bt_blue bx_cart"
                                                   id="<? echo $arItemIDs['BUY_LINK']; ?>"><!--<span></span>--><? echo('' != $arParams['MESS_BTN_ADD_TO_BASKET']
                                                        ? $arParams['MESS_BTN_ADD_TO_BASKET']
                                                        : GetMessage('CT_BCE_CATALOG_ADD')
                                                    ); ?>
                                                </a>
                                                <?
                                                if ('Y' == $arParams['DISPLAY_COMPARE']) {
                                                    ?>
                                                    <a href="javascript:void(0)" class="bx_big bx_bt_white bx_cart"
                                                       style="margin-left: 10px"><? echo('' != $arParams['MESS_BTN_COMPARE']
                                                            ? $arParams['MESS_BTN_COMPARE']
                                                            : GetMessage('CT_BCE_CATALOG_COMPARE')
                                                        ); ?>
                                                        </a>
                                                    <?
                                                }
                                                ?>
                                            </span>
                                        </div>
                                        <?
                                        if ('Y' == $arParams['SHOW_MAX_QUANTITY']) {
                                            if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS'])) {
                                                ?>
                                                <p id="<? echo $arItemIDs['QUANTITY_LIMIT']; ?>"
                                                   style="display: none;"><? echo GetMessage('OSTATOK'); ?>:
                                                    <span></span></p>
                                                <?
                                            } else {
                                                if ('Y' == $arResult['CATALOG_QUANTITY_TRACE'] && 'N' == $arResult['CATALOG_CAN_BUY_ZERO']) {
                                                    ?>
                                                    <p id="<? echo $arItemIDs['QUANTITY_LIMIT']; ?>"><? echo GetMessage('OSTATOK'); ?>
                                                        : <span><? $arResult['CATALOG_QUANTITY']; ?></span></p>
                                                    <?
                                                }
                                            }
                                        }
                                    } else {
                                        ?>
                                        <div class="item_buttons vam">
                                            <span class="item_buttons_counter_block">
                                                <a href="javascript:void(0);" class="bx_big bx_bt_blue bx_cart"
                                                   id="<? echo $arItemIDs['BUY_LINK']; ?>"><span></span><? echo('' != $arParams['MESS_BTN_ADD_TO_BASKET']
                                                        ? $arParams['MESS_BTN_ADD_TO_BASKET']
                                                        : GetMessage('CT_BCE_CATALOG_ADD')
                                                    ); ?>
                                                </a>
                                                <?
                                                if ('Y' == $arParams['DISPLAY_COMPARE']) {
                                                    ?>
                                                    <a id="<? echo $arItemIDs['COMPARE_LINK']; ?>"
                                                       href="javascript:void(0)" class="bx_big bx_bt_white bx_cart"
                                                       style="margin-left: 10px"><? echo('' != $arParams['MESS_BTN_COMPARE']
                                                            ? $arParams['MESS_BTN_COMPARE']
                                                            : GetMessage('CT_BCE_CATALOG_COMPARE')
                                                        ); ?>
                                                    </a>
                                                    <?
                                                }
                                                ?>
                                            </span>
                                        </div>
                                        <?
                                    }
                                } else {
                                }
                                ?>
                            </div>
                            <!-- КУПИТЬ-->
                        </td>
                    </tr>
                </table>

                <? $APPLICATION->IncludeComponent(
                    "altasib:feedback.form",
                    "",
                    Array(
                        "ACTIVE_ELEMENT" => "Y",
                        "ADD_HREF_LINK" => "Y",
                        "ALX_LINK_POPUP" => "Y",
                        "ALX_LOAD_PAGE" => "N",
                        "ALX_NAME_LINK" => "Нашли дешевле? Снизим цену!",
                        "BBC_MAIL" => "",
                        "CAPTCHA_TYPE" => "default",
                        "CATEGORY_SELECT_NAME" => "Выберите категорию",
                        "CHANGE_CAPTCHA" => "N",
                        "CHECKBOX_TYPE" => "CHECKBOX",
                        "CHECK_ERROR" => "Y",
                        "COLOR_SCHEME" => "BRIGHT",
                        "COLOR_THEME" => "",
                        "EVENT_TYPE" => "ALX_FEEDBACK_FORM",
                        "FB_TEXT_NAME" => "",
                        "FB_TEXT_SOURCE" => "DETAIL_TEXT",
                        "FORM_ID" => "1",
                        "IBLOCK_ID" => "81",
                        "IBLOCK_TYPE" => "altasib_feedback",
                        "INPUT_APPEARENCE" => array("DEFAULT"),
                        "JQUERY_EN" => "jquery",
                        "LINK_SEND_MORE_TEXT" => "Отправить ещё одно сообщение",
                        "LOCAL_REDIRECT_ENABLE" => "N",
                        "MASKED_INPUT_PHONE" => array("PHONE"),
                        "MESSAGE_OK" => "Ваше сообщение было успешно отправлено",
                        "NAME_ELEMENT" => "ALX_DATE",
                        "NOT_CAPTCHA_AUTH" => "Y",
                        "POPUP_ANIMATION" => "0",
                        "PROPERTY_FIELDS" => array("PHONE", "FEEDBACK_TEXT"),
                        "PROPERTY_FIELDS_REQUIRED" => array("PHONE", "FEEDBACK_TEXT"),
                        "PROPS_AUTOCOMPLETE_EMAIL" => array("EMAIL"),
                        "PROPS_AUTOCOMPLETE_NAME" => array("FIO"),
                        "PROPS_AUTOCOMPLETE_PERSONAL_PHONE" => array("PHONE"),
                        "PROPS_AUTOCOMPLETE_VETO" => "N",
                        "SECTION_FIELDS_ENABLE" => "N",
                        "SECTION_MAIL_ALL" => "chuga_a@ukr.net",
                        "SEND_IMMEDIATE" => "Y",
                        "SEND_MAIL" => "N",
                        "SHOW_LINK_TO_SEND_MORE" => "N",
                        "SHOW_MESSAGE_LINK" => "Y",
                        "USERMAIL_FROM" => "N",
                        "USER_CONSENT" => "",
                        "USER_CONSENT_INPUT_LABEL" => "",
                        "USE_CAPTCHA" => "Y",
                        "WIDTH_FORM" => "50%"
                    )
                ); ?>
            </div>
            <br>
            <img src="/bitrix/templates/bis/images/payment_button.png" alt="">
        </div>
        <?
        if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS']) {
            ?>
            <div class="item_info_section">
                <?
                if (!empty($arResult['DISPLAY_PROPERTIES'])) {
                    ?>
                    <dl>
                        <?
                        foreach ($arResult['DISPLAY_PROPERTIES'] as &$arOneProp) {
                            ?>
                            <dt><? echo $arOneProp['NAME']; ?>:&nbsp;</dt>
                            <dd><?
                                echo(
                                is_array($arOneProp['DISPLAY_VALUE'])
                                    ? implode(' / ', $arOneProp['DISPLAY_VALUE'])
                                    : $arOneProp['DISPLAY_VALUE']
                                );
                                ?>
                            </dd>
                            <?
                        }
                        unset($arOneProp);
                        ?>
                    </dl>
                    <?
                }
                if ($arResult['SHOW_OFFERS_PROPS']) {
                    ?>
                    <ul id="<? echo $arItemIDs['DISPLAY_PROP_DIV'] ?>" style="display: none;"></ul>
                    <?
                }
                ?>
            </div>
            <?
        }
        if ('' != $arResult['PREVIEW_TEXT']) {
            ?>
            <!-- <div class="item_info_section">
                <?
            echo('html' == $arResult['PREVIEW_TEXT_TYPE'] ? $arResult['PREVIEW_TEXT'] : '<p>' . $arResult['PREVIEW_TEXT'] . '</p>');
            ?>
                </div>  -->
            <?
        }
        if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']) && !empty($arResult['OFFERS_PROP'])) {
            $arSkuProps = array();
            ?>
            <div class="item_info_section" style="padding-right:150px;" id="<? echo $arItemIDs['PROP_DIV']; ?>">
                <?
                foreach ($arResult['SKU_PROPS'] as &$arProp) {
                    if (!isset($arResult['OFFERS_PROP'][$arProp['CODE']]))
                        continue;
                    $arSkuProps[] = array(
                        'ID' => $arProp['ID'],
                        'TYPE' => $arProp['PROPERTY_TYPE'],
                        'VALUES_COUNT' => $arProp['VALUES_COUNT']
                    );
                    if ('L' == $arProp['PROPERTY_TYPE']) {
                        if (5 < $arProp['VALUES_COUNT']) {
                            $strClass = 'bx_item_detail_size full';
                            $strOneWidth = (100 / $arProp['VALUES_COUNT']) . '%';
                            $strWidth = (20 * $arProp['VALUES_COUNT']) . '%';
                            $strSlideStyle = '';
                        } else {
                            $strClass = 'bx_item_detail_size';
                            $strOneWidth = '20%';
                            $strWidth = '100%';
                            $strSlideStyle = 'display: none;';
                        }
                        ?>
                        <div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['PROP'] . $arProp['ID']; ?>_cont">
                            <span class="bx_item_section_name_gray"><? echo htmlspecialcharsex($arProp['NAME']); ?></span>
                            <div class="bx_size_scroller_container">
                                <div class="bx_size">
                                    <ul id="<? echo $arItemIDs['PROP'] . $arProp['ID']; ?>_list"
                                        style="width: <? echo $strWidth; ?>;margin-left:0%;">
                                        <?
                                        foreach ($arProp['VALUES'] as $arOneValue) {
                                            ?>
                                            <li
                                                    data-treevalue="<? echo $arProp['ID'] . '_' . $arOneValue['ID']; ?>"
                                                    data-onevalue="<? echo $arOneValue['ID']; ?>"
                                                    style="width: <? echo $strOneWidth; ?>;"
                                            ><span></span>
                                                <a href="javascript:void(0)"><? echo htmlspecialcharsex($arOneValue['NAME']); ?></a>
                                            </li>
                                            <?
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <div class="bx_slide_left" style="<? echo $strSlideStyle; ?>"
                                     id="<? echo $arItemIDs['PROP'] . $arProp['ID']; ?>_left"
                                     data-treevalue="<? echo $arProp['ID']; ?>"></div>
                                <div class="bx_slide_right" style="<? echo $strSlideStyle; ?>"
                                     id="<? echo $arItemIDs['PROP'] . $arProp['ID']; ?>_right"
                                     data-treevalue="<? echo $arProp['ID']; ?>"></div>
                            </div>
                        </div>
                        <?
                    } elseif ('E' == $arProp['PROPERTY_TYPE']) {
                        if (5 < $arProp['VALUES_COUNT']) {
                            $strClass = 'bx_item_detail_scu full';
                            $strOneWidth = (100 / $arProp['VALUES_COUNT']) . '%';
                            $strWidth = (20 * $arProp['VALUES_COUNT']) . '%';
                            $strSlideStyle = '';
                        } else {
                            $strClass = 'bx_item_detail_scu';
                            $strOneWidth = '20%';
                            $strWidth = '100%';
                            $strSlideStyle = 'display: none;';
                        }
                        ?>
                        <div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['PROP'] . $arProp['ID']; ?>_cont">
                            <span class="bx_item_section_name_gray"><? echo htmlspecialcharsex($arProp['NAME']); ?></span>
                            <div class="bx_scu_scroller_container">
                                <div class="bx_scu">
                                    <ul id="<? echo $arItemIDs['PROP'] . $arProp['ID']; ?>_list"
                                        style="width: <? echo $strWidth; ?>;margin-left:0%;">
                                        <?
                                        foreach ($arProp['VALUES'] as $arOneValue) {
                                            ?>
                                            <li
                                                    data-treevalue="<? echo $arProp['ID'] . '_' . $arOneValue['ID'] ?>"
                                                    data-onevalue="<? echo $arOneValue['ID']; ?>"
                                                    style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>;"
                                            ><span></span>
                                                <a href="javascript:void(0)"><span
                                                            style="background-image:url('<? echo $arOneValue['PICT']['SRC']; ?>');"></span></a>
                                            </li>
                                            <?
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <div class="bx_slide_left" style="<? echo $strSlideStyle; ?>"
                                     id="<? echo $arItemIDs['PROP'] . $arProp['ID']; ?>_left"
                                     data-treevalue="<? echo $arProp['ID']; ?>"></div>
                                <div class="bx_slide_right" style="<? echo $strSlideStyle; ?>"
                                     id="<? echo $arItemIDs['PROP'] . $arProp['ID']; ?>_right"
                                     data-treevalue="<? echo $arProp['ID']; ?>"></div>
                            </div>
                        </div>
                        <?
                    }
                }
                unset($arProp);
                ?>
            </div>
            <?
        }
        ?>

        <?/*
            <!-- Перенесено к ЦЕНЕ
                                                <div class="item_info_section_nosku">
                                                <?
            if ((isset($arResult['OFFERS']) && !empty($arResult['OFFERS'])) || $arResult["CAN_BUY"]) {
                if ('Y' == $arParams['USE_PRODUCT_QUANTITY']) {
                    ?>
                                                    <span class="item_section_name_gray"><? echo GetMessage('CATALOG_QUANTITY'); ?></span>
                                                    <div class="item_buttons vam">
                                                        <span class="item_buttons_counter_block">
                                                            <a href="javascript:void(0)" class="bx_bt_white bx_small bx_fwb" id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>">-</a>
                                                            <input id="<? echo $arItemIDs['QUANTITY']; ?>" type="text" class="tac transparent_input" style="display: inline-block;width: 20px;" value="<? echo(isset($arResult['OFFERS']) && !empty($arResult['OFFERS'])
                        ? 1
                        : $arResult['CATALOG_MEASURE_RATIO']
                    ); ?>">
                                                            <a href="javascript:void(0)" class="bx_bt_white bx_small bx_fwb" id="<? echo $arItemIDs['QUANTITY_UP']; ?>">+</a>
                                                            <span id="<? echo $arItemIDs['QUANTITY_MEASURE']; ?>"><? echo(isset($arResult['CATALOG_MEASURE_NAME']) ? $arResult['CATALOG_MEASURE_NAME'] : ''); ?></span>
                                                        </span>
                                                        <span class="item_buttons_counter_block">
                                                            <a href="javascript:void(0);" class="bx_big bx_bt_blue bx_cart" id="<? echo $arItemIDs['BUY_LINK']; ?>"><span></span><? echo('' != $arParams['MESS_BTN_ADD_TO_BASKET']
                        ? $arParams['MESS_BTN_ADD_TO_BASKET']
                        : GetMessage('CT_BCE_CATALOG_ADD')
                    ); ?></a>
                                                <?
                    if ('Y' == $arParams['DISPLAY_COMPARE']) {
                        ?>
                                                            <a href="javascript:void(0)" class="bx_big bx_bt_white bx_cart" style="margin-left: 10px"><? echo('' != $arParams['MESS_BTN_COMPARE']
                            ? $arParams['MESS_BTN_COMPARE']
                            : GetMessage('CT_BCE_CATALOG_COMPARE')
                        ); ?></a>
                                                <?
                    }
                    ?>
                                                        </span>
                                                    </div>
                                                <?
                    if ('Y' == $arParams['SHOW_MAX_QUANTITY']) {
                        if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS'])) {
                            ?>
                                                    <p id="<? echo $arItemIDs['QUANTITY_LIMIT']; ?>" style="display: none;"><? echo GetMessage('OSTATOK'); ?>: <span></span></p>
                                                <?
                        } else {
                            if ('Y' == $arResult['CATALOG_QUANTITY_TRACE'] && 'N' == $arResult['CATALOG_CAN_BUY_ZERO']) {
                                ?>
                                                    <p id="<? echo $arItemIDs['QUANTITY_LIMIT']; ?>"><? echo GetMessage('OSTATOK'); ?>: <span><? $arResult['CATALOG_QUANTITY']; ?></span></p>
                                                <?
                            }
                        }
                    }
                } else {
                    ?>
                                                    <div class="item_buttons vam">
                                                        <span class="item_buttons_counter_block">
                                                            <a href="javascript:void(0);" class="bx_big bx_bt_blue bx_cart" id="<? echo $arItemIDs['BUY_LINK']; ?>"><span></span><? echo('' != $arParams['MESS_BTN_ADD_TO_BASKET']
                        ? $arParams['MESS_BTN_ADD_TO_BASKET']
                        : GetMessage('CT_BCE_CATALOG_ADD')
                    ); ?></a>
                                                <?
                    if ('Y' == $arParams['DISPLAY_COMPARE']) {
                        ?>
                                                            <a id="<? echo $arItemIDs['COMPARE_LINK']; ?>" href="javascript:void(0)" class="bx_big bx_bt_white bx_cart" style="margin-left: 10px"><? echo('' != $arParams['MESS_BTN_COMPARE']
                            ? $arParams['MESS_BTN_COMPARE']
                            : GetMessage('CT_BCE_CATALOG_COMPARE')
                        ); ?></a>
                                                <?
                    }
                    ?>
                                                        </span>
                                                    </div>
                                                <?
                }
            } else {


            }
            ?>

                                                </div> -->
            /**/
        ?>

        <div class="clb"></div>
    </div>
    <div class='delivery_payment'>
        <? $APPLICATION->IncludeComponent(
            "bitrix:main.include",
            "",
            Array(
                "AREA_FILE_RECURSIVE" => "Y",
                "AREA_FILE_SHOW" => "sect",
                "AREA_FILE_SUFFIX" => "sell_detail",
                "EDIT_TEMPLATE" => ""
            )
        ); ?>
    </div>
    <div class="bx_md">
        <div class="item_info_section">
            <?
            if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS'])) {
                if ($arResult['OFFER_GROUP']) {
                    foreach ($arResult['OFFERS'] as $arOffer) {
                        if (!$arOffer['OFFER_GROUP'])
                            continue;
                        ?>
                        <span id="<? echo $arItemIDs['OFFER_GROUP'] . $arOffer['ID']; ?>" style="display: none;">
                                <?
                                $APPLICATION->IncludeComponent("bitrix:catalog.set.constructor",
                                    ".default",
                                    array(
                                        "IBLOCK_ID" => $arResult["OFFERS_IBLOCK"],
                                        "ELEMENT_ID" => $arOffer['ID'],
                                        "PRICE_CODE" => $arParams["PRICE_CODE"],
                                        "BASKET_URL" => $arParams["BASKET_URL"],
                                        "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
                                        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                                        "CACHE_TIME" => $arParams["CACHE_TIME"],
                                        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                                    ),
                                    $component,
                                    array("HIDE_ICONS" => "Y")
                                ); ?>
                            </span>
                        <?
                    }
                }
            } else {
                ?><?
                $APPLICATION->IncludeComponent("bitrix:catalog.set.constructor",
                    ".default",
                    array(
                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                        "ELEMENT_ID" => $arResult["ID"],
                        "PRICE_CODE" => $arParams["PRICE_CODE"],
                        "BASKET_URL" => $arParams["BASKET_URL"],
                        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                        "CACHE_TIME" => $arParams["CACHE_TIME"],
                        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                    ),
                    $component,
                    array("HIDE_ICONS" => "Y")
                ); ?><?
            }
            ?>
        </div>
    </div>
    <div class="bx_rb">
        <div class="item_info_section">
            <?
            if ('' != $arResult['DETAIL_TEXT']) {
                ?>
                <div class="bx_item_description">
                    <div class="bx_item_section_name_gray"
                         style="border-bottom: 1px solid #f2f2f2;"><? echo GetMessage('FULL_DESCRIPTION'); ?></div>
                    <?
                    if ('html' == $arResult['DETAIL_TEXT_TYPE']) {
                        echo $arResult['DETAIL_TEXT'];
                    } else {
                        ?><p><? echo $arResult['DETAIL_TEXT']; ?></p><?
                    }
                    ?>
                </div>
                <?
            }
            ?>
        </div>
    </div>
    <div class="bx_lb">
        <div class="tac ovh">
            <? /*$APPLICATION->IncludeComponent(
                    "bitrix:catalog.socnets.buttons",
                    "",
                    array(
                        "URL_TO_LIKE" => $APPLICATION->GetCurPageParam(),
                        "TITLE" => "",
                        "DESCRIPTION" => "",
                        "IMAGE" => "",
                        "FB_USE" => "Y",
                        "TW_USE" => "Y",
                        "GP_USE" => "Y",
                        "VK_USE" => "Y",
                        "TW_VIA" => "",
                        "TW_HASHTAGS" => "",
                        "TW_RELATED" => ""
                    ),
                    $component,
                    array("HIDE_ICONS" => "Y")
                );*/ ?>
        </div>
        <div class="tab-section-container">
            <?
            if ('Y' == $arParams['USE_COMMENTS']) {
                ?>
                <?
                $APPLICATION->IncludeComponent(
                    "bitrix:catalog.comments",
                    "",
                    array(
                        "ELEMENT_ID" => $arResult['ID'],
                        "ELEMENT_CODE" => "",
                        "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                        "URL_TO_COMMENT" => "",
                        "WIDTH" => "",
                        "COMMENTS_COUNT" => "5",
                        "BLOG_USE" => $arParams['BLOG_USE'],
                        "FB_USE" => $arParams['FB_USE'],
                        "VK_USE" => $arParams['VK_USE'],
                        "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                        "CACHE_TIME" => $arParams['CACHE_TIME'],
                        "BLOG_TITLE" => "",
                        "BLOG_URL" => "",
                        "PATH_TO_SMILE" => "/bitrix/images/blog/smile/",
                        "EMAIL_NOTIFY" => "N",
                        "AJAX_POST" => "Y",
                        "SHOW_SPAM" => "Y",
                        "SHOW_RATING" => "N",
                        "FB_TITLE" => "",
                        "FB_USER_ADMIN_ID" => "",
                        "FB_APP_ID" => $arParams['FB_APP_ID'],
                        "FB_COLORSCHEME" => "light",
                        "FB_ORDER_BY" => "reverse_time",
                        "VK_TITLE" => "",
                        "VK_API_ID" => $arParams['VK_API_ID']
                    ),
                    $component,
                    array("HIDE_ICONS" => "Y")
                ); ?>
                <?
            }
            ?>
        </div>
    </div>
    <div style="clear: both;"></div>
</div>
<div class="clb"></div>
</div>

<?
if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS'])) {
    foreach ($arResult['JS_OFFERS'] as &$arOneJS) {
        if ($arOneJS['PRICE']['DISCOUNT_VALUE'] != $arOneJS['PRICE']['VALUE']) {
            $arOneJS['PRICE']['PRINT_DISCOUNT_DIFF'] = GetMessage('ECONOMY_INFO', array('#ECONOMY#' => $arOneJS['PRICE']['PRINT_DISCOUNT_DIFF']));
            $arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'];
        }
        $strProps = '';
        if ($arResult['SHOW_OFFERS_PROPS']) {
            if (!empty($arOneJS['DISPLAY_PROPERTIES'])) {
                foreach ($arOneJS['DISPLAY_PROPERTIES'] as $arOneProp) {
                    $strProps .= '<li><strong>' . $arOneProp['NAME'] . '</strong> ' . (
                        is_array($arOneProp['VALUE'])
                            ? implode(' / ', $arOneProp['VALUE'])
                            : $arOneProp['VALUE']
                        ) . '</li>';
                }
            }
        }
        $arOneJS['DISPLAY_PROPERTIES'] = $strProps;
    }
    if (isset($arOneJS))
        unset($arOneJS);
    $arJSParams = array(
        'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
        'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
        'SHOW_ADD_BASKET_BTN' => true,
        'SHOW_BUY_BTN' => false,
        'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
        'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
        'DISPLAY_COMPARE' => ('Y' == $arParams['DISPLAY_COMPARE']),
        'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
        'OFFER_GROUP' => $arResult['OFFER_GROUP'],
        'VISUAL' => array(
            'BIG_SLIDER_ID' => $arItemIDs['ID'],
            'ID' => $arItemIDs['ID'],
            'PICT_ID' => $arItemIDs['PICT'],
            'QUANTITY_ID' => $arItemIDs['QUANTITY'],
            'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
            'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
            'QUANTITY_MEASURE' => $arItemIDs['QUANTITY_MEASURE'],
            'QUANTITY_LIMIT' => $arItemIDs['QUANTITY_LIMIT'],
            'PRICE_ID' => $arItemIDs['PRICE'],
            'OLD_PRICE_ID' => $arItemIDs['OLD_PRICE'],
            'DISCOUNT_VALUE_ID' => $arItemIDs['DISCOUNT_PRICE'],
            'DISCOUNT_PERC_ID' => $arItemIDs['DISCOUNT_PICT_ID'],
            'NAME_ID' => $arItemIDs['NAME'],
            'TREE_ID' => $arItemIDs['PROP_DIV'],
            'TREE_ITEM_ID' => $arItemIDs['PROP'],
            'SLIDER_CONT_OF_ID' => $arItemIDs['SLIDER_CONT_OF_ID'],
            'SLIDER_LIST_OF_ID' => $arItemIDs['SLIDER_LIST_OF_ID'],
            'SLIDER_LEFT_OF_ID' => $arItemIDs['SLIDER_LEFT_OF_ID'],
            'SLIDER_RIGHT_OF_ID' => $arItemIDs['SLIDER_RIGHT_OF_ID'],
            'BUY_ID' => $arItemIDs['BUY_LINK'],
            'ADD_BASKET_ID' => $arItemIDs['ADD_BASKET_LINK'],
            'COMPARE_LINK_ID' => $arItemIDs['COMPARE_LINK'],
            'DISPLAY_PROP_DIV' => $arItemIDs['DISPLAY_PROP_DIV'],
            'OFFER_GROUP' => $arItemIDs['OFFER_GROUP'],
            'ZOOM_DIV' => $arItemIDs['ZOOM_DIV'],
            'ZOOM_PICT' => $arItemIDs['ZOOM_PICT']
        ),
        'DEFAULT_PICTURE' => array(
            'PREVIEW_PICTURE' => $arResult['PREVIEW_PICTURE'],
            'DETAIL_PICTURE' => $arResult['DETAIL_PICTURE']
        ),
        'OFFERS' => $arResult['JS_OFFERS'],
        'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
        'TREE_PROPS' => $arSkuProps,
        'AJAX_PATH' => POST_FORM_ACTION_URI,
        'MESS' => array(
            'ECONOMY_INFO' => GetMessage('ECONOMY_INFO')
        )
    );
} else {
    $arJSParams = array(
        'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
        'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
        'SHOW_ADD_BASKET_BTN' => true,
        'SHOW_BUY_BTN' => false,
        'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
        'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
        'DISPLAY_COMPARE' => ('Y' == $arParams['DISPLAY_COMPARE']),
        'VISUAL' => array(
            'BIG_SLIDER_ID' => $arItemIDs['ID'],
            'ID' => $arItemIDs['ID'],
            'PICT_ID' => $arItemIDs['PICT'],
            'QUANTITY_ID' => $arItemIDs['QUANTITY'],
            'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
            'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
            'PRICE_ID' => $arItemIDs['PRICE'],
            'OLD_PRICE_ID' => $arItemIDs['OLD_PRICE'],
            'DISCOUNT_VALUE_ID' => $arItemIDs['DISCOUNT_PRICE'],
            'DISCOUNT_PERC_ID' => $arItemIDs['DISCOUNT_PICT_ID'],
            'NAME_ID' => $arItemIDs['NAME'],
            'TREE_ID' => $arItemIDs['PROP_DIV'],
            'TREE_ITEM_ID' => $arItemIDs['PROP'],
            'SLIDER_CONT_OF_ID' => $arItemIDs['SLIDER_CONT_OF_ID'],
            'SLIDER_LIST_OF_ID' => $arItemIDs['SLIDER_LIST_OF_ID'],
            'SLIDER_LEFT_OF_ID' => $arItemIDs['SLIDER_LEFT_OF_ID'],
            'SLIDER_RIGHT_OF_ID' => $arItemIDs['SLIDER_RIGHT_OF_ID'],
            'BUY_ID' => $arItemIDs['BUY_LINK'],
            'ADD_BASKET_ID' => $arItemIDs['ADD_BASKET_LINK'],
            'COMPARE_LINK_ID' => $arItemIDs['COMPARE_LINK'],
        ),
        'PRODUCT' => array(
            'ID' => $arResult['ID'],
            'PICT' => $arResult['DETAIL_PICTURE'],
            'NAME' => $arResult['~NAME'],
            'SUBSCRIPTION' => true,
            'PRICE' => $arResult['MIN_PRICE'],
            'CAN_BUY' => $arResult['CAN_BUY'],
            'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
            'QUANTITY_FLOAT' => is_double($arResult['CATALOG_MEASURE_RATIO']),
            'MAX_QUANTITY' => $arResult['CATALOG_QUANTITY'],
            'STEP_QUANTITY' => $arResult['CATALOG_MEASURE_RATIO'],
            'BUY_URL' => $arResult['~BUY_URL'],
        ),
        'AJAX_PATH' => POST_FORM_ACTION_URI,
        'MESS' => array()
    );
}
?>

<script>jQuery.noConflict();</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>


<script type="text/javascript">
    $(document).ready(function () {
        var <? echo $strObName; ?> =
        new JCCatalogElement(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
    });
</script>

<script type="text/javascript">
    var viewedCounter = {
        path: '/bitrix/components/bitrix/catalog.element/ajax.php',
        params: {
            AJAX: 'Y',
            SITE_ID: "<?= SITE_ID ?>",
            PRODUCT_ID: "<?= $arResult['ID'] ?>",
            PARENT_ID: "<?= $arResult['ID'] ?>"
        }
    };
    BX.ready(
        BX.defer(function () {
            BX.ajax.post(
                viewedCounter.path,
                viewedCounter.params
            );
        })
    );
</script>