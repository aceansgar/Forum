//option on posts 
//click, praise

$(document).ready(ready_op_on_disp);
var disp_num=3;

function ready_op_on_disp()
{
    ready_click_disp();
    ready_praise_disp();
}

function ready_click_disp()
{
    for (var i=0;i<disp_num;i++)
    {
        var tmp_button_selector_str="#disp_click"+String(i);
        $(tmp_button_selector_str).click(onclick_disp_click);
    }
}

function onclick_disp_click()
{
    //click on which post_no
    var tmp_disp_div_ele=$(this).parent().parent().parent();
    var disp_info_ele=tmp_disp_div_ele.children(".info");
    var click_original_post_no=disp_info_ele.attr('post_no');
    var POST_para={click_original_post_no:click_original_post_no,op_type:"click"};
    $.post("backend_utils/op_on_post.php",POST_para,op_on_post_callback);

}

function ready_praise_disp()
{
    for (var i=0;i<disp_num;i++)
    {
        var tmp_button_selector_str="#disp_praise"+String(i);
        $(tmp_button_selector_str).click(onclick_disp_praise);
    }
}

function onclick_disp_praise()
{
    //praise on which post_no
    var tmp_disp_div_ele=$(this).parent().parent().parent();
    var disp_info_ele=tmp_disp_div_ele.children(".info");
    var praise_original_post_no=disp_info_ele.attr('post_no');
    var POST_para={praise_original_post_no:praise_original_post_no,op_type:"praise"};
    $.post("backend_utils/op_on_post.php",POST_para,op_on_post_callback);
}

function op_on_post_callback(data,status)
{
    console.log("op_on_post_callback: \n");
    console.log(data+"\n");
}