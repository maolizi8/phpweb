<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%
String path = request.getContextPath();
String basePath = request.getScheme()+"://"+request.getServerName()+":"+request.getServerPort()+path+"/";
%>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <base href="<%=basePath%>">
    
    <title>outcome</title>
  <meta charset="UTF-8"> 
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
    	<form method="GET" name="calculate" action="">
		<h1 align="center">双周工时计算系统</h1>
		<br /> 
		<br/> <br/> <br/> 处理结果：
		<br/>工作日共 <input type="text" name="workdays" value="${workdays}">天
		<br/>抓取工时共<input type="text" name="number1" value="${number1}">条数据
		<br/>项目总工时共<input type="text" name="number2" value="${number2}">条数据
		<br/>每天8H异常情况：共<input type="text" name="number3" value="${number3}">条数据
		<br/>每天8H异常人员的项目情况： 共<input type="text" name="number4" value="${number4}">条数据
		<br/>理论总工时80%异常情况：共<input type="text" name="number5" value="${number5}">条数据
		<br/>理论总工时80%异常人员的项目情况：共<input type="text" name="number6" value="${number6}">条数据
		<br/>计算完成！
	</form>
  </body>
</html>