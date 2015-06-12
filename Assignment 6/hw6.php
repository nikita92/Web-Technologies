<!-- 
Assignment 6

Aim: Create a webpage that allows users to search items for sale on ebay 
using their API and display the results in a tabular format
Technologies Used :PHP, HTML,Javascript,XML, ebay API 

-->
<html>
<head>
<style>
.innerdiv
{
	margin-top:-21px;
	padding-left:183px;

}
</style>

<!--Placing the script tag here due to small number of functions in it -->
<script>
//Function for input validation 
function validate_form(form)
{
  var key_words= form.keywords.value;
  // keywords validation 
  if ( key_words == null || key_words == "")
  {
		alert("Please enter values for Key Words");
        return false;
  }

  // price range validation 

  if(form.pricefrom.value%1!==0 || form.priceto.value%1!==0) {
	  alert("Enter numbers in price range");
	  return false;
  }
  
  var min_price = parseInt(form.pricefrom.value);
  var max_price = parseInt(form.priceto.value);
  
  //minimum price validation
  if(min_price<0 || max_price<0)
  {
	  alert("Price range can only be positive");
	  return false;
  }
 
 // maximum price validation 
  if(max_price < min_price)
  {
		alert ("Minimum price should be lesser than Maximum price");
		return false;
  }

 // maximum handling time validation
  var max_handling_time = form.max_handling_time.value;
  if(max_handling_time == "" || max_handling_time ==null)
     {
		 // do nothing 
     }
  else
    {
       if(max_handling_time<1)
       {
			alert("Maximum handling time cannot be less than 1");
			return false;
		}
	}
}

<!-- function to clear the form when clear button is clicked-->
function clear_the_form(c_form)
{
	var elements  = c_form.elements;
	for (i = 0; i < elements .length; i++)
	{
		type_field = elements [i].type.toLowerCase();
		if(type_field=="text")
		{
			elements [i].value = "";
		}
		if (type_field=="checkbox")
		{
			if (elements [i].checked)
			{
				elements [i].checked = false;
			}
		}
		else if (type_field=="select-one")
		{
			elements [i].selectedIndex = 0;
		}
		else
		{
		   //do nothing
		}
	}
    return false;
}

</script>
</head>
<body>

