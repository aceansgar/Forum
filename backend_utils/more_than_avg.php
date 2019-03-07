<?php
require "conn_db.php";
$conn=conn_mysql();
//get hottest post

$block_id=$_POST['block_id'];
$block_id=(int)$block_id;

//click>avg click find post_no
$sql="SELECT post_no FROM POST_INFO
where post_block_id=$block_id AND
post_click_num>(
    SELECT AVG(A.post_click_num)
    FROM POST_INFO A
    WHERE A.post_block_id=$block_id
)
";
$sql_ret=mysqli_query($conn,$sql);

$doc=new DOMDocument('1.0','utf-8');
$root=$doc->createElement("root");
$doc->appendChild($root);
$post_list=$doc->createElement("post_list");
$root->appendChild($post_list);
$usr_list=$doc->createElement("usr_list");
$root->appendChild($usr_list);

while($row=mysqli_fetch_assoc($sql_ret))
{
    $post_no=$row['post_no'];
    $node_post_no=$doc->createElement("post_no",$post_no);
    $post_list->appendChild($node_post_no);
}

//in this block , find users reply_num>avg( )

$sql="CREATE TEMPORARY TABLE USR_REPLYNUM
(
    SELECT post_usr_id AS usr_id, COUNT(post_reply_num) AS reply_num
    FROM POST_INFO
    WHERE post_block_id=$block_id
    GROUP BY post_usr_id 
)
";
$sql_ret=mysqli_query($conn,$sql);

$sql="CREATE TEMPORARY TABLE USR_REPLYNUM_B (SELECT * FROM USR_REPLYNUM)";
$sql_ret=mysqli_query($conn,$sql);

$sql="SELECT usr_id FROM USR_REPLYNUM
WHERE reply_num>(SELECT AVG(reply_num) FROM USR_REPLYNUM_B)
";
$sql_ret=mysqli_query($conn,$sql);

while($row=mysqli_fetch_assoc($sql_ret))
{
    $usr_id=$row['usr_id'];
    $node_usr_id=$doc->createElement("usr_id",$usr_id);
    $usr_list->appendChild($node_usr_id);
}


echo $doc->saveXML();




?>