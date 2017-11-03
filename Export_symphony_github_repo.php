<?php

/* Parameter for cron call

php file_name dbhaost dbusername dbpassword dbname >> log_file path

*/

require_once 'vendor/autoload.php';

echo "File Exceution started : ",date("Y-m-d h:i:sa"),PHP_EOL;
if ($argc > 1) {
    $dbhost = $argv[1]; // ex: localhost
    $dbuser = $argv[2]; // ex: root
    $dbpass = isset($argv[3])?$argv[3]:''; // ex: password
} else {
    echo 'Usage: php Export_symphony_github_repo.php "127.0.0.1" "DB_USERNAME" "DB_PASSWORD" "DB_NAME"';
    exit;
}
$db_name = 'symphony';  // database name 
$table_name = 'symphony_table'; // table name where data will be stored 

date_default_timezone_set('GMT');


	/*
     * Get extended information about a repository .
     *
     * @param integer $dbhost dbhost details
     *
     *
     * @param integer $dbuser db login username
     *
     *
     * @param integer $dbpass db login password
     *
     *
     * @param integer $db database name
     *
     * @return database connection object
     */
function create_database_connection($dbhost, $dbuser, $dbpass,$db){
	if($db='')
	{
		$mysqli = new mysqli($dbhost, $dbuser, $dbpass);
	}
	else
	{
		$mysqli = new mysqli($dbhost, $dbuser, $dbpass,$db);
	}

    return $mysqli;
}
echo "Start:",date("Y-m-d h:i:sa"),PHP_EOL;



$conn = create_database_connection($dbhost, $dbuser, $dbpass,'');
if ($conn->connect_errno) { echo "Failed to connect to MySQL: " . $mysqli->connect_error; die(); } // throws error if connection is not established


/*
*Connecting to database 
*/
$sql = "CREATE DATABASE IF NOT EXISTS ".$db_name;
if ($conn->query($sql) === TRUE) {
	$conn = create_database_connection($dbhost, $dbuser, $dbpass,$db_name);
    echo "Database connected successfully :",date("Y-m-d h:i:sa"),PHP_EOL; // conneted successfull 
} else {
    echo "Error creating database: " . $conn->error; // connection failed
}

$conn->set_charset("utf8");

echo "Starting to extract data from https://github.com/symfony at : ",date("Y-m-d h:i:sa"),PHP_EOL;

$client = new \Github\Client();		// creating a  client object	
$repo = $client->api('repo')->find('https://github.com/symfony'); //fetching all the repo placed in url https://github.com/symfony

