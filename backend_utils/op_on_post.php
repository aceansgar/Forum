<?php
require "conn_db.php";
$conn=conn_mysql();

$op_type=$_POST['op_type'];

if($op_type=="click")
{
    $click_original_post_no=$_POST['click_original_post_no'];
    $click_original_post_no=(int)$click_original_post_no;
    $sql="UPDATE POST_INFO
    SET post_click_num=post_click_num+1
    where post_no=$click_original_post_no
    ";
    $sql_ret=mysqli_query($conn,$sql);
    if($sql_ret)
    {
        echo "update post_click_num in POST_INFO success\n";
    }
    else
    {
        die("update post_click_num in POST_INFO fail\n".mysqli_err($conn)."\n");
    }
}
elseif($op_type=="praise")
{
    $praise_original_post_no=$_POST['praise_original_post_no'];
    $praise_original_post_no=(int)$praise_original_post_no;
    $sql="UPDATE POST_INFO
    SET post_praise_num=post_praise_num+1
    where post_no=$praise_original_post_no
    ";
    $sql_ret=mysqli_query($conn,$sql);
    if($sql_ret)
    {
        echo "update post_praise_num in POST_INFO success\n";
    }
    else
    {
        die("update post_praise_num in POST_INFO fail\n".mysqli_err($conn)."\n");
    }
}


?>