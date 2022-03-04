<?php
//Cloud Music - Kyle Vanderburg
//Don't forget to read aa-readme.txt

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
	
	//This section puts different values into the DB depending on whether the method is Web or Random. Random is unused in this iteration.
	//Check to see if the method is set
	if(isset($_GET['method'])){$method=$_GET['method'];
		
		//Method is set, check to see if it's random or Web
		if($method=="random"){
			$row['name'] = "kyle".rand(5,100);
			$row['direction'] = rand(0,1);
			$row['rise'] = rand(10000,20000);
			$row['float'] = rand(10000,20000);
			$row['fall'] = rand(10000,20000);
			$row['alt'] = rand(100,5000);
			$row['thunder'] = rand(0,1);
		}elseif($method=="web"){
			//if Web, use all those $_GET variables
			$row['name'] = $_GET['name'];
			$row['direction'] = $_GET['direction'];
			$row['rise'] = $_GET['rise'];
			$row['float'] = $_GET['float'];
			$row['fall'] = $_GET['fall'];
			$row['alt'] = $_GET['alt'];
			$row['thunder'] = $_GET['thunder'];
		}
		
		//Here's how we put this into the database
		$cloud->create(); //Create a blank row
		$cloud->update($row); //fill that row with our values
		
		//This won't work with your setup, unfortunately. Here's how it works.
		//Create():
		//We create a new row by executing the query $query = "INSERT INTO " . $this->db . " (`id`) VALUES (NULL)";
		//where $this->db is your database table.
		//You _Could_ insert your $row variables in this query, but with the way that Liszt works, it creates a blank row, then updates the created_by and created_time and modified_by and etc. variables, which is why the create and update functions are separated.
		
		//Update($row):
		//We insert the variables by running something like
		//$query = "UPDATE " . $this->db . " SET {$values} WHERE `id`='{$this->id}'";
		//where $values is some string like "`name` = 'Kyle' AND `float` = '10000'" and so on.
		
		//This is totally diagnotic information, the referring page doesn't need it.
		echo json_encode($row);
		}
?>