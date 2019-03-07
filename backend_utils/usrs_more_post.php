<?php
require "conn_db.php";
$conn=conn_mysql();
$block_id_a=$_POST['block_id_a'];
$block_id_a=(int)$block_id_a;
$block_id_b=$_POST['block_id_b'];
$block_id_b=(int)$block_id_b;

$sql="CREATE TEMPORARY TABLE USR_POSTNUM_A
(
    SELECT post_usr_id as usr_id, COUNT(*) as post_num_a
    FROM POST_INFO
    WHERE post_block_id=$block_id_a
    GROUP BY post_usr_id
)
";
$sql_ret=mysqli_query($conn,$sql);
// if($sql_ret)
//     {
//         echo "create USR_POSTNUM_A success\n";
//     }
//     else
//     {
//         echo "create USR_POSTNUM_A fail\n";
//         die(mysqli_error($conn)+"\n");
//     }

$sql="CREATE TEMPORARY TABLE USR_POSTNUM_B
(
    SELECT post_usr_id as usr_id,COUNT(*) as post_num_b
    FROM POST_INFO
    WHERE post_block_id=$block_id_b
    GROUP BY post_usr_id
)
";
$sql_ret=mysqli_query($conn,$sql);

$sql="SELECT A.usr_id AS usr_id
FROM USR_POSTNUM_A A,USR_POSTNUM_B B
WHERE A.usr_id=B.usr_id AND A.post_num_a>B.post_num_b
";
$sql_ret=mysqli_query($conn,$sql);
// if($sql_ret)
// {
//     echo "select answer usr_id success\n";
// }
// else
// {
//     echo "select answer usr_id fail\n";
//     die(mysqli_error($conn)+"\n");
// }
//usr_id get

$doc=new DOMDocument('1.0','utf-8');
$root=$doc->createElement("root");
$doc->appendChild($root);
while($row=mysqli_fetch_assoc($sql_ret))
{
    $usr_id=$row['usr_id'];
    $node_usr=$doc->createElement("usr_id",$usr_id);
    $root->appendChild($node_usr);
}
echo $doc->saveXML();

?>