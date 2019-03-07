$(document).ready(create_table_ready_func);

function create_table_onclick_button()
{
    var table_name=$("#table_input").val();
    console.log("onclick:\n");
    console.log("table_name: "+table_name+"\n");
    var post_para={table_name:table_name};
    $.post("../backend_utils/create_db_table.php",post_para,create_table_post_callback);
}

function onclick_set_quote_button()
{
    console.log("onclick_set_quote_button: \n");
    var post_para={table_name:"set_quote"};
    $.post("../backend_utils/create_db_table.php",post_para,create_table_post_callback);
}

function create_table_ready_func()
{
    $("#create_submit").click(create_table_onclick_button);
    $("#set_quote").click(onclick_set_quote_button);
}






function create_table_post_callback(data,status)
{
    console.log("response: \n");
    console.log("data:"+data+"\n");
    console.log("status:"+status+"\n");
}