#!/usr/bin/php

<?php
//-----------------------------------------------
//             Project 4: PHP
//-----------------------------------------------
// Authors: Allyson Douglas and Kyra Seevers
// Date: 4/5/18
// Purpose: To create a dynamic form using JSON
// and PHP
//-----------------------------------------------
?>
<?php
if(isset($_GET["category"]))
{
	processInfo();
}
else
{
	populateForm();
}

function populateForm() {
?>
	<!-- PART 1: CREATING THE FORM -->
	<form>
	<?php
	//creating the dynamic elements of the form
	echo "This is the PHP";
	//declaring local variables
	$category = "category";
	$keyToMatch = "keyToMatch";
	$matchValue = "matchValue";
	$infoToProcess = "infoToProcess";
	$text = "text";

	//getting the file content from Media.json
	$mediaString = file_get_contents("Media.json");

	//decode this json object strings
	$object = json_decode($mediaString);

	//go through a foreach loop to break apart
	//this first for loop is the categories I think
	foreach($object as $key => $value){
		//check if it category
		if($key == 'categories'){
			//create the select
			echo "<p>Please select your category:</p> <br>";
			echo "<select name=".$category.">";
			foreach($value as $nestKey => $nestValue)
				echo "<option value='".$nestKey."'>".$nestKey."</option> <br>";
			echo "</select>";
		}//end categories
		elseif($key == 'find'){
			//create the select
			echo "<p>Please select your key to match:</p> <br>";
			echo "<select name=".$keyToMatch."> <br>";
			foreach($value as $nestKey => $nestValue)
				echo "<option value='".$nestValue."'>".$nestValue."</option> <br>";
			echo "</select>";
			//do matchValue here
			echo "<p>Please enter the value to match:</p> <br>";
			echo "<input type=".$text." name=".$matchValue."> </input>";
		}//end find
		elseif($key == 'info'){
			echo "<p>Please select your info to process: </p> <br>";
			echo "<select name=".$infoToProcess."> <br>";
			foreach($value as $nestKey => $nestValue)
				echo "<option value='".$nestValue."'>".$nestValue."</option> <br>";
			echo "</select>";
		}//end info
	}//end first foreach
	?>

		<!-- Keep this boi -->
		<p>Select Sum or Average: </p> <br>
		<select name="sumOrAvg">
		<option value="sum">Sum</option>
		<option value="avg">Average</option>
		</select>
		<br>
		<br>
		<input type="submit" value = "Submit">
		</form>
		<?php
}
?>

<!-- PART 2: GIVING THE USER WHAT THEY WANT -->

<?php
function processInfo()
{
	$mediaString = file_get_contents("Media.json");
	$secondObject = json_decode($mediaString);
	$jsonError1 = json_last_error();
	if($jsonError1 != 0)
	{
		echo "There was an error in decoding the file. \n";
		return;
	}
	$file = "";
	$userKeyToMatch;
	$userMatchValue;
	$userInfoToProcess;
	$userOperation;
        $infoSum=0;

	if(isset($_GET['category']))
	{
		$toFind = $_GET['category'];
		$mediaFiles = $secondObject->categories;
		foreach($mediaFiles as $key => $value)
		{
			if($key == $toFind)
				{
					$file = $value;
				}
		}
		if($file == "")
		{
			echo "Incorrect category input \n";
		}	
	}
	else
	{
		echo "Category not set. \n";
	//	populateForm();
	}
	$searchFile = file_get_contents($file);
	if(isset($_GET['keyToMatch']))
	{
		$userKeyToMatch = $_GET['keyToMatch'];
	}
	else
	{
		echo "key to match not set \n";
	//	populateForm();
	}
	if(isset($_GET['matchValue']))
	{
		$userMatchValue = $_GET['matchValue'];
	}
	else
	{
		echo "match value not set \n";
	//	populateForm();
	}
	if(isset($_GET['infoToProcess']))
	{
		$userInfoToProcess = $_GET['infoToProcess'];
		$infoFiles = $secondObject
	}
	else
	{
			echo "Info to process not set \n";
	//	populateForm();
	}
	if(isset($_GET['sumOrAvg']))
	{
		$userOperation = $_GET['sumOrAvg'];
	}
	else
	{
		echo "Sum or Avg not set \n";
	//	populateForm();
	}
	
	//Check for userKeyToMatch
	$fileToRead = file_get_contents($file);
	$userFile = json_decode($fileToRead);
	$jsonError2 = json_last_error();
	if($jsonError2 != 0)
	{
		echo "There was an error in decoding the file. \n";
		return;
	}
	$works = $userFile->works;
	$comments = $userFile->comments;
	foreach($works as $key => $value)
	{
		if ($value->$userKeyToMatch == $userMatchValue)
		{
			echo "<p><strong>".printObject($value)."</p> <br>";
		}
		else
		{
			echo "<p>".printObject($value)."</p> <br>";
		}
	}

}

function printObject($object){
	foreach($object as $key => $value){
		echo "<p>".$key.": ".$value."</p>";
	}
}
?>
