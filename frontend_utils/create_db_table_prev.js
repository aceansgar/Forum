function onsubmit_func()
{
    var table_name=document.getElementById("table_input").value;
    console.log("table_name: "+table_name);
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
        console.log("get response:");
        console.log(response_txt);
        document.getElementById("server_response").innerHTML=response_txt;

        }
    }
    var url="../backend_utils/create_db_table.php?";
    url+="table_name="+table_name;
    xmlhttp.open("GET",url,true);
    xmlhttp.send();
}