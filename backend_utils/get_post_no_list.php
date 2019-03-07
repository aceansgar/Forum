<?php

//get list of post_no by sort method
require "conn_db.php";
$conn=conn_mysql();

$disp_num=$_POST['disp_num'];
$rank_method=$_POST['rank_method'];
// echo $disp_num;
// echo $rank_method;
$disp_num=(int)$disp_num;

if($rank_method=="latest")
{
    //echo xml string of post_no latest
    $doc=new DOMDocument('1.0','utf-8');
    $root=$doc->createElement("get_post_no_list_response");
    $doc->appendChild($root);
    $sql="CREATE TABLE TMP_TIME_TABLE
    SELECT post_no,post_time FROM POST_INFO
    ";
    $sql_ret=mysqli_query($conn,$sql);
    // if($sql_ret)
    // {
    //     echo "create table success\n";
    // }
    // else
    // {
    //     // $sql="DROP TABLE TMP_TIME_TABLE";
    //     // $sql_ret=mysqli_query($conn,$sql);
    //     echo die("create table fail\n".mysqli_error($conn)."\n");
        
    // }


    
    for($i=0;$i<$disp_num;$i++)
    {
        //get latest $disp_num 
        
        $sql="SELECT A.post_no AS post_no_latest FROM TMP_TIME_TABLE A
        WHERE NOT EXISTS
        (SELECT * FROM TMP_TIME_TABLE B WHERE A.post_time<B.post_time)
        ";
        $sql_ret=mysqli_query($conn,$sql);
        // if($sql_ret)
        // {
        //     echo "select success\n";
        // }
        // else
        // {
        //     $sql="DROP TABLE TMP_TIME_TABLE";
        //     $sql_ret=mysqli_query($conn,$sql);
        //     echo die("select fail\n".mysqli_error($conn)."\n");
           
        // }

        while($row=mysqli_fetch_assoc($sql_ret))
        {
            $post_no_latest=$row['post_no_latest'];
        }
        $post_no_latest=(int)$post_no_latest;
        $node_tmp_post_no=$doc->createElement("post_no",$post_no_latest);
        $root->appendChild($node_tmp_post_no);
        //delete this entry from temporary table
        $sql="DELETE FROM TMP_TIME_TABLE
        WHERE post_no=$post_no_latest";
        $sql_ret=mysqli_query($conn,$sql);
    }
    //delete TMP_TIME_TABLE
    $sql="DROP TABLE TMP_TIME_TABLE";
    $sql_ret=mysqli_query($conn,$sql);

    //echo xml string of latest post_no
    echo $doc->saveXML();


}
elseif($rank_method=="click_num")
{
    //sorted by click_num
    //echo xml string of post_no 
    $doc=new DOMDocument('1.0','utf-8');
    $root=$doc->createElement("get_post_no_list_response");
    $doc->appendChild($root);
    $sql="CREATE TABLE TMP_TIME_TABLE
    SELECT post_no,post_click_num FROM POST_INFO
    ";
    $sql_ret=mysqli_query($conn,$sql);
    // if($sql_ret)
    // {
    //     echo "create table success\n";
    // }
    // else
    // {
    //     // $sql="DROP TABLE TMP_TIME_TABLE";
    //     // $sql_ret=mysqli_query($conn,$sql);
    //     echo die("create table fail\n".mysqli_error($conn)."\n");
        
    // }

    for($i=0;$i<$disp_num;$i++)
    {
        //get  $disp_num of most click_num
        
        $sql="SELECT A.post_no AS post_no_most_click FROM TMP_TIME_TABLE A
        WHERE NOT EXISTS
        (SELECT * FROM TMP_TIME_TABLE B WHERE A.post_click_num<B.post_click_num)
        ";
        $sql_ret=mysqli_query($conn,$sql);
        // if($sql_ret)
        // {
        //     echo "select success\n";
        // }
        // else
        // {
        //     $sql="DROP TABLE TMP_TIME_TABLE";
        //     $sql_ret=mysqli_query($conn,$sql);
        //     echo die("select fail\n".mysqli_error($conn)."\n");
           
        // }

        while($row=mysqli_fetch_assoc($sql_ret))
        {
            $post_no_most_click=$row['post_no_most_click'];
        }
        $post_no_most_click=(int)$post_no_most_click;
        $node_tmp_post_no=$doc->createElement("post_no",$post_no_most_click);
        $root->appendChild($node_tmp_post_no);
        //delete this entry from temporary table
        $sql="DELETE FROM TMP_TIME_TABLE
        WHERE post_no=$post_no_most_click";
        $sql_ret=mysqli_query($conn,$sql);
    }
    //delete TMP_TIME_TABLE
    $sql="DROP TABLE TMP_TIME_TABLE";
    $sql_ret=mysqli_query($conn,$sql);

    //echo xml string of latest post_no
    echo $doc->saveXML();

}
elseif($rank_method=="reply_num")
{
    //sorted by reply_num
    //echo xml string of post_no 
    $doc=new DOMDocument('1.0','utf-8');
    $root=$doc->createElement("get_post_no_list_response");
    $doc->appendChild($root);
    $sql="CREATE TABLE TMP_TIME_TABLE
    SELECT post_no,post_reply_num FROM POST_INFO
    ";
    $sql_ret=mysqli_query($conn,$sql);
    // if($sql_ret)
    // {
    //     echo "create table success\n";
    // }
    // else
    // {
    //     // $sql="DROP TABLE TMP_TIME_TABLE";
    //     // $sql_ret=mysqli_query($conn,$sql);
    //     echo die("create table fail\n".mysqli_error($conn)."\n");
        
    // }

    for($i=0;$i<$disp_num;$i++)
    {
        //get  $disp_num of most click_num
        
        $sql="SELECT A.post_no AS post_no_most_reply FROM TMP_TIME_TABLE A
        WHERE NOT EXISTS
        (SELECT * FROM TMP_TIME_TABLE B WHERE A.post_reply_num<B.post_reply_num)
        ";
        $sql_ret=mysqli_query($conn,$sql);
        // if($sql_ret)
        // {
        //     echo "select success\n";
        // }
        // else
        // {
        //     $sql="DROP TABLE TMP_TIME_TABLE";
        //     $sql_ret=mysqli_query($conn,$sql);
        //     echo die("select fail\n".mysqli_error($conn)."\n");
           
        // }

        while($row=mysqli_fetch_assoc($sql_ret))
        {
            $post_no_most_reply=$row['post_no_most_reply'];
        }
        $post_no_most_reply=(int)$post_no_most_reply;
        $node_tmp_post_no=$doc->createElement("post_no",$post_no_most_reply);
        $root->appendChild($node_tmp_post_no);
        //delete this entry from temporary table
        $sql="DELETE FROM TMP_TIME_TABLE
        WHERE post_no=$post_no_most_reply";
        $sql_ret=mysqli_query($conn,$sql);
    }
    //delete TMP_TIME_TABLE
    $sql="DROP TABLE TMP_TIME_TABLE";
    $sql_ret=mysqli_query($conn,$sql);

    //echo xml string of latest post_no
    echo $doc->saveXML();
}





?>