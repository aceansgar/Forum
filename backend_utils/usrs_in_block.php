<?php
require "conn_db.php";
$conn=conn_mysql();
$block_id=$_POST['block_id'];
$block_id=(int)$block_id;
$usrs_rank_method=$_POST['usrs_rank_method'];//post_sum,reply_sum

if($usrs_rank_method=="post_sum")
{
    //temporary table ,in this block,usr_id,usr_post_sum 
    $sql="CREATE TEMPORARY TABLE TEMP_USR_POST
    (SELECT DISTINCT post_usr_id AS usr_id,COUNT(*) AS post_sum  FROM
    POST_INFO WHERE post_block_id=$block_id
    GROUP BY post_usr_id)
    ";
    $sql_ret=mysqli_query($conn,$sql);
    // if($sql_ret)
    // {
    //     echo "create temporary table success\n";
    // }
    // else
    // {
    //     echo "create temporary table success\n";
    //     die(mysqli_error($conn)+"\n");
    // }
    //TEMP_USR_POST usr_id,post_sum
    $sql="SELECT usr_id FROM TEMP_USR_POST
    ORDER BY post_sum DESC
    ";
    $sql_ret=mysqli_query($conn,$sql);
    // if($sql_ret)
    // {
    //     echo "get usr_id list success\n";
    // }
    // else
    // {
    //     echo "get usr_id list fail\n";
    //     die(mysqli_error($conn)+"\n");
    // }
    $usr_id_list_len=mysqli_num_rows($sql_ret);
    $usr_id_list=array();
    while($row=mysqli_fetch_assoc($sql_ret))
    {
        $tmp_usr_id=$row['usr_id'];
        array_push($usr_id_list,$tmp_usr_id);
    }
    $doc=new DOMDocument('1.0','utf-8');
    $root=$doc->createElement("root");
    $doc->appendChild($root);

    for($i=0;$i<$usr_id_list_len;$i++)
    {
        $tmp_usr_id=$usr_id_list[$i];
        //get gender,birthday
        $sql="SELECT usr_gender,usr_birthday FROM USR_INFO
        WHERE usr_id=$tmp_usr_id
        ";
        $sql_ret=mysqli_query($conn,$sql);
        // if($sql_ret)
        // {
        //     echo "get usr info success\n";
        // }
        // else
        // {
        //     echo "get usr info fail\n";
        //     die(mysqli_error($conn)+"\n");
        // }
        while($row=mysqli_fetch_assoc($sql_ret))
        {
            $usr_gender=$row['usr_gender'];
            $usr_birthday=$row['usr_birthday'];
        }
        $usr_info_node=$doc->createElement("usr_info");
        $usr_gender_node=$doc->createElement("usr_gender",$usr_gender);
        $usr_birthday_node=$doc->createElement("usr_birthday",$usr_birthday);
        $root->appendChild($usr_info_node);
        $usr_info_node->appendChild($usr_gender_node);
        $usr_info_node->appendChild($usr_birthday_node);

    }
    //information xmldom get
    echo $doc->saveXML();



    // $sql="SELECT DISTINCT post_usr_id
    // FROM POST_INFO
    // WHERE post_block_id=$block_id
    // ";

}
elseif($usrs_rank_method=="reply_sum")
{
    //temporary table ,in this block,usr_id
    $sql="SELECT DISTINCT post_usr_id AS usr_id, COUNT(post_reply_num) AS reply_sum
    FROM POST_INFO
    WHERE post_block_id=$block_id
    GROUP BY post_usr_id
    ORDER BY reply_sum DESC
    ";
    $sql_ret=mysqli_query($conn,$sql);
    // if($sql_ret)
    // {
    //     echo "temp_usr_replysum success\n";
    // }
    // else
    // {
    //     echo "temp_usr_replysum fail\n";
    //     die(mysqli_error($conn)."\n");
    // }




    $usr_id_list_len=mysqli_num_rows($sql_ret);
    $usr_id_list=array();
    while($row=mysqli_fetch_assoc($sql_ret))
    {
        $tmp_usr_id=$row['usr_id'];
        array_push($usr_id_list,$tmp_usr_id);
    }
    $doc=new DOMDocument('1.0','utf-8');
    $root=$doc->createElement("root");
    $doc->appendChild($root);

    for($i=0;$i<$usr_id_list_len;$i++)
    {
        $tmp_usr_id=$usr_id_list[$i];
        //get gender,birthday
        $sql="SELECT usr_gender,usr_birthday FROM USR_INFO
        WHERE usr_id=$tmp_usr_id
        ";
        $sql_ret=mysqli_query($conn,$sql);
        // if($sql_ret)
        // {
        //     echo "get usr info success\n";
        // }
        // else
        // {
        //     echo "get usr info fail\n";
        //     die(mysqli_error($conn)+"\n");
        // }
        while($row=mysqli_fetch_assoc($sql_ret))
        {
            $usr_gender=$row['usr_gender'];
            $usr_birthday=$row['usr_birthday'];
        }
        $usr_info_node=$doc->createElement("usr_info");
        $usr_gender_node=$doc->createElement("usr_gender",$usr_gender);
        $usr_birthday_node=$doc->createElement("usr_birthday",$usr_birthday);
        $root->appendChild($usr_info_node);
        $usr_info_node->appendChild($usr_gender_node);
        $usr_info_node->appendChild($usr_birthday_node);

    }
    //information xmldom get
    echo $doc->saveXML();



    // $sql="SELECT DISTINCT post_usr_id
    // FROM POST_INFO
    // WHERE post_block_id=$block_id
    // ";

}



?>