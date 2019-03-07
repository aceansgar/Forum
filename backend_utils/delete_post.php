<?php
require "conn_db.php";
$conn=conn_mysql();
$delete_post_no=(int)$_POST['delete_post_no'];
$my_usr_id=(int)$_POST['my_usr_id'];

$if_can_del=0;

$sql="SELECT COUNT(*) FROM FORUM_ADMIN
WHERE usr_id=$my_usr_id
";
$sql_ret=mysqli_query($conn,$sql);
$ret_row_cnt=mysqli_num_rows($sql_ret);
$if_admin=$ret_row_cnt;
if($if_admin)
{
    $if_can_del=1;
}

$sql="SELECT post_block_id AS block_id
FROM POST_INFO
WHERE post_no=$delete_post_no
";
$sql_ret=mysqli_query($conn,$sql);
$ret_row_cnt=mysqli_num_rows($sql_ret);
if($ret_row_cnt==0)
{
    die(" post_no not exist\n ");
}
while($row=mysqli_fetch_assoc($sql_ret))
{
    $delete_block_id=$row['block_id'];
}

$sql="SELECT * FROM PRIVILEDGE
WHERE priviledge_usr_id=$my_usr_id AND priviledge_block_id=$delete_block_id
";
$sql_ret=mysqli_query($conn,$sql);
$ret_row_cnt=mysqli_num_rows($sql_ret);
if($ret_row_cnt)
{
    $if_can_del=1;
}

if($if_can_del==0)
{
    die("not administrator or host of block, cannot delete\n");
}
//can delete

$sql="DELETE FROM REPLY
WHERE reply_original_post_no=$delete_post_no
";
$sql_ret=mysqli_query($conn,$sql);

$sql="DELETE FROM POST_INFO
WHERE post_no=$delete_post_no
";
$sql_ret=mysqli_query($conn,$sql);

$sql="DELETE FROM POST_CONT
WHERE post_no=$delete_post_no
";
$sql_ret=mysqli_query($conn,$sql);

if($sql_ret)
{
    echo "delete post_no success\n";
}




?>