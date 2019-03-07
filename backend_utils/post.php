<?php
require "conn_db.php";
//insert into POST_INFO, POST_CONT

$usr_id=$_POST['usr_id'];
$post_title=$_POST['post_title'];
$post_content=$_POST['post_content'];
$block_id=$_POST['block_id'];
$block_id=(int)$block_id;
$usr_id=(int)$usr_id;

$conn=conn_mysql();
$echo_text='';

function die_echo()
{
    $echo_text=$GLOBALS['echo_text'];
    $conn=$GLOBALS['conn'];
    $echo_text="die \n".$echo_text.mysqli_error($conn)."\n";
    die($echo_text);
}



//calc post_no

//if there exists entry in POST_INFO, post_no=0

$sql="SELECT * 
FROM POST_CONT
";
$sql_ret=mysqli_query($conn,$sql);
$info_entry_cnt=mysqli_num_rows($sql_ret);
if($info_entry_cnt==0)
{
    //no entry exists
    $post_no=0;
}
else
{
    //find max post_no
    $sql="SELECT max(post_no) AS max_post_no
    FROM POST_CONT
    ";
    $sql_ret=mysqli_query($conn,$sql);
    // echo 'var_dump sql_ret:\n';
    // var_dump($sql_ret);
    // echo "\n";
    $ret_row_cnt=mysqli_num_rows($sql_ret);
    // echo "row cnt:\n";
    // echo $ret_row_cnt."\n";

    while($row=mysqli_fetch_assoc($sql_ret))
    {
        // echo "var_dump this row:\n";
        // var_dump($row);
        // echo "\n";
        $max_post_no=$row['max_post_no'];

        // echo "max_post_no:".$max_post_no."\n";
        $echo_text=$echo_text."max_post_no:".(string)$max_post_no."\n";
    }
    $post_no=(int)$max_post_no+1;

}
// post_no get
$echo_text=$echo_text."post_no:".(string)$post_no."\n";
echo "post_no: ".$post_no."\n";

//insert into POST_CONT
$sql="INSERT INTO POST_CONT
(post_no,post_title,post_content)
VALUES($post_no,'{$post_title}','{$post_content}')
";
$sql_ret=mysqli_query($conn,$sql);
if($sql_ret)
{
    echo "insert into POST_CONT success\n";
}
else
{
    echo "insert into POST_CONT fail\n";
    die(mysqli_error($conn));
}
//insert into POST_CONT end

//insert into POST_INFO
//post_no,post_block_id,post_usr_id,post_click_num,post_reply_num,post_time,post_praise_num

$post_block_id=$block_id;
$post_usr_id=$usr_id;
$post_click_num=0;
$post_reply_num=0;
$post_time=time();
$post_time=date('Y-m-d H:i:s',$post_time);
$post_praise_num=0;

$sql="INSERT INTO POST_INFO
(post_no,post_block_id,post_usr_id,post_click_num,post_reply_num,post_time,post_praise_num)
VALUES($post_no,$post_block_id,$post_usr_id,$post_click_num,$post_reply_num,'{$post_time}',$post_praise_num)
";
$ret_val=mysqli_query($conn,$sql);
if($ret_val)
{
    echo "insert into POST_INFO success\n";
}
else
{
    echo "sql: ".$sql."\n";
    echo "post_no: ".$post_no."\n";
    echo "insert into POST_INFO fail\n";
    die(mysqli_error($conn));
}
//insert into POST_CONT end





?>