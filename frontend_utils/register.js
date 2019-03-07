
function onclick_register_submit()
{
    var register_name=$("#register_name").val();
    var register_password=$("#register_password").val();
    var register_gender=$("#register_gender").val();
    var register_birthday=$("#register_birthday").val();
    var post_para={register_name:register_name,register_password:register_password,register_gender:register_gender,
    register_birthday:register_birthday};
    $.post("backend_utils/register.php",post_para,register_post_callback);

}

function register_post_callback(data,status)
{
    console.log("register response: \n");
    console.log("data: "+data);
    console.log("status: "+status);
}

function ready_register()
{
    $("#register_submit").click(onclick_register_submit);
}

$(document).ready(ready_register);