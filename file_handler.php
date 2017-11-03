<?php
    require_once("repositories_data_listing.php");

	//creating a object for class repositoriesListing
    $repositoriesListing = new repositoriesListing();
	
	//fetching repo data  on bases of parameter passed 
	if(!isset($_GET['serach_key']))
	{
		$key = "";
		$repositoriesListing->repositoryListing($key); // with no search keyword
	}
	else
	{
		$repositoriesListing->repositoryListing($_GET['serach_key']); // with search keyword
	}
