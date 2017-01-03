<!DOCTYPE HTML> 
<html>
<head>
</head>
<body> 

<?php
// define variables and set to empty values
$number1 = $mission1 = $leader1=$completion1=$status1=$notes1=$nextmission1="";
$number2= $mission2 =$target2= $completion2="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $number1 = test_input($_POST["number1"]);
   $mission1 = test_input($_POST["mission1"]);
   $leader1 = test_input($_POST["leader1"]);
   $completion1 = test_input($_POST["completion1"]);
   $status1 = test_input($_POST["status1"]);
   $notes1=test_input($_POST["notes1"]);
   $nextmission1=test_input($_POST["nextmission1"]);
   $number2= test_input($_POST["number2"]);
   $mission2 =test_input($_POST["mission2"]);
   $target2= test_input($_POST["target2"]);
   $completion2=test_input($_POST["completion2"]);
}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>

<h2>质量保障部周报</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
   
   <table name="table1" border="1" cellpadding="1" cellspacing="1" style="font-family: 'trebuchet ms', arial, verdana, sans-serif; font-size: 12px; width:80%; background-color: rgb(205, 222, 243);">
	<caption style="border-width: thin; border-style: solid solid none; border-color: black; font-weight: bold; background: rgb(204, 204, 204);">
		上周/月 关键任务/重点项目进展情况</caption>
	<thead>
		<tr>
			<th scope="col" style="vertical-align: top;">
				序号
			</th>
			<th scope="col" style="vertical-align: top;">
				关键任务/重大项目
			</th>
			<th scope="col" style="vertical-align: top;">
				责任人
			</th>
			<th scope="col" style="vertical-align: top;">
				完成时间
			</th>
			<th scope="col" style="vertical-align: top;">
				状态
			</th>
			<th scope="col" style="vertical-align: top;">
				进展说明
			</th>
			<th scope="col" style="vertical-align: top;">
				下一步行动/达成目标
			</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style="vertical-align: top;">
				<?php echo $_POST["number1"]; ?>
			</td>
			<td style="vertical-align: top;">
				<?php echo $_POST["mission1"]; ?>
			</td>
			<td style="vertical-align: top;">
				<?php echo $_POST["leader1"]; ?>
			</td>
			<td style="vertical-align: top;">
				<?php echo $_POST["completion1"]; ?>
			</td>
			<td style="vertical-align: top;">
				<?php echo $_POST["status1"]; ?>
			</td>
			<td style="vertical-align: top;">
				<?php echo $_POST["notes1"]; ?>
			</td>
			<td style="vertical-align: top;">
				<?php echo $_POST["nextmission1"]; ?>
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top;">
				<input type="text" name="number1">
			</td>
			<td style="vertical-align: top;">
				<textarea name="mission1" rows="1" ></textarea>
			</td>
			<td style="vertical-align: top;">
				<input type="text" name="leader1">
			</td>
			<td style="vertical-align: top;">
				<input type="date" name="completion1">
			</td>
			<td style="vertical-align: top;">
				<select name="status1">
					<option value="" selected="selected">请选择状态</option>
					<option value="未开始">未开始</option>
					<option value="进行中">进行中</option>
					<option value="已完成" >已完成</option>
				</select>
			</td>
			<td style="vertical-align: top;">
				<textarea name="notes1" rows="1" ></textarea>
			</td>
			<td style="vertical-align: top;">
				<textarea name="nextmission1" rows="1" ></textarea>
			</td>
		</tr>
		<tr>
			<td colspan="7"><input type="submit" name="submit1" value="提交"></td>
		</tr>
	</tbody>
</table>
 </form>
 
 <p><br></p>
 <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
 <table name="table2" border="1" cellpadding="1" cellspacing="1" style="font-family: 'trebuchet ms', arial, verdana, sans-serif; font-size: 12px; width: 500px; background-color: rgb(205, 222, 243);">
	<caption style="border-width: thin; border-style: solid solid none; border-color: black; font-weight: bold; background: rgb(204, 204, 204);">
		本周/月关键任务</caption>
	<thead>
		<tr>
			<th scope="col" style="vertical-align: top;">
				序号
			</th>
			<th scope="col" style="vertical-align: top;">
				关键任务/重点项目
			</th>
			<th scope="col" style="vertical-align: top;">
				达成目标
			</th>
			<th scope="col" style="vertical-align: top;">
				责任人
			</th>
			<th scope="col" style="vertical-align: top;">
				完成时间
			</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style="vertical-align: top;">
				<?php echo $_POST["number2"]; ?>
			</td>
			<td style="vertical-align: top;">
				<?php echo $_POST["mission2"]; ?>
			</td>
			<td style="vertical-align: top;">
				<?php echo $_POST["target2"]; ?>
			</td>
			<td style="vertical-align: top;">
				<?php echo $_POST["leader2"]; ?>
			</td>
			<td style="vertical-align: top;">
				<?php echo $_POST["completion2"]; ?>
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top;">
				<input type="text" name="number2">
			</td>
			<td style="vertical-align: top;">
				<textarea name="mission2" rows="1" ></textarea>
			</td>
			<td style="vertical-align: top;">
				<textarea name="target2" rows="1"></textarea>
			</td>
			<td style="vertical-align: top;">
				<input type="text" name="leader2">
			</td>
			<td style="vertical-align: top;">
				<input type="date" name="completion2">
			</td>
		</tr>
		
		<tr>
			<td colspan="5"><input type="submit" name="submit2" value="提交"></td>
		</tr>
	</tbody>
</table>
</form>

</body>
</html>