<?php 
session_start();
//echo $_SESSION['keyword']. "<br>";
$RequestSignature = md5($_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING'].print_r($_POST, true));
$hello = $_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING'].print_r($_POST, true);
//echo $hello."<br><br>";
//echo $RequestSignature."<br>";

if (isset ($_POST['clear']))
{
unset($_SESSION['CongressDatabase']);
	unset($_SESSION['chamber']);
	unset($_SESSION['keyword']);
header("Location: congress.php"); // send the user back to form 1
}


if(!isset ($_SESSION['LastRequest']))
{
	$_SESSION['LastRequest'] = $RequestSignature;
	//echo "Inside";
	//echo $_SESSION['LastRequest']."<br>";
	//echo $RequestSignature."<br>";
	//echo "Close Inside<br>";
}
	
//echo $_SESSION['LastRequest'];
	
if (isset ($_SESSION['LastRequest']) && $_SESSION['LastRequest'] == $RequestSignature)
{
	$hello = $_SESSION['LastRequest'];
	//echo "HI ".$hello;
	unset($_SESSION['CongressDatabase']);
	unset($_SESSION['chamber']);
	unset($_SESSION['keyword']);

} else
{
	//$_SESSION['LastRequest'] = $RequestSignature;
}

?>

<html>
<head>
<title>Forecast</title>
<style>
table.CongressSearch {
    border: 1px solid black;
}

table.CongressSearch td {
    text-align: center;
} 
input[type="text"] {
    width: 150px;
}

</style>



</head>

<body>


<?php

	if(isset($_POST['CongressDatabase']))
	{
		$_SESSION['CongressDatabase'] = $_POST['CongressDatabase'];
	}
	if(isset($_POST['chamber']))
	{
		$_SESSION['chamber'] = $_POST['chamber'];
	}
	if(isset($_POST['keyword']))
	{
		$_SESSION['keyword'] = $_POST['keyword'];
	}
		
		//echo	$_SESSION['keyword'];
		$keyValue = array(""=>"Keyword*",
				"Legislators"=>"State/Representative*",
				"Committees"=>"Committee ID*",
				"Bills"=>"Bill ID*",
				"Amendments"=>"Amendment ID*");	
?>

<script>

var isValidate = false;

function getValue(selValue) {
	if(selValue == "Legislators")
	{
		document.getElementById("keywordName").innerHTML = "State/Representative*";
		document.getElementById("keyword").value= "" ;
	}
		
	if(selValue == "Committees")
	{
		document.getElementById("keywordName").innerHTML = "Committee ID*";
		document.getElementById("keyword").value= "" ;
	}
		
	
	if(selValue == "Bills")
	{
		document.getElementById("keywordName").innerHTML = "Bill ID*";
		document.getElementById("keyword").value= "" ;
	}
	
	if(selValue == "Amendments")
	{
		document.getElementById("keywordName").innerHTML = "Amendment ID*";
		document.getElementById("keyword").value= "" ;
	}
	
}

if(isValidate == false)
{
if(typeof window.history.pushState == 'function') {
        window.history.pushState({}, "Hide", "http://cs-server.usc.edu:30031/HW6/congress.php");
    }
}

	
	
function clearForm()
{
		document.getElementById("CongressDatabase").selectedIndex = "0";
		document.getElementById("Senate").checked = true;
		document.getElementById("House").checked = false;
		document.getElementById("keywordName").innerHTML="Keyword*";
		document.getElementById("keyword").value= "" ;
	
	if(document.getElementById("mainDiv")!=null)
		document.getElementById("mainDiv").remove();
	if(document.getElementById("detailsDiv")!=null)
		document.getElementById("detailsDiv").remove();
}


function validateForm()
{
	var str = "Please enter the following missing information: ";
	var missing = 0;
	if(document.getElementById("CongressDatabase").value =="-1")
	{
		str += "Congress Database";
		missing = 1;
	}
	var keywordValue = document.getElementById("keyword").value;
	keywordValue.replace(/\s/g, '');
	if( document.getElementById("keyword").value == "" || !document.getElementById("keyword").value.replace(/\s/g, '').length)
	{
		if(missing == 1)
			str += ", Keyword";
		else
			str += "Keyword";
		missing = 1;
	}
	
	if(missing == 1)
	{
		alert(str);
		isValidate == true;
		return false;
	}
	
	
}

</script>

<center>

<h1>Congress Information Search</h1>
<form id="form1" name="form1" method="post">
<table class="CongressSearch">
<tr>
<td>Congress Database</td> 
<td>

<select name="CongressDatabase" id="CongressDatabase" onchange="getValue(document.getElementById('CongressDatabase').value)">
	<option value="-1" selected disabled>Select your option</option>
	<option value="Legislators" <?php echo (isset($_SESSION['CongressDatabase']) && $_SESSION['CongressDatabase']=='Legislators')?'selected':'' ?>>Legislators</option>
	<option value="Committees" <?php echo (isset($_SESSION['CongressDatabase']) && $_SESSION['CongressDatabase']=='Committees')?'selected':'' ?>>Committees</option>
    <option value="Bills" <?php echo (isset($_SESSION['CongressDatabase']) && $_SESSION['CongressDatabase']=='Bills')?'selected':'' ?>>Bills</option>
	<option value="Amendments" <?php echo (isset($_SESSION['CongressDatabase']) && $_SESSION['CongressDatabase']=='Amendments')?'selected':'' ?>>Amendments</option>	
</select>
</td>
</tr>
<tr>
<td>Chamber</td>
<td>
<input type="radio" name="chamber" id="Senate" value="Senate" checked > Senate   
<input type="radio" name="chamber" id="House" value="House" <?php echo (isset($_SESSION['chamber']) && $_SESSION['chamber']=='House')?'checked':'' ?>> House<br>
</td>
</tr>
<tr>
<td id="keywordName" style="width:170px"><?php echo (isset($_SESSION['CongressDatabase'])) ? $keyValue[$_SESSION['CongressDatabase']] : "Keyword*"?></td>
<td><input type="text" name="keyword" id="keyword" value="<?php echo isset($_SESSION['keyword']) ? $_SESSION['keyword'] : '' ?>"></td>
</tr>
<tr>
<td></td>
<td><input type="submit" name="submit" value="Search" onclick="return validateForm()">  <input type="button" name="clear" value="Clear" onclick="clearForm()"></td>
</tr>
<tr>
<td colspan="2"><a href="http://sunlightfoundation.com/" target="_blank">Powered by Sunlight Foundation</a></td>
</tr>
</table>
</center>
</form>

<?php

$states = array("Alabama"=>"AL", 
			 "Alaska"=>"AK", 
			 "Arizona"=>"AZ",
			 "Arkansas"=>"AR",
			 "California"=>"CA",
			 "Colorado"=>"CO",
			 "Connecticut"=>"CT",
			 "Delaware"=>"DE",
			 "District Of Columbia"=>"DC",
			 "Florida"=>"FL",
			 "Georgia"=>"GA",
			 "Hawaii"=>"HI",
			 "Idaho"=>"ID",
			 "Illinois"=>"IL",
			 "Indiana"=>"IN",
			 "Iowa"=>"IA",
			 "Kansas"=>"KS",
			 "Kentucky"=>"KY",
			 "Louisiana"=>"LA",
			 "Maine"=>"ME",
			 "Maryland"=>"MD",
			 "Massachusetts"=>"MA",
			 "Michigan"=>"MI",
			 "Minnesota"=>"MN",
			 "Mississippi"=>"MS",
			 "Missouri"=>"MO",
			 "Montana"=>"MT",
			 "Nebraska"=>"NE",
			 "Nevada"=>"NV",
			 "New Hampshire"=>"NH",
			 "New Jersey"=>"NJ",
			 "New Mexico"=>"NM",
			 "New York"=>"NY",
			 "North Carolina"=>"NC",
			 "North Dakota"=>"ND",
			 "Ohio"=>"OH",
			 "Oklahoma"=>"OK",
			 "Oregon"=>"OR",
			 "Pennsylvania"=>"PA",
			 "Rhode Island"=>"RI",
			 "South Carolina"=>"SC",
			 "South Dakota"=>"SD",
			 "Tennessee"=>"TN",
			 "Texas"=>"TX",
			 "Utah"=>"UT",
			 "Vermont"=>"VT",
			 "Virginia"=>"VA",
			 "Washington"=>"WA",
			 "West Virginia"=>"WV",
			 "Wisconsin"=>"WI",
			 "Wyoming"=>"WY");

	function legislatureTable()
	{
		global $states;
		$chamberValue = strtolower($_POST['chamber']);
		$originalKeyword = $_POST['keyword'];
		$keywordValue = ucwords(strtolower($_POST['keyword']));
		$keywordValue = trim($keywordValue);
		
		$parts = array();
		
		if (!array_key_exists("$keywordValue",$states))
		{
			
			if(preg_match('/\s/',$keywordValue))
			{
				$parts = preg_split('/\s+/', $keywordValue);
				$noOfParts = count($parts);
				
				if($noOfParts == 2)
				{
					$keywordValue = $parts[1];
				}
				if($noOfParts == 3)
				{
					$keywordValue = $parts[2];
				}
			}
			
			$originalNameArray = array();
			if(preg_match('/\s/',$originalKeyword))
			{
				$originalNameArray = preg_split('/\s+/', $originalKeyword);
				$noOfParts = count($originalNameArray);
			}
				
			
		}
		
		//echo $keywordValue;
		
		if (array_key_exists("$keywordValue",$states))
		{
			$state = $states[$keywordValue];
			$service_url = "http://congress.api.sunlightfoundation.com/legislators?chamber=$chamberValue&state=$state&apikey=c401bf0c6bee4abcae170e8225dce1fe";
		}
		else
		{
			$service_url = "http://congress.api.sunlightfoundation.com/legislators?chamber=$chamberValue&query=$keywordValue&apikey=c401bf0c6bee4abcae170e8225dce1fe";
		}
		
		/*
		$curl = curl_init($service_url);
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		
		$curl_response = curl_exec($curl);
		
		$tableData = json_decode($curl_response);
		*/
		$curl_response = file_get_contents($service_url);
		$tableData = json_decode($curl_response);
		
		echo "<div id='mainDiv'>";
		
		if(count($tableData->results) == 0)
		{
			echo '<center><br><br><br><br>The API returned zero results for the request</center>';
			return 'The API returned zero results for the request';
		}
		
		$queryWithOneWhitespaces = 0;
		$queryWithTwoWhitespaces = 0;
		if(count($parts) != 0)
		{
			if(count($parts) == 2)
			{
				foreach ($tableData->results as $tableValue) {
					//echo $tableValue->last_name ;
					//echo $parts[1];
					if(strtolower($tableValue->first_name) == strtolower($parts[0]) && strtolower($tableValue->last_name) == strtolower($parts[1]))
					{
						$queryWithOneWhitespaces = 1;
					}
				}
			}
			if(count($parts) == 3)
			{
				foreach ($tableData->results as $tableValue) {
					$combinedLastName = $parts[1]." ".$parts[2];
					if($tableValue->first_name == $parts[0] && $tableValue->last_name == $combinedLastName)
					{
						$queryWithTwoWhitespaces = 2;
					}
				}
			}
			
		}
		if(count($parts) == 0)
		{
			echo "<br><center><table border='1' width='65%' style='text-align: center;border-collapse : collapse;'><tr><th width='30%'>Name</th><th width='22%'>State</th><th width='20%'>Chamber</th><th width='24%'>Details</th></tr>";
		}
		else
		{
			if($queryWithOneWhitespaces == 1 || $queryWithTwoWhitespaces == 2)
			{
				echo "<br><center><table border='1' width='65%' style='text-align: center;border-collapse : collapse;'><tr><th width='30%'>Name</th><th width='22%'>State</th><th width='20%'>Chamber</th><th width='24%'>Details</th></tr>";
			}
		}
		
		foreach ($tableData->results as $tableValue) {
			if(count($parts) == 0)
			{
				echo "<tr>";
				echo "<td style='text-align:left; padding-left:70px;'>$tableValue->first_name $tableValue->last_name</td>";
				echo "<td>$tableValue->state_name</td>";
				echo "<td>$tableValue->chamber</td>";
				$stringParameter = "$chamberValue~$keywordValue~$tableValue->bioguide_id";
				echo "<td><a href='?viewDetails=$stringParameter'>View Details</a></td>";
				echo "</tr>";
			}
			else
			{
				if(count($parts) == 2)
				{
					if(strtolower($tableValue->first_name) == strtolower($parts[0]) && strtolower($tableValue->last_name) == strtolower($parts[1]))
					{
						echo "<tr>";
						echo "<td style='text-align:left; padding-left:70px;'>$tableValue->first_name $tableValue->last_name</td>";
						echo "<td>$tableValue->state_name</td>";
						echo "<td>$tableValue->chamber</td>";
						$stringParameter = "$chamberValue~$keywordValue~$tableValue->bioguide_id";
						echo "<td><a href='?viewDetails=$stringParameter'>View Details</a></td>";
						echo "</tr>";
					}
				}
				if(count($parts) == 3)
				{
					$combinedLastName = $parts[1]." ".$parts[2];
					if(strtolower($tableValue->first_name) == strtolower($parts[0]) && strtolower($tableValue->last_name) == strtolower($combinedLastName))
					{
						echo "<tr>";
						echo "<td style='text-align:left; padding-left:70px;'>$tableValue->first_name $tableValue->last_name</td>";
						echo "<td>$tableValue->state_name</td>";
						echo "<td>$tableValue->chamber</td>";
						$stringParameter = "$chamberValue~$keywordValue~$tableValue->bioguide_id";
						echo "<td><a href='?viewDetails=$stringParameter'>View Details</a></td>";
						echo "</tr>";
					}
				}
			}
		}
		
		if(count($parts) == 0)
		{
			echo "</table></center>";
		}
		else
		{
			if($queryWithOneWhitespaces == 1 || $queryWithTwoWhitespaces == 2)
			{
				echo "</table></center>";
			}
		}
		
	
		echo "</div>";
	
	}


	if (isset($_GET['viewDetails']))
    {
        viewDetails($_GET['viewDetails']);
    }

    function viewDetails($stringParameter)
    {
		global $states;
		$values = explode("~", $stringParameter);
		$chamberValue = $values[0];
		$keywordValue = $values[1];
		$bioguide_id = $values[2];
		
		$_POST['CongressDatabase'] = "Legislators";
		$_POST['chamber'] = ucfirst($chamberValue);
		$_POST['keyword'] = $keywordValue;
		
		
		//retainFormOnLoad("Legislators",ucfirst($chamberValue),$keywordValue);
		
		if (array_key_exists("$keywordValue",$states))
		{
			$state = $states[$keywordValue];
			$detailsURL = "http://congress.api.sunlightfoundation.com/legislators?chamber=$chamberValue&state=$state&bioguide_id=$bioguide_id&apikey=c401bf0c6bee4abcae170e8225dce1fe";
		}
		else
		{
			$detailsURL = "http://congress.api.sunlightfoundation.com/legislators?chamber=$chamberValue&query=$keywordValue&bioguide_id=$bioguide_id&apikey=c401bf0c6bee4abcae170e8225dce1fe";
		}
		
		/*
		$curlDetails = curl_init($detailsURL);
		
		curl_setopt($curlDetails, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curlDetails, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curlDetails, CURLOPT_SSL_VERIFYHOST, FALSE);
		
		$curl_responseDetails = curl_exec($curlDetails);
		
		$tableDetails = json_decode($curl_responseDetails);
		*/
		$curl_response = file_get_contents($detailsURL);
		$tableDetails = json_decode($curl_response);
		
		echo "<div id='detailsDiv'>";
		
		if(count($tableDetails->results) == 0)
		{
			echo '<center><br><br><br><br>The API returned zero results for the request</center>';
			return 'The API returned zero results for the request';
		}
		
		echo "<br><center><table width='59%' style='border: 1px solid black; text-align: left;border-collapse : collapse;'>";
		
		foreach ($tableDetails->results as $tableValue) {			
			echo "<tr>";
			echo "<td colspan=2 style='padding: 20px;text-align: center;'><img src='https://theunitedstates.io/images/congress/225x275/$bioguide_id.jpg'></td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td style='padding-left: 200px;'>Full Name</td>";
			echo "<td style='padding-left: 20px;'>$tableValue->title $tableValue->first_name $tableValue->last_name</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td style='padding-left: 200px;'>Term Ends on</td>";
			
			if ($tableValue->term_end == null)
			{
				echo "<td style='padding-left: 20px;'>NA</td>";
			}
			else
			{
				echo "<td style='padding-left: 20px;'>$tableValue->term_end</td>";
			}
			
			
			echo "</tr>";
			echo "<tr>";
			echo "<td style='padding-left: 200px;'>Website</td>";
			if ($tableValue->website == null)
			{
				echo "<td style='padding-left: 20px;'>NA</td>";
			}
			else
			{
				echo "<td style='padding-left: 20px;'><a href='$tableValue->website' target='_blank'>$tableValue->website</td>";
			}
			echo "</tr>";
			echo "<tr>";
			echo "<td style='padding-left: 200px;'>Office</td>";
			if ($tableValue->office == null)
			{
				echo "<td style='padding-left: 20px;'>NA</td>";
			}
			else
			{
				echo "<td style='padding-left: 20px;'>$tableValue->office</td>";
			}
			
			echo "</tr>";
			echo "<tr>";
			echo "<td style='padding-left: 200px;'>Facebook</td>";
			if ($tableValue->facebook_id == null)
			{
				echo "<td style='padding-left: 20px;'>NA</td>";
			}
			else
			{
				echo "<td style='padding-left: 20px;'><a href='https://www.facebook.com/$tableValue->facebook_id' target='_blank'>$tableValue->first_name $tableValue->last_name</a></td>";
			}
			echo "</tr>";
			echo "<tr>";
			echo "<td style='padding-left: 200px; padding-bottom: 20px;'>Twitter</td>";
			if ($tableValue->twitter_id == null)
			{
				echo "<td style='padding-left: 20px; padding-bottom: 20px;'>NA</td>";
			}
			else
			{
				echo "<td style='padding-left: 20px;  padding-bottom: 20px;'><a href='https://twitter.com/$tableValue->twitter_id' target='_blank'>$tableValue->first_name $tableValue->last_name</a></td>";
			}
			echo "</tr>";
		}
		echo "</table></center>";
		
		echo "</div>";			
	}
	
	
	function committeesTable()
	{
		$chamberValue = strtolower($_POST['chamber']);
		//$committeeID = $_POST['keyword'];
		$committeeID = strtoupper(strtolower($_POST['keyword']));
		$committeeID = trim($committeeID);
		
		$service_url = "http://congress.api.sunlightfoundation.com/committees?committee_id=$committeeID&chamber=$chamberValue&apikey=c401bf0c6bee4abcae170e8225dce1fe";
		
		/*
		$curl = curl_init($service_url);
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		
		$curl_response = curl_exec($curl);
		
		$tableData = json_decode($curl_response);
		*/
		
		
		$curl_response = file_get_contents($service_url);
		$tableData = json_decode($curl_response);
		
		echo "<div id='mainDiv'>";
		
		if(count($tableData->results) == 0)
		{
			echo '<center><br><br><br><br>The API returned zero results for the request</center>';
			return 'The API returned zero results for the request';
		}
		
		echo "<br><center><table border='1' width='65%' style='text-align: center;border-collapse : collapse;'><tr><th width='20%'>Committee ID</th><th width='50%'>Committee Name</th><th width='20%'>Chamber</th></tr>";
		
		foreach ($tableData->results as $tableValue) {
			echo "<tr>";
			echo "<td style='text-align:center;'>$tableValue->committee_id</td>";
			if ($tableValue->name == null)
			{
				echo "<td>NA</td>";
			}
			else
			{
				echo "<td>$tableValue->name</td>";
			}
			
			echo "<td>$tableValue->chamber</td>";
			echo "</tr>";
		}
		echo "</table></center>";
		
		echo "</div>";
		
	}
	
	
	
	function billsTable()
	{
		$chamberValue = strtolower($_POST['chamber']);
		$billID = strtolower($_POST['keyword']);
		$billID = trim($billID);
		$stringParameter = "$chamberValue~$billID";
		
		$service_url = "http://congress.api.sunlightfoundation.com/bills?bill_id=$billID&chamber=$chamberValue&apikey=c401bf0c6bee4abcae170e8225dce1fe";
		
		/*
		$curl = curl_init($service_url);
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		
		$curl_response = curl_exec($curl);
		
		$tableData = json_decode($curl_response);
		*/
		
		$curl_response = file_get_contents($service_url);
		$tableData = json_decode($curl_response);
		
		echo "<div id='mainDiv'>";
		
		if(count($tableData->results) == 0)
		{
			echo '<center><br><br><br><br>The API returned zero results for the request</center>';
			return 'The API returned zero results for the request';
		}
		
		echo "<br><center><table border='1' width='60%' style='text-align: center;border-collapse : collapse;'><tr><th width='20%'>Bill ID</th><th width='32%'>Short Title</th><th width='18%'>Chamber</th><th width='22%'>Details</th></tr>";
		
		
		
		foreach ($tableData->results as $tableValue) {
			echo "<tr>";
			echo "<td style='text-align:center;'>$tableValue->bill_id</td>";
			$shortTitle = "NA";		
			if($tableValue->short_title != null)
				$shortTitle = $tableValue->short_title;
			echo "<td>$shortTitle</td>";
			echo "<td>$tableValue->chamber</td>";
			echo "<td><a href='?viewBillDetails=$stringParameter'>View Details</a></td>";
			echo "</tr>";
		}
		echo "</table></center>";
		
		echo "</div>";
	}
	
	if (isset($_GET['viewBillDetails']))
    {
		viewBillDetails($_GET['viewBillDetails']);
    }
	
    function viewBillDetails($stringParameter)
    {		
		$values = explode("~", $stringParameter);
		$chamberValue = $values[0];
		$billID = $values[1];
		//retainFormOnLoad("Bills",ucfirst($chamberValue),$billID);
		
		$detailsURL = "http://congress.api.sunlightfoundation.com/bills?bill_id=$billID&chamber=$chamberValue&apikey=c401bf0c6bee4abcae170e8225dce1fe";
		/*$curlDetails = curl_init($detailsURL);
		
		curl_setopt($curlDetails, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curlDetails, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curlDetails, CURLOPT_SSL_VERIFYHOST, FALSE);
		
		$curl_responseDetails = curl_exec($curlDetails);
		*/
		
		$curl_responseDetails = file_get_contents($detailsURL);
		$tableDetails = json_decode($curl_responseDetails, true);

		echo "<div id='detailsDiv'>";
		
		if(empty($tableDetails['results'][0]))
		{
			echo '<center><br><br><br><br>The API returned zero results for the request</center>';
			return 'The API returned zero results for the request';
		}
		
		echo "<br><center><table width='53%' style='border: 1px solid black; text-align: left;border-collapse : collapse;'>";
					
			echo "<tr>";
			echo "<td style='padding-left: 100px;padding-top:20px;'>Bill ID</td>";
			echo "<td style='padding-left: 110px;padding-top:20px;'>".$tableDetails['results'][0]['bill_id']."</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td style='padding-left: 100px;'>Bill Title</td>";
			$shortTitle = "NA";		
			if($tableDetails['results'][0]['short_title'] != null)
				$shortTitle = $tableDetails['results'][0]['short_title'];
			echo "<td style='padding-left: 110px;'>".$shortTitle."</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td style='padding-left: 100px;'>Sponsor</td>";
			if ($tableDetails['results'][0]['sponsor']['title'] == null && $tableDetails['results'][0]['sponsor']['first_name'] == null && $tableDetails['results'][0]['sponsor']['last_name'] == null)
			{
				echo "<td style='padding-left: 110px;'>NA</td>";
			}
			else
			{
				echo "<td style='padding-left: 110px;'>".$tableDetails['results'][0]['sponsor']['title']." ".$tableDetails['results'][0]['sponsor']['first_name']." ". $tableDetails['results'][0]['sponsor']['last_name']."</td>";
			}
			
			echo "</tr>";
			echo "<tr>";
			echo "<td style='padding-left: 100px;'>Introduced On</td>";
			if ($tableDetails['results'][0]['introduced_on'] == null)
			{
				echo "<td style='padding-left: 110px;'>NA</td>";
			}
			else
			{
				echo "<td style='padding-left: 110px;'>".$tableDetails['results'][0]['introduced_on']."</td>";
			}			
			echo "</tr>";
			echo "<tr>";
			echo "<td style='padding-left: 100px;'>Last action with date</td>";
			if ($tableDetails['results'][0]['last_version']['version_name'] == null && $tableDetails['results'][0]['last_action_at'] == null)
			{
				echo "<td style='padding-left: 110px;'>NA</td>";
			}
			else
			{
				echo "<td style='padding-left: 110px;'>".$tableDetails['results'][0]['last_version']['version_name'].", ".$tableDetails['results'][0]['last_action_at']."</td>";
			}
			
			echo "</tr>";
			echo "<tr>";
			echo "<td style='padding-left: 100px; padding-bottom: 20px;'>Bill URL</td>";
			
			if ($tableDetails['results'][0]['last_version']['urls']['pdf'] == null){
				echo "<td style='padding-left: 110px;  padding-bottom: 20px;'>NA</td>";
			}
			else {
				if($tableDetails['results'][0]['short_title'] != null)
				{
					echo "<td style='padding-left: 110px;  padding-bottom: 20px;'><a href='".$tableDetails['results'][0]['last_version']['urls']['pdf']."'  target='_blank'>".$tableDetails['results'][0]['short_title']."</a></td>";
				}
				else
				{
					echo "<td style='padding-left: 110px;  padding-bottom: 20px;'><a href='".$tableDetails['results'][0]['last_version']['urls']['pdf']."'  target='_blank'>".$tableDetails['results'][0]['bill_id']."</a></td>";
				}
				
				
			}
			echo "</tr>";
			
		echo "</table></center>";
		
		echo "</div>";	
	}
	
	function ammendmentsTable()
	{
		$chamberValue = strtolower($_POST['chamber']);
		$ammendmentID = strtolower($_POST['keyword']);
		$ammendmentID = trim($ammendmentID);
		
		$service_url = "http://congress.api.sunlightfoundation.com/amendments?amendment_id=$ammendmentID&chamber=$chamberValue&apikey=c401bf0c6bee4abcae170e8225dce1fe";
		
		/*
		$curl = curl_init($service_url);
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		
		$curl_response = curl_exec($curl);
		
		$tableData = json_decode($curl_response);
		*/
		
		$curl_response = file_get_contents($service_url);
		$tableData = json_decode($curl_response);
		
		echo "<div id='mainDiv'>";
		
		if(count($tableData->results) == 0)
		{
			echo '<center><br><br><br><br>The API returned zero results for the request</center>';
			return 'The API returned zero results for the request';
		}
		
		echo "<br><center><table border='1' width='58%' style='text-align: center;border-collapse : collapse;'><tr><th width='25%'>Amendment ID</th><th width='20%'>Amendment Type</th><th width='20%'>Chamber</th><th width='24%'>Introduced on</th></tr>";
		
		foreach ($tableData->results as $tableValue) {
			echo "<tr>";
			echo "<td style='text-align:center;'>$tableValue->amendment_id</td>";
			if ($tableValue->amendment_type == null)
			{
				echo "<td>NA</td>";
			}
			else
			{
				echo "<td>$tableValue->amendment_type</td>";
			}
			
			echo "<td>$tableValue->chamber</td>";
			
			if ($tableValue->introduced_on == null)
			{
				echo "<td>NA</td>";
			}
			else
			{
				echo "<td>$tableValue->introduced_on</td>";
			}
			
			echo "</tr>";
		}
		echo "</table></center>";
		
		echo "</div>";
	}
	
	
	if(isset($_POST['clear'])) {
		unset($_SESSION['CongressDatabase']);
			#echo $_SESSION['CongressDatabase'];
			unset($_SESSION['chamber']);
			unset($_SESSION['keyword']);
	}
	
	if(isset($_POST['submit'])) {
	/*	$required = array('CongressDatabase', 'chamber', 'keyword');
		$missing = array();
		$error = false;
		foreach($required as $field) {
		  if (empty($_POST[$field])) {
			$error = true;
			array_push($missing, $field);			
		  }
		}
		

		if ($missing)
		{
			$comma_separated = implode(",", $missing);
			//echo "<script type='text/javascript'>alert('Please enter the following missing information:  $comma_separated');</script>";
			unset($_SESSION['CongressDatabase']);
			echo $_SESSION['CongressDatabase'];
			unset($_SESSION['chamber']);
			unset($_SESSION['keyword']);
		} 
		else
		{*/
			$congDB = $_POST['CongressDatabase'];
			switch ($congDB) {
				case "Legislators":
					legislatureTable();
					break;
				case "Committees":
					committeesTable();
					break;
				case "Bills":
					billsTable();
					break;
				case "Amendments":
					ammendmentsTable();
					break;
			}
		//}
	}

?>


</body>
</html>