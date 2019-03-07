<?php
require "conn_db.php";
$conn=conn_mysql();

$reply_original_post_no=$_POST['reply_original_post_no'];
$reply_usr_id=$_POST['reply_usr_id'];
$reply_content=$_POST['reply_content'];

$reply_original_post_no=(int)$reply_original_post_no;
$reply_usr_id=(int)$reply_usr_id;

// echo "reply_content:".$reply_content."\n";
// echo "reply_usr_id:".$reply_usr_id."\n";
// echo "reply_original_post_no:".$reply_original_post_no."\n";

//REPLY reply_id,reply_original_post_no,reply_floor,reply_usr_id,reply_content,reply_time,reply_praise_num

//if no entry in REPLY, reply_id=0
$sql="SELECT * FROM REPLY";
$sql_ret=mysqli_query($conn,$sql);
$tot_entry_cnt=mysqli_num_rows($sql_ret);
if($tot_entry_cnt==0)
{
    $reply_id=0;
}
else
{
    //tot entry cnt not 0, find max reply_id
    $sql="SELECT max(reply_id) AS max_reply_id
    FROM REPLY
    ";
    $sql_ret=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($sql_ret))
    {
        $max_reply_id=$row['max_reply_id'];
    }
    $reply_id=$max_reply_id+1;
}
echo "reply_id:".$reply_id."\n";
//reply_id get

//calc reply_floor
//if this reply_original_post_no do not have reply ,reply_floor=0
$sql="SELECT * FROM REPLY
WHERE reply_original_post_no=$reply_original_post_no
";
$sql_ret==mysqli_query($conn,$sql);
$floor_cnt=mysqli_num_rows($sql_ret);
echo "floor_cnt:".$floor_cnt."\n";
if($floor_cnt==0)
{
    $reply_floor=0;
}
else
{
    //exist floor, find max reply_floor
    $sql="SELECT max(reply_floor) AS max_reply_floor
    FROM REPLY
    WHERE reply_original_post_no=$reply_original_post_no
    ";
    $sql_ret=mysqli_query($conn,$sql);
    if($sql_ret)
    {
        echo "select max success\n";
    }
    else
    {
        echo "select max fail\n";
        die(mysqli_err($conn)."\n");
    }
    while($row=mysqli_fetch_assoc($sql_ret))
    {
        echo "var_dump row:\n";
        var_dump($row);
        echo "\n";
        $max_reply_floor=$row['max_reply_floor'];
        echo "var_dump max_reply_floor:\n";
        var_dump($max_reply_floor);
        echo "\n";
    }
    $reply_floor=$max_reply_floor+1;
}
echo "reply_floor: ".$reply_floor."\n";
//reply_floor get

$reply_praise_num=0;
$reply_time=time();
$reply_time=date('Y-m-d H:i:s',$reply_time);

//REPLY reply_id,reply_original_post_no,reply_floor,reply_usr_id,reply_content,reply_time,reply_praise_num
$sql="INSERT INTO REPLY
(reply_id,reply_original_post_no,reply_floor,reply_usr_id,reply_content,reply_time,reply_praise_num)
VALUES
($reply_id,$reply_original_post_no,$reply_floor,$reply_usr_id,'{$reply_content}','{$reply_time}',$reply_praise_num)
";
$sql_ret=mysqli_query($conn,$sql);
if($sql_ret)
{
    echo "insert into REPLY success\n";
}
else
{
    die("insert into REPLY fail\n".mysqli_err($conn)."\n");
}

//update post_reply_num in POST_INFO
$sql="UPDATE POST_INFO
SET post_reply_num=post_reply_num+1
WHERE post_no=$reply_original_post_no
";
$sql_ret=mysqli_query($conn,$sql);
if($sql_ret)
{
    echo "update of post reply_num in POST_INFO success \n";
}
else
{
    die("update of post reply_num in POST_INFO fail\n".mysqli_err($conn)."\n");
}

?>