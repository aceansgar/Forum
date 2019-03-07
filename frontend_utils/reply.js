$(document).ready(ready_reply);
var disp_num=3;

function ready_reply()
{
    for (var i=0;i<disp_num;i++)
    {
        var tmp_button_selector_str="#disp_reply_submit"+String(i);
        $(tmp_button_selector_str).click(onclick_disp_reply_submit);
    }
}

function onclick_disp_reply_submit()
{
    var tmp_disp_div_ele=$(this).parent().parent().parent();
    var disp_info_ele=tmp_disp_div_ele.children(".info");
    //need reply_original_post_no,reply_usr_id,reply_content,
    
    var reply_original_post_no=disp_info_ele.attr('post_no');
    var cookie_json=$.cookie('usr');
    cookie_json=JSON.parse(cookie_json);
    var login_status=cookie_json.login_status;
    login_status=Number(login_status);
    var usr_id=Number(cookie_json.usr_id);
    if(login_status==0)
    {
        var tmp_msg="not logged in , cannot reply\n";
        alert(tmp_msg);
        console.log(tmp_msg);
        return;
    }
    var reply_usr_id=usr_id;
    var reply_content_ele=$(this).parent().children(".text");
    var reply_content=reply_content_ele.val();
    var POST_para={reply_original_post_no:reply_original_post_no,reply_usr_id:reply_usr_id,reply_content:reply_content};
    $.post("backend_utils/reply.php",POST_para,reply_callback);
}

function reply_callback(data,status)
{
    console.log("reply_callback: \n");
    console.log(data+"\n");
}