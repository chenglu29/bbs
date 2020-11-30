<?php
function create_connection()
  {
    $link = mysqli_connect("localhost", "root", "root")
      or die("无法建立数据連接: " . mysqli_connect_error());
	  
    mysqli_query($link, "SET NAMES utf8");
			   	
    return $link;
  }
	
  function execute_sql($link, $database, $sql)
  {
    mysqli_select_db($link, $database)
      or die("打开数据库失败: " . mysqli_error($link));
						 
    $result = mysqli_query($link, $sql);
		
    return $result;
  }
	
  $author = $_POST["author"];
  $subject = $_POST["subject"]; 
  $content = $_POST["content"]; 
  $current_time = date("Y-m-d H:i:s");

  //建立資料連接
  $link = create_connection();
			
  //執行 SQL 命令
  $sql = "INSERT INTO message(author, subject, content, date)
          VALUES ('$author', '$subject', '$content', '$current_time')";
  $result = execute_sql($link, "guestbook", $sql);

  //關閉資料連接
  mysqli_close($link);
  
  //將網頁重新導向
  header("location:index.php");
  exit();
?>