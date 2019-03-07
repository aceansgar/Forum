$(document).ready(ready_hottest_in_block);

function ready_hottest_in_block()
{
    $("#hottest_in_block_submit").click(onclick_hottest_in_block_submit);
}

function onclick_hottest_in_block_submit()
{
    var block_id=$("#hottest_in_block_id").val();
    var POST_para={block_id:block_id};
    $.post("backend_utils/hottest_in_block.php",POST_para,hottest_in_block_callback);
}

function hottest_in_block_callback(data,status)
{
    console.log("data:"+data+"\n");
    try 
    {
    parser=new DOMParser();
    xmlDoc=parser.parseFromString(data,"text/xml");
    }
    catch(e) {alert(e.message);}
    var hottest_post_no_ele=xmlDoc.getElementsByTagName("hottest_post_no")[0];
    // console.log(typeof(hottest_post_no_ele));
    
    var hottest_post_no=hottest_post_no_ele.childNodes[0].nodeValue;
    console.log("hottest_post_no:"+hottest_post_no+"\n");
    str_append="<p>hottest_post_no: "+hottest_post_no+"</p>";
    str_append+="<p>usr_name of those who replied:"
    var usr_name_node_list=xmlDoc.getElementsByTagName("usr_name");
    var usr_name_node_cnt=usr_name_node_list.length;
    for(var i=0;i<usr_name_node_cnt;i++)
    {
        var usr_name=usr_name_node_list[i].childNodes[0].nodeValue;
        str_append+=usr_name+",";
    }
    $("#div_hottest_in_block").append(str_append);
}