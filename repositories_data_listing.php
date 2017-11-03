<?php

require_once 'vendor/autoload.php';

/**
 * Listing all the repository in symfony using php github api 2.0 
 */
class repositoriesListing
{
	public function __construct()
    {
    }
	/*
     * Get extended information about a repository .
     *
     * @param integer $search_key search keyword is passed to get the repository details related to searched keyword
     *
     * @return array information about a repository 
     *
     * @throws \RuntimeException When an invalid option is provided
     */ 
	public function repositoryListing($search_key)
    {
    	$repositoriesListing = new repositoriesListing();
        /*
            db connection establishment
        */
    	$conn = $repositoriesListing->create_database_connection('{dbhost}', '{dbusername}', '{dbpassword}','symphony');
		if ($conn->connect_errno) { echo "Failed to connect to MySQL: " . $mysqli->connect_error; die(); }
    	$sTables = array(
            "symphony.symphony_table"
        );
        /*
            table columns to be fetched
        */
        $aColumns = array(
            "type","username","name","owner","homepage","description","language","watchers","followers","forks","size","open_issues","score","has_downloads","has_issues","has_projects","has_wiki","fork","private","url","created","created_at","pushed_at","pushed"
        );

        $Columns_AS_Names = array(
            "type","username","name","owner","homepage","description","language","watchers","followers","forks","size","open_issues","score","has_downloads","has_issues","has_projects","has_wiki","fork","private","url","created","created_at","pushed_at","pushed"
        );
        if($search_key == "")
        {
            $sWhere ='';
        }
        else
        {
            $sWhere = "WHERE `id` LIKE '%".$search_key."%'
            OR `type` LIKE '%".$search_key."%'
            OR `username` LIKE '%".$search_key."%'
            OR `name` LIKE '%".$search_key."%'
            OR `owner` LIKE '%".$search_key."%'
            OR `homepage` LIKE '%".$search_key."%'
            OR `description` LIKE '%".$search_key."%'
            OR `language` LIKE '%".$search_key."%'
            OR `watchers` LIKE '%".$search_key."%'
            OR `followers` LIKE '%".$search_key."%'
            OR `forks` LIKE '%".$search_key."%'
            OR `size` LIKE '%".$search_key."%'
            OR `open_issues` LIKE '%".$search_key."%'
            OR `score` LIKE '%".$search_key."%'
            OR `has_downloads` LIKE '%".$search_key."%'
            OR `has_issues` LIKE '%".$search_key."%'
            OR `has_projects` LIKE '%".$search_key."%'
            OR `has_wiki` LIKE '%".$search_key."%'
            OR `fork` LIKE '%".$search_key."%'
            OR `private` LIKE '%".$search_key."%'
            OR `url` LIKE '%".$search_key."%'";            
        }

        $sIndexColumn = "id";

        $sLimit = "";
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = "LIMIT " . intval($_GET['iDisplayStart']) . ", " . intval($_GET['iDisplayLength']);
        }

        /*
         * Ordering
         */
        $sOrder = "";
        if (isset($_GET['iSortCol_0'])) {
            $sOrder = "ORDER BY  ";
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $sOrder .= $aColumns[intval($_GET['iSortCol_' . $i])] . "
                        " . ($_GET['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc') . ", ";
                }
            }

            $sOrder = substr_replace($sOrder, "", -2);
            if ($sOrder == "ORDER BY") {
                $sOrder = "";
            }
        }


        /*
         * Columns As Names for assignments and with same no of columns
         * if no as column then please specify ""
         */
        $all_columns = "";

        if (Count($Columns_AS_Names) > 0) {
            if (Count($aColumns) == Count($Columns_AS_Names)) {
                foreach ($Columns_AS_Names as $key => $As_Name) {
                    if ($As_Name == "") {
                        $all_columns .= $aColumns[$key] . ",";
                    } else {
                        $all_columns .= $aColumns[$key] . " AS " . $As_Name . ",";
                    }
                }
                $all_columns = substr_replace($all_columns, "", -1);
            }
        } else {
            $all_columns = str_replace(" , ", " ", implode(", ", $aColumns));
        }

        /*
         * SQL queries
         * Get data to display as per the iDisplayLength
         */
        $sQuery = "
            SELECT  " . $all_columns . "
            FROM   " . str_replace(" , ", " ", implode(", ", $sTables)) . "
            $sWhere
            $sOrder            
            $sLimit
        ";
        
        $rResult = array();
		$res = $conn->query($sQuery);
		while($row = $res->fetch_assoc()) {array_push($rResult,$row);}

        /*
         * SQL queries
         * Get data to count for iTotalRecords
         */
        $cQuery = "
            SELECT Count(DISTINCT " . $sIndexColumn . ") as iTotal
            FROM   " . str_replace(" , ", " ", implode(", ", $sTables)) . "
            $sWhere
        ";

        $crResult = array();

        $res = $conn->query($cQuery);
		while($row = $res->fetch_assoc()) array_push($crResult,$row);
		if(count($crResult)>0)
		{
			$iTotal = $crResult[0];
            $iTotal = $iTotal["iTotal"];
		}
		else
		{
			$iTotal = "0";
		}
        /*
         * Output,
         */
        $output = array(
            "sEcho" => intval(isset($_GET['sEcho']) ? $_GET['sEcho'] : 0),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iTotal,
            "aaData" => $rResult,
        );

        echo json_encode($output);
    
	}	

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
	public function create_database_connection($dbhost, $dbuser, $dbpass,$db){
		$mysqli = new mysqli($dbhost, $dbuser, $dbpass,$db);
		return $mysqli;
	}	
}
	

	