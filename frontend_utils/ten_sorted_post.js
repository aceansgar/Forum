//find ten posts

$(document).ready(ready_ten_sorted_post);

function ready_ten_sorted_post()
{
    $("#ten_sorted_post_submit").click(onclick_ten_sorted_post_submit);
}

function onclick_ten_sorted_post_submit()
{
    var sort_method=$("#ten_sorted_post_method_select").val();
    console.log("sort_method:"+sort_method+"\n");
    var disp_num=10;
    var POST_para={disp_num:disp_num,rank_method:sort_method};
    $.post("backend_utils/get_post_no_list.php",POST_para,ten_sorted_post_callback);

}

function ten_sorted_post_callback(data,status)
{
    //data is xml string
    // console.log("response data:\n"+data+"\n");
    try 
    {
    parser=new DOMParser();
    xmlDoc=parser.parseFromString(data,"text/xml");
    }
    catch(e) {alert(e.message);}
    var post_no_ele_list=xmlDoc.getElementsByTagName("post_no");
    // console.log("type:"+typeof(post_no_ele_list)+"\n");
    var list_len=post_no_ele_list.length;
    // console.log("list_len: "+String(list_len)+"\n");
    for(var i=0;i<list_len;i++)
    {
        var tmp_post_no=post_no_ele_list[i].childNodes[0].nodeValue;
        tmp_post_no=Number(tmp_post_no);
        POST_para={post_no:tmp_post_no,disp_id:i};
        $.post("backend_utils/get_post_by_no.php",POST_para,get_ten_sorted_post_by_no_callback);
        // id_disp_title="disp_title"+String(i);
        // $("#"+id_disp_title).html("disp test");
    }
}

function get_ten_sorted_post_by_no_callback(data,status)
{
    //get each post info
    console.log("response data:\n"+data+"\n");
    var info_json=JSON.parse(data);
    var post_title=info_json.post_title;
    var post_content=info_json.post_content;
    var post_block_id=info_json.post_block_id;
    var post_usr_id=info_json.post_usr_id;
    var post_click_num=info_json.post_click_num;
    var post_reply_num=info_json.post_reply_num;
    var post_praise_num=info_json.post_praise_num;
    var post_time=info_json.post_time;
    // var disp_id=info_json.disp_id;
    var post_no=info_json.post_no;

    post_block_id=Number(post_block_id);
    post_usr_id=Number(post_usr_id);

    // $("#disp_title"+String(disp_id)).html("title: "+post_title);
    
    // disp_info_selector="#"+"disp_info"+String(disp_id);

    append_str="<p>"+"title: "+post_title+"\n"+"content: "+post_content+"</p>";
    append_str+="<p>";
    append_str+="post_no:"+String(post_no)+",";
    append_str+="post_block_id:"+String(post_block_id)+",";
    append_str+="post_usr_id:"+String(post_usr_id)+",";
    append_str+="</p><p>";
    append_str+="post_click_num:"+String(post_click_num)+",";
    append_str+="post_praise_num:"+String(post_praise_num)+",";
    append_str+="post_reply_num:"+String(post_reply_num)+",";
    append_str+="post_time:"+String(post_time)+",";
    append_str+="</p><br/>";
    $("#ten_sorted_post").append(append_str);
    $("#ten_sorted_post").attr({"post_no":post_no,"post_block_id":post_block_id,"post_usr_id":post_usr_id});


}
