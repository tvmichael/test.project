<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Sort");
?>

<h2>SORT</h2>

<pre>
<?
/*
use Bitrix\Main,
	Bitrix\Main\Loader,
	Bitrix\Main\ModuleManager,
	Bitrix\Main\Config\Option,
	Bitrix\Main\Localization\Loc,
	Bitrix\Iblock,
	Bitrix\Catalog,
	Bitrix\Catalog\Product\Price,
	Bitrix\Sale\DiscountCouponsManager,
	Bitrix\Sale\Discount\Context,
	Bitrix\Sale\Order,
	Bitrix\Sale;
/**/

//print_r($USER->GetUserGroupArray());
//echo "<br><hr>";

//$arIBlockType = CIBlockParameters::GetIBlockTypes(); // список усіх інфоблоків
//arIBlockType = Bitrix\Iblock\TypeTable::getList(array('select' => array('*')))->FetchAll();
//$arIBlockType = Bitrix\Iblock\TypeTable::getList(array('select' => array('*', 'LANG_MESSAGE')))->FetchAll();
//var_dump($arIBlockType);

//$nn = 0;
$ID_BLOCK = '4'; 
$arSelect = Array("ID");
$arFilter = Array("IBLOCK_ID"=>$ID_BLOCK);
$res = CIBlockElement::GetList( Array('ID'), $arFilter, false, Array(), $arSelect);
while($ob = $res->GetNextElement()){
    $arFields = $ob->GetFields();
  	//print_r($arFields);  	
    $masMinMax = get_offer_min_max_price($ID_BLOCK, $arFields['ID']);
   	$MIN_PRICE  = min($masMinMax['minmax']);
   	$MAX_PRICE  = max($masMinMax['minmax']);
    $DISCOUNT_PRICE  = min($masMinMax['discount']);
    if ($DISCOUNT_PRICE == false) $DISCOUNT_PRICE = 0;
    /**/
    //print_r($masMinMax);
    echo "<br>".$arFields['ID']." => ".$DISCOUNT_PRICE."<br>";
	  //echo $arFields['ID'].' min= '.$MIN_PRICE.' max='.$MAX_PRICE.' - ';echo '<br>';
    //CIBlockElement::SetPropertyValuesEx($arFields['ID'], false, array('MINIMUM_PRICE' => $MIN_PRICE));
    //CIBlockElement::SetPropertyValuesEx($arFields['ID'], false, array('MAXIMUM_PRICE' => $MAX_PRICE));
    //CIBlockElement::SetPropertyValuesEx($arFields['ID'], false, array('DISCOUNT_PRICE' => $DISCOUNT_PRICE));  
}


function get_offer_min_max_price($IBLOCK_ID, $item_id)
{
	global $USER, $nn;
	$minmax = array();
  $discount = array();
	$res = CCatalogSKU::getOffersList(
	        $item_id,
	        $IBLOCK_ID, 
	        array(),
	        array(),
	        array() 
	    );
	//print_r($res);
	foreach ($res as $key => $value) {
		//echo "<br> .....$key ..................... <br> ";
		foreach ($value as $id) {
      //$nn ++;
			//print_r($id);
			// $resP = CPrice::GetBasePrice($id['ID'], false, false);			
			$resP = CCatalogProduct::GetOptimalPrice($id['ID'], 1, $USER->GetUserGroupArray(), 'N', array(), 's1');
      //echo "<h2>$nn</h2><hr>";
			//print_r($resP);
			//echo "<br>";
			//array_push($minmax, $resP['PRICE']);
      array_push($minmax, $resP['RESULT_PRICE']['BASE_PRICE']);
      array_push($discount, $resP['RESULT_PRICE']['DISCOUNT_PRICE'] );
		}		    
	}
	return array('minmax' => $minmax, 'discount'=>$discount);
}



/*
function get_offer_min_price($IBLOCK_ID, $item_id){
    $ret = 0;
    $arInfo = CCatalogSKU::GetInfoByProductIBlock($IBLOCK_ID);
    //print_r($arInfo);
    //echo "<hr>";
    if (is_array($arInfo)) {
			    
			$res = CIBlockElement::GetList(array("PRICE"=>"asc"), 
                                       array('IBLOCK_ID'=>$arInfo['IBLOCK_ID'], 'ACTIVE'=>'Y', 'PROPERTY_'.$arInfo['SKU_PROPERTY_ID'] => $item_id), 
                                       false, 
                                       false, 
                                       array('ID', 'NAME'))->GetNext();
        if ($res){
            $ret = GetCatalogProductPrice($res["ID"], 1);
            if ($ret['PRICE']){
                $ret = $ret['PRICE'];
            }
        }
    }
    return $ret;
}
function get_offer_max_price($IBLOCK_ID,$item_id){
    $ret = 0;
    $arInfo = CCatalogSKU::GetInfoByProductIBlock($IBLOCK_ID);   
    if (is_array($arInfo)) {
        $res = CIBlockElement::GetList(array("PRICE"=>"desc"), 
                                       array('IBLOCK_ID'=>$arInfo['IBLOCK_ID'], 'ACTIVE'=>'Y', 'PROPERTY_'.$arInfo['SKU_PROPERTY_ID'] => $item_id), 
                                       false, 
                                       false, 
                                       array('ID', 'NAME'))->GetNext();
        if ($res){
            $ret = GetCatalogProductPrice($res["ID"], 1);
            if ($ret['PRICE']){
                $ret = $ret['PRICE'];
            }
        }
    }
    return $ret;
}
/**/





?>
</pre>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>