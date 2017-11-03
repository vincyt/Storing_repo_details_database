This application is used to store Symfony repositories*** in local system and display on screen

Step 1. Please excute cmd : 
			php composer.phar update

Step 2. Please open console and excute cmd : 
			 php {USERLOCALPATH}/Export_symphony_github_repo.php {dbhost} {dbusername} {dbpassword}

			 where 
			 {USERLOCALPATH} = your system path where file is stored
			 {dbhost} = database host (Please replace {dbhost} with your dbhost ex : localhost)
			 {dbusername} = database login username (Please replace {dbusername} with your username ex : root)
			 {dbpassword} = database login password (Please replace {dbpassword} with your password ex : 123)

	    Export_symphony_github_repo.php will import all the repository from https://github.com/symfony and will store the same in your database.

Step 3. Please open repositories_data_listing.php file in any editor. Replace {dbhost} {dbusername} {dbpassword} in line number 28 with your database detail (same details used in step 2)

Step 4. Please browser '{localhostPath}/repositories_data_listing_view.php'. Data stored in database step 2 will be 		fetched here and displayed in table format with pagination , sorting and serach functionality.
			
			where
			{localhostPath} = localhost path (Please replace this with your localhost path ex: http://localhost/Storing_repo_details_database/repositories_data_listing_view.php)
