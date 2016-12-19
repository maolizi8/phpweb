<!DOCTYPE HTML> 
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
</head>
<body> 

<?php
// define variables and set to empty values
$name1 = $project1= $start1=$completion1=$status1=$premission1="";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $name1 = test_input($_POST["name1"]);
   $project1 = test_input($_POST["project1"]);
   $start1 = test_input($_POST["start1"]);
   $completion1 = test_input($_POST["completion1"]);
   $status1 = test_input($_POST["status1"]);
   $premission1=test_input($_POST["premission1"]);  
}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>

<h2 align="center">测试资源管理</h2>
<form method="post" action="unknow.php"> 
   
   <table name="table1" border="" cellpadding="2" cellspacing="1" style="font-size: 16px; width:80%; ">
	<caption style="border-width: thin; border-style: solid solid none; border-color: black; font-weight: bold; ">
		测试资源项目分配情况</caption>
	<thead>
		<tr>
			<th align="center">
				姓名
			</th>
			<th>
				状态
			</th>
			<th align="center">
				当前项目
			</th>
			<th scope="col" align="center">
				开始时间
			</th>
			<th scope="col" align="center">
				完成时间
			</th>			
			<th scope="col" align="center">
				个人技能
			</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
		
		<tr>
			<td align="center" rowspan="3">
				华林
			</td>
			<td align="center" rowspan="3">
				可用
			</td>
			<td align="center">
				会员中心
			</td>
			<td align="center">
				2016/07/26
			</td>
			<td align="center">
				2016/07/26
			</td>
			<td align="center" rowspan="3">
				会员中心，整车
			</td>
			<td align="center" rowspan="3">编辑/添加</td>			
		</tr>
		
		<tr>
			<td align="center">
				会员中心
			</td>
			<td align="center">
				2016/07/26
			</td>
			<td align="center">
				2016/07/26
			</td>
		</tr>
		<tr>
			<td align="center">
				会员中心
			</td>
			<td align="center">
				2016/07/26
			</td>
			<td align="center">
				2016/07/26
			</td>
		</tr>
			<tr>
			<td align="center" rowspan="3">
				范紫燕
			</td>
			<td align="center" rowspan="3">
				锁定
			</td>
			<td align="center">
				企业应用
			</td>
			<td align="center">
				2016/07/02
			</td>
			<td align="center">
				2016/08/26
			</td>
			<td align="center" rowspan="3">
				会员中心，整车
			</td>		
			<td align="center" rowspan="3">编辑/添加</td>	
		</tr>
		
		<tr>
			<td align="center">
				企业应用
			</td>
			<td align="center">
				2016/07/02
			</td>
			<td align="center">
				2016/08/26
			</td>	
		</tr>
		<tr>
			<td align="center">
				企业应用
			</td>
			<td align="center">
				2016/07/02
			</td>
			<td align="center">
				2016/08/26
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top;">
				<?php echo $_POST["name1"]; ?>
			</td>
			<td style="vertical-align: top;">
				<?php echo $_POST["status1"]; ?>
			</td>
			<td style="vertical-align: top;">
				<?php echo $_POST["project1"]; ?>
			</td>
			<td style="vertical-align: top;">
				<?php echo $_POST["start1"]; ?>
			</td>
			<td style="vertical-align: top;">
				<?php echo $_POST["completion1"]; ?>
			</td>			
			<td style="vertical-align: top;">
				<?php echo $_POST["skill1"]; ?>
			</td>
			<td></td>
			
		</tr>
		<tr>
			<td style="vertical-align: top;">
				<input type="text" name="name1">
			</td>
			<td style="vertical-align: top;">
				<select name="status1">
					<option value="请选择状态" selected="selected">请选择状态</option>
					<option value="锁定">锁定</option>
					<option value="释放">释放</option>
					
				</select>
			</td>			
			<td style="vertical-align: top;">
				<textarea name="project1" rows="1" ></textarea>
			</td>
			<td style="vertical-align: top;">
				<input type="date" name="start1">
			</td>
			<td style="vertical-align: top;">
				<input type="date" name="completion1">
			</td>
			
			<td style="vertical-align: top;">
				<textarea name="skill1" rows="1" ></textarea>
			</td>
			<td></td>
		</tr>
		<tr>
			<td colspan="8"><input type="submit" name="submit1" value="提交"></td>
		</tr>
	</tbody>
</table>
 </form>
 
 <p><br></p>
 
</body>
</html>