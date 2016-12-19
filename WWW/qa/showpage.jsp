<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>

<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://"
			+ request.getServerName() + ":" + request.getServerPort()
			+ path + "/";
%>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

	<head>
		<base href="<%=basePath%>">

		<title>计算工时</title>

		<meta http-equiv="pragma" content="no-cache">
		<meta http-equiv="cache-control" content="no-cache">
		<meta http-equiv="expires" content="0">
		<meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
		<meta http-equiv="description" content="This is my page">
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<!--
	<link rel="stylesheet" type="text/css" href="styles.css">
	-->

	</head>

	<body>
		<h1 align="center">双周工时计算系统</h1>
		<br />
		<div class="container">
			<form method="POST" name="calculate" action="Calculate">
				<div class="col-md-2">
					<label for="starttime">开始时间</label>
				</div>
				<div class="col-md-3">
					<input type="date" id="startdate" placeholder="2016-09-21" name="startdate" />
				</div>
				<div class="col-md-2">
					<label for="enddate">结束时间</label>
				</div>
				<div class="col-md-3">
					<input type="date" id="enddate" placeholder="2016-10-07" name="enddate" />
				</div>
				<div class="col-md-2">
					<input type="submit" class="btn btn-primary" value="开始计算" name="startcal" />
				</div>
			</form>
		</div>
	</body>

</html>