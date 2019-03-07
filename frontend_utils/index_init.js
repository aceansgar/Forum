//load cookie ,tell if logged in


function index_init()
{
    var cookie_json=$.cookie('usr');
    cookie_json=JSON.parse(cookie_json);
    var login_status=Number(cookie_json.login_status);
    if(login_status==1)
    {
        var usr_id=Number(cookie_json.usr_id);
        $("#login_status").html("logged in, usr_id="+String(usr_id));
    }
}

$(document).ready(index_init);