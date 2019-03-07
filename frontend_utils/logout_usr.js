$(document).ready(ready_logout);
function ready_logout()
{
    $("#logout_button").click(onclick_logout_button);
}

function onclick_logout_button()
{
    console.log("onclick_logout_button func \n");
    var tmp_msg="not logged in";
    console.log(tmp_msg);
    $("#login_status").html(tmp_msg);
    //change cookie
    cookie_json=JSON.stringify({'usr_id':-1,'login_status':0,'level':-1});
    $.cookie('usr',cookie_json);
    console.log("cookie resetted \n");
}