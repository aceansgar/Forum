$(document).ready(ready_query_usr_info);


function ready_query_usr_info()
{
    $("#query_usr_info_submit").click(onclick_query_usr_info_submit);
}

function onclick_query_usr_info_submit()
{
    var usr_id=$("#query_usr_info_usr_id").val();
    var POST_para={usr_id:usr_id};
    $.post("backend_utils/query_usr_info.php",POST_para,query_usr_info_callback);
}

function query_usr_info_callback(data,status)
{
    console.log("data:"+data+"\n");
        
}