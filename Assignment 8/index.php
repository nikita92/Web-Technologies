<!--
Assigment 9 

Aim: Develop an	interface to perform eBay item search and post details to Facebook.	
Technologies Used :HTML,CSS,AJAX,XML,JSON,PHP,Bootstrap, jQuery and Amazon cloud computing Services.

This code contains all the back end processes which includes
-receiving data from the form
-sending data request to eBay API
-receiving XML data from the eBay API 
-converting XML data into JSON data 




-->
<?php 

header('Access-Control-Allow-Origin: *');
	
	$url="http://svcs.ebay.com/services/search/FindingService/v1?siteid=0?OPERATION-NAME=findItemsAdvanced&SERVICE-VERSION=1.0.0&SECURITY-APPNAME=USC8dc59d-2500-40f7-827c-134997954f7&GLOBAL-ID=EBAY-US&outputSelector[1]=SellerInfo&outputSelector[2]=PictureURLSuperSize&outputSelector[3]=StoreInfo&paginationInput.pageNumber=".(int)$_GET['page_no'];
	
	 $j=0;
		
		$temp_key=$_GET['keywords'];
		$tempkey=urlencode($temp_key);
		$temp="&keywords=".$tempkey;
		$url.=$temp;
		
		$sort_temp=$_GET['sortby'];
		$temp="&sortOrder=".$sort_temp;
		$url.=$temp;
		
		$res_temp=$_GET['resultsperpage'];
		$temp="&paginationInput.entriesPerPage=".$res_temp;
		$url.=$temp;
		
		$min_temp=$_GET['pricefrom'];
		$max_temp=$_GET['priceto'];
		
		// for adding minimum price to URL 
		if($min_temp!='')
		{
			$temp="&itemFilter(".$j.").name=MinPrice&itemFilter(".$j.").value=".$min_temp;
			$url.=$temp;
			$j++;
		}
		
		// for adding maximum price to URL
		if($max_temp!='')
		{
			
			$temp="&itemFilter(".$j.").name=MaxPrice&itemFilter(".$j.").value=".$max_temp;
			$url.=$temp;
			$j++;

		}
		

		// for filtering condition attribute 
		if (isset($_GET['condition']) && is_array($_GET['condition']))
		{
			$i=0;
	
			$test_condition="&itemFilter(".$j.").name=Condition";
			
			if (in_array('New', $_GET['condition']))
			{
				$test_condition.="&itemFilter(".$j.").value(".$i.")=1000";
				$i++;
			}
			if (in_array('VeryGood', $_GET['condition']))
			{
					$test_condition.="&itemFilter(".$j.").value(".$i.")=4000";
					$i++;
			}
			
			
			if (in_array('Used', $_GET['condition']))
			{
				$test_condition.="&itemFilter(".$j.").value(".$i.")=3000";
				$i++;
			}
			
			if (in_array('Good', $_GET['condition']))
			{
				$test_condition.="&itemFilter(".$j.").value(".$i.")=5000";
				$i++;
			}
			
			if (in_array('Acceptable', $_GET['condition']))
			{
				$test_condition.="&itemFilter(".$j.").value(".$i.")=6000";
				$i++;
			}
			
			
			
			$url.=$test_condition;
			$j++;
		}
		
//Filter for return accepted 

if(isset($_GET['seller']))
{		
			
	$temp="&itemFilter(".$j.").name=ReturnsAcceptedOnly&itemFilter(".$j.").value=true";
	$url.=$temp;
	$j++;
}
		
		
		
// filter for buyingformats 		

if (isset($_GET['buyingformats']) && is_array($_GET['buyingformats']))
{
	$i=0;
	
		$buy_test="&itemFilter(".$j.").name=ListingType";
		
		if (in_array('buyitnow', $_GET['buyingformats']))
		{
			$buy_test.="&itemFilter(".$j.").value(".$i.")=FixedPrice";
			$i++;
		}
		
		if (in_array('auction', $_GET['buyingformats']))
		{
			$buy_test.="&itemFilter(".$j.").value(".$i.")=Auction";
			$i++;
		}
		if (in_array('classifiedads', $_GET['buyingformats']))
		{
			$buy_test.="&itemFilter(".$j.").value(".$i.")=Classified";
			$i++;
		}
   $url.=$buy_test;
   $j++;
}

