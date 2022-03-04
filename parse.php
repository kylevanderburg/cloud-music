<?php
//Cloud Music - Kyle Vanderburg
//Code that references NoteForge Liszt functions are prefixed LZ.

	//LZ: Liszt is built on a thing called Hammer, so we'll load and initiate Hammer
	require_once "/var/www/api.ntfg.net/htdocs/hammer/hammer.php";
	$hammer = new Hammer;
	
	//Load database variables specific to this site
	$hammer->setHS(1);
	
	//Debug line
	// $hammer->debug();
	
	//LZ: vanderburg_cloudmusic_cloud is a PHP class that includes a bunch of functions for reading/writing to the DB. We'll initiate it here.
	$cloud = new vanderburg_cloudmusic_cloud($hammer);
	
	//This section retrieves values from the DB or generates random ones depending on whether the method is Web or Random.
	//Check to see if the method is set
	if(isset($_GET['s'])){$source=$_GET['s'];}
	
	//Source is Database
	if($source=="db"){
		//Get the oldest non-performed cloud
		$allrow = $cloud->q("`performed` < 1","ORDER BY id ASC LIMIT 1");
		
		//Make sure that actually returned a value
		if(count(array_filter($allrow))>0){
			
			//$cloud->q only runs a query, we need to actually load that item. This is stupid and redundant but I haven't fixed it yet.
			$cloud->getByID($allrow[0]['id']);
			
			//Calculate the rise+float+fall time for total
			$cloud->row['total'] = $cloud->row['rise']+$cloud->row['float']+$cloud->row['fall'];
			
			//Return the row, in a JSON format that Max understands
			echo json_encode($cloud->row, JSON_NUMERIC_CHECK);
			
			//Update the cloud we've loaded from the DB and tell it that we've performed it.
			$push['performed']=1;
			$cloud->update($push);
		}else{
			//There are no clouds to perform
			echo "done";			
		}
		
	//Source is Random
	}elseif($source=="random"){
		//Do the same thing as above, but just make up stuff.
		$row['name'] = "random".rand(5,100);
		$row['direction'] = rand(0,1);
		$row['rise'] = rand(10000,20000);
		$row['float'] = rand(10000,20000);
		$row['fall'] = rand(10000,20000);
		$row['alt'] = rand(100,5000);
		$row['thunder'] = rand(0,1);
		$row['total'] = $row['rise']+$row['float']+$row['fall'];
		echo json_encode($row, JSON_NUMERIC_CHECK);
	}else{
		//Source isn't set
		echo "Source method not specified";
	}
?>