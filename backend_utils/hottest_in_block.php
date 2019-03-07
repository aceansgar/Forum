<?php
require "conn_db.php";
$conn=conn_mysql();
//get hottest post

$block_id=$_POST['block_id'];
$block_id=(int)$block_id;

$sql="CREATE TEMPORARY TABLE TMP_POST_TIME
(SELECT post_no,post_time
FROM POST_INFO
WHERE post_block_id=$block_id    
)
";
$sql_ret=mysqli_query($conn,$sql);

$sql="CREATE TEMPORARY TABLE TMP_POST_REPLY
(SELECT reply_original_post_no AS post_no, max(reply_time) AS max_reply_time
FROM REPLY
GROUP BY reply_original_post_no
)
";
$sql_ret=mysqli_query($conn,$sql);

// $sql="DROP TABLE IF EXISTES POST_HOT";
// $sql_ret=mysqli_query($conn,$sql);

$sql="CREATE TEMPORARY TABLE TMP_POST_HOT
(SELECT A.post_no AS post_no, B.max_reply_time-A.post_time AS hot
FROM TMP_POST_TIME A, TMP_POST_REPLY B
WHERE A.post_no=B.post_no
)
";
$sql_ret=mysqli_query($conn,$sql);

$sql="CREATE TEMPORARY TABLE TMP_POST_HOT_B (SELECT * FROM TMP_POST_HOT)";
$sql_ret=mysqli_query($conn,$sql);

// if($sql_ret)
// {
//     echo "create TMP_POST_HOT_B success"."\n";
// }
// else
// {
//     echo "create TMP_POST_HOT_B fail"."\n";
//     die(mysqli_error($conn)."\n");
// }

$sql="SELECT post_no FROM TMP_POST_HOT 
WHERE NOT EXISTS
(SELECT * FROM TMP_POST_HOT_B B WHERE hot<B.hot)
";
$sql_ret=mysqli_query($conn,$sql);
// if($sql_ret)
// {
//     echo "select hottest post_no success"."\n";
// }
// else
// {
//     echo "select hottest post_no fail"."\n";
//     die(mysqli_error($conn)."\n");
// }


while($row=mysqli_fetch_assoc($sql_ret))
{
    $hottest_post_no=$row['post_no'];
}
// echo "hottest_post_no:".$hottest_post_no."\n";
//hottest_post_no get
//to list all usr_name who reply this post

$sql="SELECT DISTINCT B.usr_name AS usr_name FROM REPLY A, USR_INFO B
WHERE A.reply_original_post_no=$hottest_post_no
and B.usr_id=A.reply_usr_id
";
$sql_ret=mysqli_query($conn,$sql);

$doc=new DOMDocument('1.0','utf-8');
$root=$doc->createElement("root");
$doc->appendChild($root);
$node_hottest_post=$doc->createElement("hottest_post_no",$hottest_post_no);
$root->appendChild($node_hottest_post);
$node_usr_name_list=$doc->createElement("usr_name_list");
$root->appendChild($node_usr_name_list);
while($row=mysqli_fetch_assoc($sql_ret))
{
    $usr_name=$row['usr_name'];
    $node_usr_name=$doc->createElement("usr_name",$usr_name);
    $node_usr_name_list->appendChild($node_usr_name);   
}
echo $doc->saveXML();


?>