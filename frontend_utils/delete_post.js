$(document).ready(ready_delete_post);


function ready_delete_post()
{
    
    $("#delete_post_submit").click(onclick_delete_post_submit);
}

function onclick_delete_post_submit()
{
    var delete_post_no=$("#delete_post_post_no").val();
    console.log("to delete post:"+delete_post_no+"\n");
    var cookie_json=$.cookie('usr');
    cookie_json=JSON.parse(cookie_json);
    var login_status=cookie_json.login_status;
    login_status=Number(login_status);
    var my_usr_id=Number(cookie_json.usr_id);
    var POST_para={delete_post_no:delete_post_no,my_usr_id:my_usr_id};
    $.post("backend_utils/delete_post.php",POST_para,delete_post_callback);
}

function delete_post_callback(data,status)
{
    console.log("data:"+data+"\n");
}