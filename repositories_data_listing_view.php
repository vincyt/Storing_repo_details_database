
<html>
<head>

<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/repo_listing.js"></script>
<script src="js/jquery.dataTables.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css"/>
 <script>

</script>
</head>
<body>

<h2 align='center'>Repository Listing</h2>

<div style="text-align: center;">
<img src="images/loading_apple.gif" style="width: 88px;display:none" id="loading_icon">
</div >
<br>

   <label style="margin-left: 787px;" id="search_label" hidden> Search: <input aria-controls="table_content" type="text" id ="search_box"><input type="Button" name="srach_button" id="srach_button" value="Search"> <input type="Button" name="cancel_button" id="cancel_button" value="Cancel"> </label><br><br>

   
   <div>
  <table id="table_content" border=1 >
    <thead>
        <tr>
            <th>type </th><th>username </th><th>name </th><th>owner</th><th>homepage</th><th>description</th><th>language</th><th>watchers</th><th>followers</th><th>forks</th><th>size</th><th>open_issues</th><th>score</th><th>has_downloads</th><th>has_issues</th><th>has_projects</th><th>has_wiki</th><th>fork </th><th>private</th><th>url </th><th>created </th><th> created_at </th><th>pushed_at </th><th>pushed </th>
        </tr>
    </thead>
    <tbody>
    </tbody>
    </table>  
</div>

</body>
</html>

