<?php
/*
$con=mysqli_connect('localhost', 'root', 'root');
mysqli_select_db($con,'test');

$q='select * from testtable';
$result=mysqli_query($con, $q);
$row=mysqli_fetch_assoc($result);
print_r($row); */
?>


  <!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>娱乐讨论区</title>
    <script type="text/javascript">
      function check_data()
      {
        if (document.myForm.author.value.length == 0)
          alert("作者字段不可以空白哦！");
        else if (document.myForm.subject.value.length == 0)
          alert("主题字段不可以空白哦！");
        else if (document.myForm.content.value.length == 0)
          alert("内容字段不可以空白哦！");
        else
          myForm.submit();
      }
    </script>		
  </head>
  <body>
    <p align="center"><img src="fig.jpg"></p>
    <?php
  function create_connection()
  {
    $link = mysqli_connect("localhost", "root", "root")
      or die("无法建立数据连接: " . mysqli_connect_error());
	  
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
      //指定每頁顯示幾筆記錄
      $records_per_page = 5;
			
      //取得要顯示第幾頁的記錄
      if (isset($_GET["page"]))
        $page = $_GET["page"];
      else
        $page = 1;
				
      //建立資料連接
      $link = create_connection();
					
      //執行 SQL 命令
      $sql = "SELECT id, author, subject, date FROM message ORDER BY date DESC";
      $result = execute_sql($link, "guestbook", $sql);
				
      //取得記錄數
      $total_records = mysqli_num_rows($result);
			
      //計算總頁數
      $total_pages = ceil($total_records / $records_per_page);
			
      //計算本頁第一筆記錄的序號
      $started_record = $records_per_page * ($page - 1);
			
      //將記錄指標移至本頁第一筆記錄的序號
      mysqli_data_seek($result, $started_record);

      echo "<table width='800' align='center' cellspacing='3'>";
			
      //使用 $bg 陣列來儲存表格背景色彩
      $bg[0] = "#D9D9FF";
      $bg[1] = "#FFCAEE";
      $bg[2] = "#FFFFCC";
      $bg[3] = "#B9EEB9";
      $bg[4] = "#B9E9FF";					
	  
      //顯示記錄
      $j = 1;
      while ($row = mysqli_fetch_assoc($result) and $j <= $records_per_page)
      {
        echo "<tr>";
        echo "<td width='120' align='center'><img src='" . mt_rand(0, 9) . ".gif'></td>";
        echo "<td bgcolor='" . $bg[$j - 1] . "'>作者：" . $row["author"] . "<br>";
        echo "主题：" . $row["subject"] . "<br>";
        echo "时间：" . $row["date"] . "<hr>";
        echo "<a href='show_news.php?id=";
        echo $row["id"] . "'>阅读与加入讨论区</a></td></tr>";				
        $j++;
      }
      echo "</table>" ;
			
      //產生導覽列
      echo "<p align='center'>";
			
      if ($page > 1)
        echo "<a href='index.php?page=". ($page - 1) . "'>上一页</a> ";
				
      for ($i = 1; $i <= $total_pages; $i++)
      {
        if ($i == $page)
          echo "$i ";
        else
          echo "<a href='index.php?page=$i'>$i</a> ";		
      }
			
      if ($page < $total_pages)
        echo "<a href='index.php?page=". ($page + 1) . "'>下一页</a> ";			
				
      echo "</p>";
			
      //釋放記憶體空間
      mysqli_free_result($result);
      mysqli_close($link);
    ?> 		
    <hr>
    <!- 显示输入新留言表单 -->
    <form name="myForm" method="post" action="post.php">
      <table border="0" width="800" align="center" cellspacing="0">
        <tr bgcolor="#0084CA" align="center">
          <td colspan="2"><font color="white">请在此输入新的讨论</font></td>
        </tr>
        <tr bgcolor="#D9F2FF">
          <td width="15%">作者</td>
          <td width="85%"><input name="author" type="text" size="50"></td>
        </tr>
        <tr bgcolor="#84D7FF">
          <td width="15%">主题</td>
          <td width="85%"><input name="subject" type="text" size="50"></td>
        </tr>
        <tr bgcolor="#D9F2FF">
          <td width="15%">內容</td>
          <td width="85%"><textarea name="content" cols="50" rows="5"></textarea></td>
        </tr>
        <tr>
          <td colspan="2" height="40" align="center">
            <input type="button" value="张贴讨论" onClick="check_data()">　
            <input type="reset" value="重新输入">
          </td>  
        </tr>
      </table>   
    </form> 
  </body>
</html>