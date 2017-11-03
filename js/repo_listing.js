$(function(){   
  dataTableStructure("file_handler.php?serach_key=");
  $("#search_label").removeAttr("hidden");

  $("#srach_button").click(function(e)    {      
        var serach_key =$("#search_box").val();
        $("#table_content").dataTable().fnDestroy();
        dataTableStructure("file_handler.php?serach_key="+serach_key);
    });

  $("#cancel_button").click(function(e)    {      
        var serach_key =$("#search_box").val();
        $("#table_content").dataTable().fnDestroy();
        dataTableStructure("file_handler.php?serach_key=");
        $("#search_box").val('');
    });
  
});

// Datatable intregration with html table

function dataTableStructure(file_path)
{
  var table=$("#table_content").dataTable({
            "sDom": '<"H"lfpir>t<"F"ip>',
            "bServerSide": true,            // customised server side ajax call (make it true)
            "sAjaxSource": file_path, // customised url
            "sAjaxDataProp" : "aaData",         // give your json parent reponse data name
            "sPaginationType": "full_numbers",
            "bProcessing": true,    
            "bFilter": false,
            "bInfo":true,
            "bLengthChange": true,
            "iDisplayLength": 5,    // no of rows for dataTable
            "aLengthMenu": [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]],
            "fnServerData": function ( sSource, aoData, fnCallback,oSettings) {
                    
                   $.ajax( {
                     "type" : "GET",
                     "url" : sSource,
                     "data" : aoData,
                     "success" : function(json) {
                        
                       var obj = jQuery.parseJSON((json)); 

                      // console.log(json);

                       fnCallback(obj);
                     }

                   });
            },
                 
            "aoColumns": [  // add your columns all name here
              {     
                "mData":"type",
                "bSearchable": true,
                "bSortable": true,
                 
              },{
                "mData": "username",
                "bSearchable": true, 
                
                   
              },{
                "mData": "name",
                "bSearchable": true, 
                "bSortable": true,
                
                
              },{
                "mData": "owner",
                "bSearchable": true,
                "bSortable": true,
                
                
              },{
                "mData": "homepage",
                "bSearchable": false, 
                "bSortable": true,
                
              },
              {     
                "mData":"description",
                "bSearchable": true,
                "bSortable": true,
                 
              },{
                "mData": "language",
                "bSearchable": true, 
                
                   
              },{
                "mData": "watchers",
                "bSearchable": true, 
                "bSortable": true,
                
                
              },{
                "mData": "followers",
                "bSearchable": true,
                "bSortable": true,
                
                
              },{
                "mData": "forks",
                "bSearchable": false, 
                "bSortable": true,
                
              },
              {     
                "mData":"size",
                "bSearchable": true,
                "bSortable": true,
                 
              },{
                "mData": "open_issues",
                "bSearchable": true, 
                
                   
              },{
                "mData": "score",
                "bSearchable": true, 
                "bSortable": true,
                
                
              },{
                "mData": "has_downloads",
                "bSearchable": true,
                "bSortable": true,
                
                
              },{
                "mData": "has_issues",
                "bSearchable": false, 
                "bSortable": true,
                
              },
              {
                "mData": "has_projects",
                "bSearchable": true, 
                
                   
              },{
                "mData": "has_wiki",
                "bSearchable": true, 
                "bSortable": true,
                
                
              },{
                "mData": "fork",
                "bSearchable": true,
                "bSortable": true,
                
                
              },{
                "mData": "private",
                "bSearchable": false, 
                "bSortable": true,
                
              },
              {
                "mData": "url",
                "bSearchable": true, 
                
                   
              },{
                "mData": "created",
                "bSearchable": true, 
                "bSortable": true,
                
                
              },{
                "mData": "created_at",
                "bSearchable": true,
                "bSortable": true,
                
                
              },{
                "mData": "pushed_at",
                "bSearchable": false, 
                "bSortable": true,
                
              },{
                "mData": "pushed",
                "bSearchable": false, 
                "bSortable": true,
                
              },

               ]
    });

}

function responsetrim(data){
  var i = data.indexOf("<!");

  if(i > 0)
    return data.slice(0, i);
  else
    return "";
}
