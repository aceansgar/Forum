<?php
require "conn_db.php";

$name=$_POST['login_name'];
$password=$_POST['login_password'];
// echo "name: ".$name."\n";
// echo "password: ".$password."\n";

$conn=conn_mysql();
$echo_text="";

//find entry in USR_PASSWORD
$sql="SELECT * FROM USR_PASSWORD
WHERE usr_name='{$name}'
";
$echo_text=$echo_text."sql: \n";
$echo_text=$echo_text.$sql."\n";
$sql_ret=mysqli_query($conn,$sql);
$exist_cnt=mysqli_num_rows($sql_ret);
$echo_text=$echo_text."exist_cnt: ".(string)$exist_cnt."\n";
$login_status=0;
$usr_id=-1;

if($exist_cnt==0)
{
    $login_status=0;
    $echo_text=$echo_text."the user name does not exist\n";
}
elseif($exist_cnt>1)
{
    $login_status=0;
    $echo_text=$echo_text."more than one user\n";
}
else
{
    while($row=mysqli_fetch_assoc($sql_ret))
    {
        $db_password=$row['usr_pw'];
        $usr_id=$row['usr_id'];
    }
    $echo_text=$echo_text."db_password: ".$db_password."\n";
    if($db_password!=$password)
    {
        //password not match
        $echo_text=$echo_text."password not match\n";
        $usr_id=-1;
        $login_status=0;
    }
    else
    {
        //password match
        $login_status=1;
        $echo_text=$echo_text."login success\n";
    }

}



$sql_usr_info="
";


//create xml dom to echo
$doc=new DOMDocument('1.0','utf-8');
$root=$doc->createElement("login_response");
$node_echo_text=$doc->createElement("echo_text",$echo_text);
$node_usr_id=$doc->createElement("usr_id",$usr_id);
$node_login_status=$doc->createElement("login_status",$login_status);
$root->appendChild($node_echo_text);
$root->appendChild($node_usr_id);
$root->appendChild($node_login_status);
$doc->appendChild($root);



// var_dump($doc->saveXML());
// echo "\n\n";

// die($echo_text);

// header("Content-type: text/xml");
echo $doc->saveXML();
// echo $doc;




?>