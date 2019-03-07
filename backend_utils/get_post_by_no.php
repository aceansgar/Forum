<?php
require "conn_db.php";
$conn=conn_mysql();
$post_no=$_POST['post_no'];
$disp_id=$_POST['disp_id'];
$post_no=(int)$post_no;

//POST_CONT post_no,post_title,post_content
$sql="SELECT * FROM POST_CONT
WHERE post_no=$post_no
";
$sql_ret=mysqli_query($conn,$sql);
while($row=mysqli_fetch_assoc($sql_ret))
{
    $post_title=$row['post_title'];
    $post_content=$row['post_content'];
}

//POST_INFO post_no,post_block_id,post_usr_id,post_click_num,post_reply_num,post_praise_num,post_time
$sql="SELECT * FROM POST_INFO
WHERE post_no=$post_no
";
$sql_ret=mysqli_query($conn,$sql);
while($row=mysqli_fetch_assoc($sql_ret))
{
    $post_block_id=$row['post_block_id'];
    $post_usr_id=$row['post_usr_id'];
    $post_click_num=$row['post_click_num'];
    $post_reply_num=$row['post_reply_num'];
    $post_praise_num=$row['post_praise_num'];
    $post_time=$row['post_time'];
}

$echo_arr=array();
$echo_arr['post_title']=$post_title;
$echo_arr['post_content']=$post_content;
$echo_arr['post_block_id']=$post_block_id;
$echo_arr['post_usr_id']=$post_usr_id;
$echo_arr['post_click_num']=$post_click_num;
$echo_arr['post_reply_num']=$post_reply_num;
$echo_arr['post_praise_num']=$post_praise_num;
$echo_arr['post_time']=$post_time;
$echo_arr['disp_id']=$disp_id;
$echo_arr['post_no']=$post_no;
$echo_json=json_encode($echo_arr);
echo $echo_json;




?>