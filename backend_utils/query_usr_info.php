<?php
require "conn_db.php";
$conn=conn_mysql();

$usr_id=$_POST['usr_id'];
$usr_id=(int)$usr_id;

$doc=new DOMDocument('1.0','utf-8');
$node_usr=$doc->createElement("usr");
$doc->appendChild($node_usr);

$sql="SELECT usr_name,usr_gender,usr_birthday,usr_level FROM USR_INFO
WHERE usr_id=$usr_id
";
$sql_ret=mysqli_query($conn,$sql);
while($row=mysqli_fetch_assoc($sql_ret))
{
    $usr_name=$row['usr_name'];
    $usr_gender=$row['usr_gender'];
    $usr_birthday=$row['usr_birthday'];
    $usr_level=$row['usr_level'];
}
$node_usr_name=$doc->createElement("usr_name",$usr_name);
$node_usr->appendChild($node_usr_name);
$node_info=$doc->createElement("info");
$node_usr->appendChild($node_info);
$node_basic_info=$doc->createElement("basic_info");
$node_other_info=$doc->createElement("other_info");
$node_info->appendChild($node_basic_info);
$node_info->appendChild($node_other_info);

$node_gender=$doc->createElement("gender",$usr_gender);
$node_birthday=$doc->createElement("birthday",$usr_birthday);
$node_level=$doc->createElement("level",$usr_level);
$node_basic_info->appendChild($node_gender);
$node_basic_info->appendChild($node_birthday);
$node_basic_info->appendChild($node_level);

//node_other_info
$node_posts=$doc->createElement("posts");
$node_replies=$doc->createElement("replies");
$node_other_info->appendChild($node_posts);
$node_other_info->appendChild($node_replies);

// $sql="SELECT A.post_no,A.post_block_id,A.post_usr_id,B.post_title,B.post_content,
// A.post_click_num,A.post_reply_num
// FROM 
// ";
$doc->save("./usr".(string)$usr_id.".xml");












?>