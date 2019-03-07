$(document).ready(ready_delete_usr);


function ready_delete_usr()
{
    
    $("#delete_usr_submit").click(onclick_delete_usr_submit);
}

function onclick_delete_usr_submit()
{
    var delete_usr_id=$("#delete_usr_usr_id").val();
    console.log("to delete usr:"+delete_usr_id+"\n");
    var cookie_json=$.cookie('usr');
    cookie_json=JSON.parse(cookie_json);
    var login_status=cookie_json.login_status;
    login_status=Number(login_status);
    var my_usr_id=Number(cookie_json.usr_id);
    var POST_para={delete_usr_id:delete_usr_id,my_usr_id:my_usr_id};
    $.post("backend_utils/delete_usr.php",POST_para,delete_usr_callback);
}

function delete_usr_callback(data,status)
{
    console.log("data:"+data+"\n");
}