$(document).ready(ready_usrs_in_block);


function ready_usrs_in_block()
{
    
    $("#usrs_in_block_submit").click(onclick_usrs_in_block_submit);
}

function onclick_usrs_in_block_submit()
{
    
    var usrs_in_block_block_id=$("#usrs_in_block_block_id").val();
    var usrs_in_block_rank_method=$("#usrs_in_block_rank_method").val();
    // console.log(String(usrs_in_block_block_id));
    // console.log(usrs_in_block_rank_method);
    POST_para={block_id:usrs_in_block_block_id,usrs_rank_method:usrs_in_block_rank_method};
    $.post("backend_utils/usrs_in_block.php",POST_para,usrs_in_block_submit_callback);
}

function usrs_in_block_submit_callback(data,status)
{
    console.log("data:"+data+"\n");
    try 
    {
    parser=new DOMParser();
    xmlDoc=parser.parseFromString(data,"text/xml");
    }
    catch(e) {alert(e.message);}
    // var append_str="<p>"+data+"</p>";
    // console.log(append_str);
    // $("#usrs_in_block").append(append_str);
    var info_node_list=xmlDoc.getElementsByTagName("usr_info");
    var info_node_list_len=info_node_list.length;
    for (var i=0;i<info_node_list_len;i++)
    {
        var tmp_info_node=info_node_list[i];
        var tmp_gender_node=tmp_info_node.childNodes[0];
        var tmp_birthday_node=tmp_info_node.childNodes[1];
        var tmp_gender=tmp_gender_node.childNodes[0].nodeValue;
        var tmp_birthday=tmp_birthday_node.childNodes[0].nodeValue;
        var append_str="<p>"+"gender:"+tmp_gender+","+"birthday:"+tmp_birthday+"</p>";
        $("#usrs_in_block").append(append_str);
    }
}