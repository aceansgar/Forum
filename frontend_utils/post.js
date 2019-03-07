$(document).ready(ready_post);

function ready_post()
{
    $("#post_content").css({'width':'600px','height':'50px'});
    $("#post_submit").click(onclick_post_submit); 
}

function onclick_post_submit()
{
    
    var post_content=$('#post_content').val();
    // console.log(post_content);
    var cookie_json=$.cookie('usr');
    cookie_json=JSON.parse(cookie_json);
    var login_status=cookie_json.login_status;
    login_status=Number(login_status);
    var usr_id=Number(cookie_json.usr_id);
    if(login_status==0)
    {
        //not logged in, cannot post
        var tmp_msg="not logged in, cannot post\n";
        console.log(tmp_msg);
        alert(tmp_msg);
    }
    else
    {
        //logged in, can post
        console.log("post of usr_id: "+String(usr_id)+"\n");
        console.log("post content: "+post_content+"\n");
        //prepare parameters
        var post_title=$("#post_title").val();
        var block_id=$('#post_block_id').val();
        block_id=Number(block_id);



        var POST_para={usr_id:usr_id,post_title:post_title,post_content:post_content,block_id:block_id};
        $.post("backend_utils/post.php",POST_para,post_POST_callback);

    }
    
}

function post_POST_callback(data,status)
{
    console.log("post_POST_callback: \n");
    console.log("data:"+data+"\n");
    console.log("status:"+status+"\n");
}