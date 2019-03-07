
$(document).ready(ready_login);

function ready_login()
{
    
    $("#login_button").click(process_login);
}

function process_login()
{
    console.log("process_login begin\n");
    var login_name=$("#login_name").val();
    var login_password=$("#login_password").val();
    var login_para={login_name:login_name,login_password:login_password};
    $.post("backend_utils/login.php",login_para,login_post_callback);
}

function login_post_callback(data,status)
{
    console.log("login_post_callback_begin \n");
    // console.log("data: \n"+data+"[end]\n");
    // console.log("type of data: \n"+typeof(data)+"\n");
    try 
    {
    parser=new DOMParser();
    xmlDoc=parser.parseFromString(data,"text/xml");
    }
    catch(e) {alert(e.message);}
    

    var login_response_login_status=xmlDoc.getElementsByTagName("login_status")[0].childNodes[0].nodeValue;
    login_response_login_status=Number(login_response_login_status);
    console.log("login status:"+String(login_response_login_status)+"\n");
    
   
    var login_response_usr_id=xmlDoc.getElementsByTagName("usr_id")[0].childNodes[0].nodeValue;
    
    console.log("login_response_usr_id: "+String(login_response_usr_id)+"\n");
    var login_response_text=xmlDoc.getElementsByTagName("echo_text")[0].childNodes[0].nodeValue;
    console.log("\n\nlogin_response_text: "+login_response_text+"\n");
    

    if(login_response_login_status==1)
    {
        $("#login_status").html("logged in, usr_id="+login_response_usr_id);
    }
    
    // try
    // {
    //     $.cookie('login_status',login_response_login_status)//type: number
    // }
    // catch(err)
    // {
    //     console.log("cookie err:"+err+"\n");
    // }
    // $.cookie('login_status',login_response_login_status)//type: number
    var usr_id=login_response_usr_id;
    var login_status=login_response_login_status;
    
    cookie_json=JSON.stringify({'usr_id':usr_id,'login_status':login_status,'level':-1});
    // console.log("here\n");
    $.cookie('usr',cookie_json);
    console.log("here\n");
}

// var login_status=$.cookie('login_status');
// console.log("login_status: "+String(login_status)+"\n");