if(empty($repo))
{
	echo "Exceution Stoped. Please try after some time : ",date("Y-m-d h:i:sa"),PHP_EOL;
	throw new \RuntimeException(sprintf('Unrecognized url "%s"', 'https://github.com/symfony'));	
}
else
{
	echo "Data extraction from https://github.com/symfony done : ",date("Y-m-d h:i:sa"),PHP_EOL;
	echo "Intiaiting to store extract data from https://github.com/symfony in database : ",date("Y-m-d h:i:sa"),PHP_EOL;
	echo "Please be patient. This may take some time......",PHP_EOL;
	
	/*
	* Creating a table (if not exist) with same column name as in repo https://github.com/symfony
	*/

	$sql = "CREATE TABLE IF NOT EXISTS ".$db_name.".".$table_name."(
	    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	    type VARCHAR(30) NOT NULL,
	    username VARCHAR(30) NOT NULL,
	    name VARCHAR(70) NOT NULL,
	    owner VARCHAR(70) NOT NULL,
	    homepage VARCHAR(70) ,
	    description TEXT,
	    language VARCHAR(70) ,
	    watchers INT,
	    followers INT ,
	    forks INT ,
	    size INT,
	    open_issues INT,
	    score FLOAT,
	    has_downloads INT,
	    has_issues INT,
	    has_projects INT,
	    has_wiki INT,
	    fork TEXT,
	    private TEXT,
	    url TEXT NOT NULL,
	    created DATE,
	    created_at DATE,
	    pushed_at DATE,
	    pushed DATE
	)";
	if($conn->query($sql)){
	    echo "1. Table created successfully.... :",date("Y-m-d h:i:sa"),PHP_EOL;
	} else{
	    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);die();
	}

	/*
	* deleting old data inorder to accomodate new data
	*/

	$sql = "TRUNCATE ".$db_name.".".$table_name;
	if($conn->query($sql)){
	    echo "2. Truncating existing data if any.... :",date("Y-m-d h:i:sa"),PHP_EOL;
	} else{
	    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);die();
	}

	$DataArr = array();
	echo "3. Starting to insert data in table .... :",date("Y-m-d h:i:sa"),PHP_EOL;

	/*
	* Inserted repo data fetched from https://github.com/symfony
	*/

	foreach($repo['repositories'] as $key => $row){
        $fieldVal1 = !empty($row['type'])?$row['type']:'';
        $fieldVal2 = !empty($row['username'])?$row['username']:'';
        $fieldVal3 = !empty($row['name'])?$row['name']:'';
        $fieldVal4 = !empty($row['owner'])?$row['owner']:'';
        $fieldVal5 = !empty($row['homepage'])?$row['homepage']:'';
        $fieldVal6 = !empty($row['description'])?$row['description']:'';
        $fieldVal6 = str_replace('"', "", $fieldVal6);
        $fieldVal6 = str_replace('"', "", $fieldVal6);
        $fieldVal7 = !empty($row['language'])?$row['language']:'';

        $fieldVal8 = !empty($row['watchers'])?$row['watchers']:0;
        $fieldVal9 = !empty($row['followers'])?$row['followers']:0;
        $fieldVal10 = !empty($row['forks'])?$row['forks']:0;
        $fieldVal11 = !empty($row['size'])?$row['size']:0;
        $fieldVal12 = !empty($row['open_issues'])?$row['open_issues']:0;
        $fieldVal13 = !empty($row['score'])?$row['score']:0;
        $fieldVal14 = !empty($row['has_downloads'])?$row['has_downloads']:0;
        $fieldVal15 = !empty($row['has_issues'])?$row['has_issues']:0;
        $fieldVal16 = !empty($row['has_projects'])?$row['has_projects']:0;
        $fieldVal17 = !empty($row['has_wiki'])?$row['has_wiki']:0;

        $fieldVal18 = !empty($row['fork'])?$row['fork']:'';
        $fieldVal19 = !empty($row['private'])?$row['private']:'';
        $fieldVal20 = !empty($row['url'])?$row['url']:'';
        $fieldVal6 = str_replace("'",'\'',($fieldVal6));
        $fieldVal21 = !empty($row['created'])?$row['created']:'';
        $fieldVal22 = !empty($row['created_at'])?$row['created_at']:'';
        $fieldVal23 = !empty($row['pushed_at'])?$row['pushed_at']:'';
        $fieldVal24 = !empty($row['pushed'])?$row['pushed']:'';
      

        $DataArr[] = '("'.$fieldVal1.'", "'.$fieldVal2.'", "'.$fieldVal3.'","'.$fieldVal4.'", "'.$fieldVal5.'", "'.$fieldVal6.'","'.$fieldVal7.'", '.$fieldVal8.', '.$fieldVal9.','.$fieldVal10.', '.$fieldVal11.', '.$fieldVal12.','.$fieldVal13.', '.$fieldVal14.','.$fieldVal15.','.$fieldVal16.', '.$fieldVal17.', "'.$fieldVal18.'","'.$fieldVal19.'", "'.$fieldVal20.'", "'.$fieldVal21.'","'.$fieldVal22.'", "'.$fieldVal23.'", "'.$fieldVal24.'")';
    }
    $sql = "INSERT INTO ".$db_name.".".$table_name." (type ,username ,name ,owner,homepage,description,language,watchers,followers,forks,size,open_issues,score,has_downloads,has_issues,has_projects,has_wiki,fork ,private,url ,created , created_at ,pushed_at ,pushed) values ";
    $sql .= implode(',', $DataArr);
 
	if($conn->query($sql)){
	    echo "4. Inserted data in table successfully.... :",date("Y-m-d h:i:sa"),PHP_EOL;
	} else{
	    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);die();
	}

	echo "Exceution Finished.... :",date("Y-m-d h:i:sa"),PHP_EOL;
}