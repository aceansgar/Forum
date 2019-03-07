<?php
require "conn_db.php";
$conn=conn_mysql();
function set_quote($conn)
{
    $sql_set_quote="SET SESSION SQL_MODE=ANSI_QUOTES";
    $query_ret=mysqli_query($conn,$sql_set_quote);
    return $query_ret;
}

function create_table_USR_INFO($conn)
{
    //level 0:ordinary 1:forum moderator 2:administrator
    $sql_create_table="create table USR_INFO
    (
        usr_id INT(11) NOT NULL,
        usr_name VARCHAR(30) NOT NULL,
        usr_gender INT(11) NOT NULL,
        usr_birthday DATE NOT NULL,
        usr_level INT(11) NOT NULL,
        primary key(usr_id)

    )
        ";
    $query_ret=mysqli_query($conn,$sql_create_table);
    return $query_ret;
    
}

function create_table_USR_PASSWORD($conn)
{
    $sql_create_table="create table USR_PASSWORD
    (
        usr_id INT(11) NOT NULL,
        usr_name VARCHAR(30) NOT NULL,
        usr_pw VARCHAR(50) NOT NULL,
        primary key(usr_id)
    )
    ";
    $query_ret=mysqli_query($conn,$sql_create_table);
    return $query_ret;
}

function create_table_POST_CONT($conn)
{
    $sql_create_table="create table POST_CONT
    (
        post_no INT(11) NOT NULL,
        post_title TEXT NOT NULL,
        post_content TEXT NOT NULL,
        primary key(post_no)
    )
    ";
    $query_ret=mysqli_query($conn,$sql_create_table);
    return $query_ret;
}

function create_table_POST_INFO($conn)
{
    $sql_create_table="create table POST_INFO
    (
        post_no INT(11) NOT NULL,
        post_block_id INT(11) NOT NULL,
        post_usr_id INT(11) NOT NULL,
        post_click_num INT(11) NOT NULL,
        post_reply_num INT(11) NOT NULL,
        post_time TIMESTAMP NOT NULL,
        post_praise_num INT(11) NOT NULL,
        primary key(post_no)
    )
    ";
    $query_ret=mysqli_query($conn,$sql_create_table);
    return $query_ret;
}

function create_table_REPLY($conn)
{
    $sql_create_table="create table REPLY
    (
        reply_id INT(11) NOT NULL,
        reply_original_post_no INT(11) NOT NULL,
        reply_floor INT(11) NOT NULL,
        reply_usr_id INT(11) NOT NULL,
        reply_content TEXT NOT NULL,
        reply_time TIMESTAMP NOT NULL,
        reply_praise_num INT(11) NOT NULL,
        primary key(reply_id)
    )
    ";
    $query_ret=mysqli_query($conn,$sql_create_table);
    return $query_ret;
}

function create_table_PRIVILEDGE($conn)
{
    $sql_create_table="create table PRIVILEDGE
    (
        priviledge_entry_id INT(11) NOT NULL,
        priviledge_usr_id INT(11) NOT NULL,
        priviledge_block_id INT(11) NOT NULL,
        primary key(priviledge_entry_id)
    )
    ";
    $query_ret=mysqli_query($conn,$sql_create_table);
    return $query_ret;
}

function create_table_UNUSUAL_USR($conn)
{
    $sql_create_table="create table UNUSUAL_USR
    (
        usr_id INT(11),
        unusual_time TIMESTAMP
       
    )
    ";
    $query_ret=mysqli_query($conn,$sql_create_table);
    return $query_ret;
}

function create_table_FORUM_ADMIN($conn)
{
    $sql="CREATE TABLE FORUM_ADMIN
    (
        usr_id INT(11),
        if_admin INT(11),
        primary key(usr_id)
    )
    ";
    $query_ret=mysqli_query($conn,$sql);
    return $query_ret;
}


function create_trigger_UNUSUAL_TRIGGER($conn)
{
    
    
    
    $sql_create_trigger="CREATE TRIGGER UNUSUAL_TRIGGER after insert 
    on POST_INFO for each row 
   BEGIN 
       declare count_post INT;
       SELECT COUNT(*) into count_post FROM POST_INFO B 
   WHERE  B.post_usr_id=new.post_usr_id 
       AND timestampdiff(hour,B.post_time,new.post_time)<10;
       IF (count_post>10) 
       THEN 
       insert into UNUSUAL_USR(usr_id,unusual_time) VALUES(new.post_usr_id,new.post_time);
       end if;
   end
    ";
    $query_ret=mysqli_query($conn,$sql_create_trigger);
    return $query_ret;

}





//POST or GET
$table_name=$_POST['table_name'];

// echo "table_name: ".$table_name."\n";
// echo "conn: ".$conn;


if($table_name=='USR_INFO')
{
    $retval=create_table_USR_INFO($conn);
}
elseif($table_name=='USR_PASSWORD')
{
    $retval=create_table_USR_PASSWORD($conn);
}
elseif($table_name=='POST_CONT')
{
    $retval=create_table_POST_CONT($conn);
}
elseif($table_name=='POST_INFO')
{
    $retval=create_table_POST_INFO($conn);
}
elseif($table_name=='REPLY')
{
    $retval=create_table_REPLY($conn);
}
elseif($table_name=="PRIVILEDGE")
{
    $retval=create_table_PRIVILEDGE($conn);
}
elseif($table_name=="FORUM_ADMIN")
{
    $retval=create_table_FORUM_ADMIN($conn);
}
elseif($table_name=="set_quote")
{
    $retval=set_quote($conn);
}
elseif($table_name=="UNUSUAL_USR")
{
    $retval=create_table_UNUSUAL_USR($conn);
}
elseif($table_name=="UNUSUAL_TRIGGER")
{
    $retval=create_trigger_UNUSUAL_TRIGGER($conn);
    // if($ret_val)
    // {
    //     echo "create trigger success\n";
    // }
    // else
    // {
    //     echo "create trigger fail\n";
    //     die(mysqli_err($conn)."\n");
    // }
}
else
{
    die("table_name no match\ntable_name: ".$table_name);
}

if(!$retval)
{
    die('creation fails\n'.mysqli_error($conn));
}
else
{
    echo $table_name." creation success\n";
}







?>