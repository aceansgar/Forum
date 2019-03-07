<?php
require "conn_db.php";
$conn=conn_mysql();
$delete_usr_id=(int)$_POST['delete_usr_id'];
$my_usr_id=(int)$_POST['my_usr_id'];


$sql="SELECT COUNT(*) FROM FORUM_ADMIN
WHERE usr_id=$my_usr_id
";
$sql_ret=mysqli_query($conn,$sql);
$ret_row_cnt=mysqli_num_rows($sql_ret);
$if_admin=$ret_row_cnt;
if($if_admin==0)
{
    die("you are not administrator, cannot delete usr\n");
}
else
{
    //can delete
    

    $sql="DELETE FROM REPLY A
    WHERE EXISTS(SELECT * FROM POST_INFO B
    WHERE B.post_usr_id=$delete_usr_id AND B.post_no=A.reply_original_post_no)
    ";
    $sql_ret=mysqli_query($conn,$sql);

    $sql="DELETE FROM POST_CONT A 
    WHERE EXISTS(SELECT * FROM POST_INFO B
    WHERE B.post_usr_id=$delete_usr_id AND B.post_no=A.post_no);
    ";
    $sql_ret=mysqli_query($conn,$sql);

    $sql="DELETE FROM POST_INFO
    WHERE post_usr_id=$delete_usr_id
    ";
    $sql_ret=mysqli_query($conn,$sql);

    $sql="DELETE FROM USR_INFO 
    WHERE usr_id=$delete_usr_id 
    ";
    $sql_ret=mysqli_query($conn,$sql);

    $sql="DELETE FROM USR_PASSWORD
    WHERE usr_id=$delete_usr_id
    ";
    $sql_ret=mysqli_query($conn,$sql);

    if($sql_ret)
    {
        echo "delete usr success\n";
    }
    else
    {
        echo "delete usr fail\n";
        die(mysqli_error($conn)."\n");
    }






}



?>