<!--The outer Division -->

 <div style="border:solid 2px #000000;margin:210px;margin-top:33px;padding-top:19px;">
	<!--Image-->
		<table align="center">
			<tr >
			<td rowspan="2" ><img src="http://cs-server.usc.edu:45678/hw/hw6/ebay.jpg" height="100px;" width="100px;"></td>
			<td><b style="font-size:30px;">Shopping</b></td>
			</tr>
		</table>
  <!--End of Image-->

 <!--The inner division -->
   <div style="border:solid 2px #000000;margin:35px;padding:17px;padding-bottom:45px;">
    <!--Form starts here-->
	<form name="myForm" method="GET" action="" onsubmit="return validate_form(this)">

    <b>Key Words*:</b>
    <div class="innerdiv">
      <input type="text" name="keywords" style="width:93%;height:25px;" value="<?php echo isset($_GET['keywords']) ? $_GET['keywords'] : '' ?>" ></input>
    </div>
    <hr/>
	
    

    <b>Price Range:</b>
    <div  class="innerdiv">
       from $
       <input type="text" name="pricefrom" style="width:15%;height:25px;" value="<?php echo isset($_GET['pricefrom']) ? $_GET['pricefrom'] : '' ?>" ></input>
       to $
       <input type="text" name="priceto" style="width:15%;height:25px;" value="<?php echo isset($_GET['priceto']) ? $_GET['priceto'] : '' ?>" ></input>
     </div>
	 <hr/>

     <b>Condition:</b>
     <div class="innerdiv" >
        <input type="checkbox" name="condition[1000]" id="1000" style="margin-top:-21px;padding-left:183px;height:18px;" value="1000"
          <?php
		  if(isset($_GET['condition']['1000']))
		  {
			  if ($_GET['condition']['1000'] === "1000")
			  {
				  echo 'checked="checked"';
			  }
		  }
		  ?>>&nbsp;New
        <input type="checkbox" name="condition[3000]" id="3000" style="margin-top:-21px;padding-left:183px;height:18px;" value="3000"
          <?php
		  if(isset($_GET['condition']['3000']))
		  {
			  if($_GET['condition']['3000'] === "3000")
			  {
				  echo 'checked="checked"';
			  }
		  }?>>&nbsp;Used
        <input type="checkbox" name="condition[4000]" id="4000" style="margin-top:-21px;padding-left:183px;height:18px;" value="4000"
          <?php
		  if(isset($_GET['condition']['4000']))
		  {
			  if($_GET['condition']['4000'] === "4000")
			  {
				  echo 'checked="checked"';
			  }
		  }?>>&nbsp;Very Good
        <input type="checkbox" name="condition[5000]" id="5000" style="margin-top:-21px;padding-left:183px;height:18px;" value="5000"
          <?php
		  if(isset($_GET['condition']['5000']))
		  {
			  if($_GET['condition']['5000'] === "5000")
			  {
		         echo 'checked="checked"';
			  }
		  }?>>&nbsp;Good
        <input type="checkbox" name="condition[6000]" id="6000" style="margin-top:-21px;padding-left:183px;height:18px;" value="6000"
          <?php
		  if(isset($_GET['condition']['6000']))
		  {
			  if($_GET['condition']['6000'] === "6000")
			  {
				  echo 'checked="checked"';
			  }
		   }?>>&nbsp;Acceptable
     </div>
     <hr/>

	 <b>Buying formats:</b>
     <div class="innerdiv">
        <input type="checkbox" name="buyingformats[buyitnow]"  id="buyitnow" style="margin-top:-21px;padding-left:183px;height:18px;" value="FixedPrice"
          <?php
		  if(isset($_GET['buyingformats']['buyitnow']))
		  {
			  if($_GET['buyingformats']['buyitnow'] === "FixedPrice")
			  {
				  echo 'checked="checked"';
			  }
		  }?>>&nbsp;Buy It Now
        <input type="checkbox" name="buyingformats[auction]"  id="auction" style="margin-top:-21px;padding-left:183px;height:18px;" value="Auction"
          <?php
		  if(isset($_GET['buyingformats']['auction']))
		  {
			  if($_GET['buyingformats']['auction'] === "Auction")
			  {
				  echo 'checked="checked"';
			  }
		  }?>>&nbsp;Auction
        <input type="checkbox" name="buyingformats[classifiedads]" id="classifiedads" style="margin-top:-21px;padding-left:183px;height:18px;" value="Classified"
          <?php
		  if(isset($_GET['buyingformats']['classifiedads']))
		  {
			  if($_GET['buyingformats']['classifiedads'] === "Classified")
			  {
				  echo 'checked="checked"';
			  }
		  }?>>&nbsp;Classified Ads
     </div>
     <hr/>

     <b>Seller</b>
     <div class="innerdiv">
        <input type="checkbox" name="seller"  style="margin-top:-21px;padding-left:183px;height:18px;" 
		  <?php
		  if(isset($_GET['seller']))
			  echo 'checked="checked"';
		  ?> >&nbsp;Returned Accepted
     </div>
     <hr/>

     <b>Shipping:</b>
     <div class="innerdiv">
        <input type="checkbox" name="freeshipping" style="margin-top:-21px;padding-left:183px;height:18px;" 
		<?php
		if(isset($_GET['freeshipping']))
			echo 'checked="checked"';
		?>>&nbsp;Free Shipping<br/>
        <input type="checkbox" name="expeditedshippingavailable" style="margin-top:-21px;padding-left:183px;height:18px;" 
		<?php
		if(isset($_GET['expeditedshippingavailable']))
			echo 'checked="checked"'; ?>>&nbsp;Expedited Shipping available<br/>
        Max handling time(days):&nbsp; <input type="text" name="max_handling_time"  style="width:15%;height:25px;" value="<?php echo isset($_GET['max_handling_time']) ? $_GET['max_handling_time'] : '' ?>" >
     </div>
     <hr/>

    <b>Sort by:</b>
    <div class="innerdiv">
        <select name="sort">
        <option value="BestMatch" <?php
									if (isset($_GET['sort']) && $_GET['sort'] == 'BestMatch')
									echo 'selected="selected"';
								  ?>>Best match</option>
        <option value="CurrentPriceHighest" <?php
											 if (isset($_GET['sort']) && $_GET['sort'] === 'CurrentPriceHighest') echo 'selected="selected"';
											?>>Price: highest first</option>
        <option value="PricePlusShippingHighest" <?php
												  if (isset($_GET['sort']) && $_GET['sort'] === 'PricePlusShippingHighest') echo 'selected="selected"';
												 ?>>Price + Shipping: highest first</option>
        <option value="PricePlusShippingLowest" <?php
												  if (isset($_GET['sort']) && $_GET['sort'] === 'PricePlusShippingLowest') echo 'selected="selected"';
												?>>Price + Shipping: lowest first</option>
        </select>
    </div>
    <hr/>

    <b>Results Per Page:</b>
    <div class="innerdiv">
        <select name="resultperpage">
        <option value="5" <?php
							if (isset($_GET['resultperpage']) && $_GET['resultperpage'] === '5')
							echo 'selected="selected"';
						  ?>>5</option>
        <option value="10" <?php
							if (isset($_GET['resultperpage']) && $_GET['resultperpage'] === '10')
							echo 'selected="selected"';
						  ?>>10</option>
        <option value="15" <?php
							if (isset($_GET['resultperpage']) && $_GET['resultperpage'] === '15')
							echo 'selected="selected"';
						   ?>>15</option>
        <option value="20" <?php
						   if (isset($_GET['resultperpage']) && $_GET['resultperpage'] === '20')
						   echo 'selected="selected"';
						   ?>>20</option>
         </select>
    </div>


    <div style="float:right;padding-right:25px;padding-top:7px;">
        <input type="submit" value="Search" name="search" style="width:80px;">
        <button onclick="return clear_the_form(this.form);" style="width:80px;">clear</button>
    </div>

  </form>    <!--end of form -->
  </div>  <!--end of inner division division -->