// filter for maximum handling time 
$max_handling=$_GET['max_handling_days'];
if($max_handling!='')
{
	$temp="&itemFilter(".$j.").name=MaxHandlingTime&itemFilter(".$j.").value=".$max_handling;
	$url.=$temp;
	$j++;

}

//filter for shipping 
if(isset($_GET['shipping']))
	{
		$temp="&itemFilter(".$j.").name=FreeShippingOnly&itemFilter(".$j.").value=true";
		$url.=$temp;
		$j++;
	}
if(isset($_GET['expeditedshipping']))
	{
		$temp="&itemFilter(".$j.").name=ExpeditedShippingType&itemFilter(".$j.").value=Expedited";
		$url.=$temp;
		$j++;
	}
	
	


	
// if all filters satisfy fetch the required XML 

$fetchxml = simplexml_load_file($url);

// Checking if no reults found 
if(($fetchxml->paginationOutput->totalEntries)==0)
	{
		$gb_arr= array('ack'=>'No Results Found');
	}
else                              //converting the xml data into JSON data 
{	
	if ($fetchxml->ack == "Success") 
	{
		$item_count=0;

	$gb_arr['ack']= (string)$fetchxml->ack;
	$gb_arr["resultCount"]=(string)$fetchxml->paginationOutput->totalEntries;
	$gb_arr["pageNumber"]=(string)$fetchxml->paginationOutput->pageNumber;
	$gb_arr["itemCount"]=(string)$fetchxml->paginationOutput->entriesPerPage;
	foreach($fetchxml->searchResult->item as $item)
	{
			$i_no = "item".$item_count;
			
			$t_arr['basicInfo'] = array("title"=>(string)$item->title,"viewItemURL"=>(string)$item->viewItemURL,"galleryURL"=>(string)$item->galleryURL,
			"pictureURLSuperSize"=>(string)$item->pictureURLSuperSize,"convertedCurrentPrice"=>(string)$item->sellingStatus->convertedCurrentPrice,
			"shippingServiceCost"=>(string)$item->shippingInfo->shippingServiceCost,"conditionDisplayName"=>(string)$item->condition->conditionDisplayName,
			"listingType"=>(string)$item->listingInfo->listingType,"location"=>(string)$item->location,
			"categoryName"=>(string)$item->primaryCategory->categoryName,"topRatedListing"=>(string)$item->topRatedListing);
			
			$t_arr["sellerInfo"] = array("sellerUserName"=>(string)$item->sellerInfo->sellerUserName,"feedbackScore"=>(string)$item->sellerInfo->feedbackScore,
			"positiveFeedbackPercent"=>(string)$item->sellerInfo->positiveFeedbackPercent,"feedbackRatingStar"=>(string)$item->sellerInfo->feedbackRatingStar,
			"topRatedSeller"=>(string)$item->sellerInfo->topRatedSeller,"sellerStoreName"=>(string)$item->storeInfo->storeName,
			"sellerStoreURL"=>(string)$item->storeInfo->storeURL);
			
			$t_arr["shippingInfo"] = array("shippingType"=>(string)$item->shippingInfo->shippingType,"shipToLocations"=>(string)$item->shippingInfo->shipToLocations,
									"expeditedShipping"=>(string)$item->shippingInfo->expeditedShipping,"oneDayShippingAvailable"=>(string)$item->shippingInfo->oneDayShippingAvailable,
									"returnsAccepted"=>(string)$item->returnsAccepted,"handlingTime"=>(string)$item->shippingInfo->handlingTime
									);
									
			$gb_arr[$i_no] = $t_arr; 
			$item_count++;
	}
	
	

	}
	 }
//encoding JSON data 
$json= json_encode($gb_arr);			
$json = urldecode(str_replace('//',"",$json));
$json_changequote=urldecode(str_replace('\"',"&quot;",$json));
$json_woslash=stripslashes($json_changequotes);
echo $json_woslash;
?>