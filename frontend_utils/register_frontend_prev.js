var home_dir="../";

function onsubmit_func()
{
    var url=home_dir+"backend_utils/register_backend.php?";
    // console.log('begin_onsubmit_func');
    
    var xmlhttp;

    if (window.XMLHttpRequest)
    {
        xmlhttp=new XMLHttpRequest();
    }
    else
    {
        
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
        
        response_txt=xmlhttp.responseText;
        console.log("register response:");
        console.log(response_txt);
        document.getElementById("server_response").innerHTML=response_txt;

        }
    }

    
    var usr_name=document.getElementById('name').value;
    // console.log("name:"+usr_name);
    var select_element=document.getElementById('gender');
    var selected_index=select_element.selectedIndex;
    // console.log("selected_index:"+String(selected_index));
    var select_options=select_element.options;
    var usr_gender=select_options[selected_index].text;
    // console.log("gender:"+usr_gender);
    var birthday_ele=document.getElementById('birthday');
    birthday=birthday_ele.value;
    // console.log("date_obj attributes: "+birthday_ele.value);
    
    url+="name="+usr_name;
    url+="&gender="+usr_gender;
    url+="&birthday="+birthday;
    xmlhttp.open("GET",url,true);
    xmlhttp.send();
}