</div>  <!--end of outer division division -->

 <!-- functions of various filters used for handling  mapping between the search fields and the URL parameters to call the eBay
API -->

<?php if(isset($_GET["search"])):

   $url="http://svcs.ebay.com/services/search/FindingService/v1?siteid=0?OPERATION-NAME=findItemsAdvanced&SERVICE-VERSION=1.0.0&SECURITY-APPNAME=USC8dc59d-2500-40f7-827c-134997954f7&GLOBAL-ID=EBAY-US&keywords=".$_GET['keywords']."&paginationInput.entriesPerPage=".$_GET['resultperpage']."&sortOrder=".$_GET['sort']."";
   $i =0;
    // price from 
    if(!empty($_GET['pricefrom']))
		{
			$url .= "&itemFilter[$i].name=MinPrice&itemFilter[$i].value=".$_GET['pricefrom'];
			$i++;
		}
	
	//price to 
    if(!empty($_GET['priceto']))
		{
			$url .= "&itemFilter[$i].name=MaxPrice&itemFilter[$i].value=".$_GET['priceto'];
			$i++;
		}
		
	//buying formats 
	if(!empty($_GET['buyingformats']))
		{
			$j = 0;
			$url .= "&itemFilter[$i].name=ListingType";
			foreach($_GET['buyingformats'] as $temp)
			{
				$url .= "&itemFilter[$i].value[$j]=".$temp;
				$j++;
			}
			$i++;
		}
		
     //condition 
	if(!empty($_GET['condition']))
	{
		$j = 0;
		$url .= "&itemFilter[$i].name=Condition";
		foreach($_GET['condition'] as $temp)
		{
			$url .= "&itemFilter[$i].value[$j]=".$temp;
			$j++;
		}
		$i++;
    }

	// free shipping 
	$freeactive = isset($_GET['freeshipping']) && $_GET['freeshipping']  ? "true" : "false";
    if($freeactive == "true")
    {
		$url .= "&itemFilter[$i].name=FreeShippingOnly&itemFilter[$i].value=".$freeactive;
		$i++;
    }
	
	//expedited shipping 
	$availableactive = isset($_GET['expeditedshippingavailable']) && $_GET['expeditedshippingavailable']  ? "true" : "false";
    if($availableactive == "true")
    {
		$url .= "&itemFilter[$i].name=ExpeditedShippingType&itemFilter[$i].value=".$availableactive;
		$i++;
    }

     //if seller accepts returns 
    $sactive = isset($_GET['seller']) && $_GET['seller']  ? "true" : "false";
    if($sactive == "true")
    {
		$url .= "&itemFilter[$i].name=ReturnsAcceptedOnly&itemFilter[$i].value=".$sactive;
		$i++;
    }
	
	// maximum handling time 
    if(!empty($_GET['max_handling_time']))
    {
		$url .= "&itemFilter[$i].name=MaxHandlingTime&itemFilter[$i].value=".$_GET['max_handling_time'];
		$i++;
    }
    
	
	//function for parsing the data from the XML file returned by the ebay API 
    $loadxml = simplexml_load_file($url);
		$variablecheck = $loadxml->paginationOutput->totalEntries;
    if(($loadxml->paginationOutput->totalEntries)==0):
		echo "<div style=\"border:solid 2px #000000; margin:200px; margin-top:-140px; padding-top:15px;\">";
		echo "<center>no results were found</center>"."</div>";

	else:
		if ($loadxml->ack == "Success") 
				{
				echo "<div style=\"border:solid 2px #000000;margin:200px;padding-top:15px;margin-top:-143px;\">";
				echo "<center>{$loadxml->paginationOutput->totalEntries}&nbsp;Results&nbsp;for&nbsp;{$_GET['keywords']}</center>";
				echo "<div style=\"border:solid 2px #000000;padding:5px;margin:32px;\">";
					foreach($loadxml->searchResult->item as $item) {
						echo "<div><img src=\"{$item->galleryURL}\" style=\"height:240px;width:240px\"></div>";
						echo "<div style=\"margin-left:250px;margin-top:-220px;height:200px;\"><a href=\"{$item->viewItemURL}\">{$item->title}</a>";
						echo "<div style=\"margin-top:22px;\"><b>Condition:</b>{$item->condition->conditionDisplayName}</div>";

						if($item->listingInfo->listingType == "Auction")
						{
							echo "<div style=\"margin-top:20px;\"><b>Auction</b></div>";
						}
						if($item->topRatedListing == "true")
						{
							echo "<div style=\"margin-top:-40px;margin-left:170px;\"><img src=\"http://cs-server.usc.edu:45678/hw/hw6/itemTopRated.jpg\" style=\"height:70;width:80\"></div>";
						}
						if($item->listingInfo->listingType == "FixedPrice" || $item->listingInfo->listingType == "StoreInventory")
						{
							echo "<div style=\"margin-top:20px;\"><b>Buy It Now</b></div>";
						}
						if($item->listingInfo->listingType == "Classified")
						{
							echo "<div style=\"margin-top:20px;\"><b>Classified&nbsp;Ad</b></div>";
						}
						if($item->returnsAccepted == "true")
						{
							echo "Seller Accepts returns";
						}
						if($item->shippingInfo->shippingServiceCost == "0.0")
						{
							echo "<br/>FREE Shipping --";
						}
						else
						{
							echo "<br/>Shipping not FREE --";
						}
						if($item->shippingInfo->expeditedShipping == "true")
						{
							echo "Expedited Shipping Available --";
						}
						echo "Handled for shipping is {$item->shippingInfo->handlingTime} day(s)";
						echo "<div style=\"margin-top:17px;\">";
						echo "<b>Price: \${$item->sellingStatus->convertedCurrentPrice}";
						if($item->shippingInfo->shippingServiceCost > "0")
						{
							echo " (+ \${$item->shippingInfo->shippingServiceCost}for shipping)";
						}
						echo "</b>"."<i> From {$item->location}</i>";
						 
						echo "</div>"."</div>"."<div style=\"margin-top:27px;\"><hr/></div>";
						 
						
					}
				echo "</div>"."</div>";
				

		    }
        ?>
	<?php endif;?>
<?php endif;?>

<noscript>

</body>

</html>