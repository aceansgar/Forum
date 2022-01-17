<?php
require "conn_db.php";

//POST OR GET
$register_name=$_POST["register_name"];
$register_password=$_POST["register_password"];
$register_gender=$_POST["register_gender"];
$register_birthday=$_POST["register_birthday"];


$conn=conn_mysql();



echo "register_name: ".$register_name."\n";
echo "register_password: ".$register_password."\n";
echo "register_gender:".$register_gender."\n";
echo "register_birthday:".$register_birthday."\n";

function register_insert_db()
{

    //local variable form global variable
    $register_name=$GLOBALS['register_name'];
    $register_password=$GLOBALS["register_password"];
    $register_gender=$GLOBALS["register_gender"];
    $register_birthday=$GLOBALS["register_birthday"];

    $usr_id=0;
    $conn=conn_mysql();
    
    //usr_name is unique
    $sql_find_dup="SELECT ALL * from USR_PASSWORD
    WHERE usr_name='{$register_name}'
    ";
    $find_dup_ret=mysqli_query($conn,$sql_find_dup);
    // $dup_cnt=mysqli_num_rows($find_dup_ret);
    // echo "dup_cnt: ".$dup_cnt."\n";
    if($find_dup_ret)
    {
        die("register fail: name duplication\n");
    }


    //to set usr_id
    $sql="SELECT DISTINCT usr_id
    FROM USR_PASSWORD
    ";
    
    $usr_id_entry_ret=mysqli_query($conn,$sql);
    if(!$usr_id_entry_ret)
    {
        //query failed
        die("select usr_id query failed\n").mysqli_error();
    }
    else
    {
        //query success

        $usr_cnt=mysqli_num_rows($usr_id_entry_ret);
        echo "usr_cnt: ".$usr_cnt."\n";
        // while($row=mysqli_fetch_assoc($count_ret))
        // {
        //     echo "<tr><td>{$row["user_id"]}</td></tr>";
        // }
        if($usr_cnt==0) 
        {
            //no user
            $usr_id=0;
        }
        else
        {
            //chooose the largest user_id
            $sql="SELECT max(usr_id) AS max_id
            FROM USR_PASSWORD
            ";
            
            $max_id_entry=mysqli_query($conn,$sql);
            // var_dump($max_id_entry);
            while($row=mysqli_fetch_assoc($max_id_entry))
            {
                echo "each row of max_id_entry: \n";
                // var_dump($row);
                $usr_id=$row["max_id"]+1;
                echo "max_id: ".$row["max_id"]."\n";
            }
        }
    }

    if($register_gender=="male")
    {
        $register_gender=0;
    }
    elseif($register_gender=="female")
    {
        $register_gender=1;
    }
    else
    {
        die("invalid gender\n");
    }

    
    echo("usr_id :".(string)$usr_id."\n");

    //insert into USR_PASSWORD
    $sql_insert="INSERT INTO USR_PASSWORD
    (usr_id,usr_name,usr_pw)
    VALUES ($usr_id,'{$register_name}','{$register_password}')
    ";

    $insert_USR_PASSWORD_ret=mysqli_query($conn,$sql_insert);

    if(!$insert_USR_PASSWORD_ret)
    {
        die("insert USR_PASSWORD fail\n"."error: ".mysqli_error($conn));
    }
    else
    {
        echo "insert USR_PASSWORD success\n";
    }


    //insert into USR_INFO
    $sql_insert="INSERT INTO USR_INFO
    (usr_id,usr_name,usr_gender,usr_birthday,usr_level)
    VALUES
    ($usr_id,'{$register_name}',$register_gender,'{$register_birthday}',0)
    ";

    // echo "sql_insert of USR_INFO: \n".$sql_insert."\n";

    $insert_USR_INFO_ret=mysqli_query($conn,$sql_insert);
    if(!$insert_USR_INFO_ret)
    {
        die("insert USR_INFO fail\n"."error: ".mysqli_error($conn));
    }
    else
    {
        echo "insert USR_INFO success\n";
    }



}

register_insert_db();



?>