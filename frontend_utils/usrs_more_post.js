$(document).ready(ready_usrs_more_post);


function ready_usrs_more_post()
{
    
    $("#usrs_more_post_submit").click(onclick_usrs_more_post_submit);
}

function onclick_usrs_more_post_submit()
{
    var block_id_a=$("#usrs_more_post_block_a").val();
    var block_id_b=$("#usrs_more_post_block_b").val();
    var POST_para={block_id_a:block_id_a,block_id_b:block_id_b};
    $.post("backend_utils/usrs_more_post.php",POST_para,usrs_more_post_callback);
}

function usrs_more_post_callback(data,status)
{
    console.log("data:"+data+"\n");
    try 
    {
    parser=new DOMParser();
    xmlDoc=parser.parseFromString(data,"text/xml");
    }
    catch(e) {alert(e.message);}
    var append_str="<p>users of more post in block A than in block B: </p>";
    append_str+="<p>usr_name: "
    

    var usr_list=xmlDoc.getElementsByTagName("usr_id");
    var usr_node_cnt=usr_list.length;
    for(var i=0;i<usr_node_cnt;i++)
    {
        var usr_id=usr_list[i].childNodes[0].nodeValue;
        append_str+=usr_id+",";
    }
    $("#div_usrs_more_post").append(append_str);
    
}