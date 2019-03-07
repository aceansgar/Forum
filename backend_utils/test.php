<?php

    require "conn_db.php";
    $conn=conn_mysql();

    $user_id=0;
    
    echo "user_id";
    $register_name='testname';
    $name1=1;
    
    $register_password='b';
    $sql_insert="INSERT INTO T_TABLE 
    (idid,abc,abcd)
    VALUES (4,'{$register_name}','bbb')
    ";
    echo "sql: \n";
    echo $sql_insert;

    $insert_USER_PASSWORD_ret=mysqli_query($conn,$sql_insert);

    if(!$insert_USER_PASSWORD_ret)
    {
        die("insert USER_PASSWORD fail\n"."error: ".mysqli_error($conn));
    }
    else
    {
        echo "insert USER_PASSWORD success\n";
    }


?>