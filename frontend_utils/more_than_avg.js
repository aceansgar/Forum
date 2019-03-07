$(document).ready(ready_more_than_avg);

function ready_more_than_avg()
{
    $("#more_than_avg_submit").click(onclick_more_than_avg_submit);
}

function onclick_more_than_avg_submit()
{
    var block_id=$("#more_than_avg_block_id").val();
    var POST_para={block_id:block_id};
    $.post("backend_utils/more_than_avg.php",POST_para,more_than_avg_callback);
}

function more_than_avg_callback(data,status)
{
    console.log("data:"+data+"\n");
    try 
    {
    parser=new DOMParser();
    xmlDoc=parser.parseFromString(data,"text/xml");
    }
    catch(e) {alert(e.message);}
    var post_list=xmlDoc.getElementsByTagName("post_no");
    var post_node_cnt=post_list.length;
    // console.log(post_node_cnt);
    var str_append="<p>more-than-average post_no:";
    for(var i=0;i<post_node_cnt;i++)
    {
        var post_no=post_list[i].childNodes[0].nodeValue;
        str_append+=String(post_no)+",";
    }
    str_append+="</p>";
    $("#div_more_than_avg").append(str_append);
    
    var usr_list=xmlDoc.getElementsByTagName("usr_id");
    var usr_node_cnt=usr_list.length;
    var str_append="<p>more-than-average usr_id:";
    for(var i=0;i<usr_node_cnt;i++)
    {
        var usr_id=usr_list[i].childNodes[0].nodeValue;
        str_append+=String(usr_id)+",";
    }
    str_append+="</p>";
    $("#div_more_than_avg").append(str_append);
}