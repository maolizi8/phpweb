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

		<title>登录</title>
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
		<h1 align="center">双周工时计算系统用户登录</h1>
		<br />
		<div style="width: 40%;margin-left: auto;margin-right: auto;margin-top: 50px;">
			<form class="form-horizontal" method="POST" name="login" action="LoginServlet">
				<div class="form-group">
					<label for="username" class="col-sm-2 control-label">用户名：</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="username" placeholder="Your name" size="20" maxlength="20" onfocus="if (this.value=='Your name')  this.value='';" />
					</div>
				</div>
				<div class="form-group">
					<label for="password" class="col-sm-2 control-label">密&nbsp;&nbsp;码：</label>
					<div class="col-sm-10">
						<input type="password" class="form-control" name="password" placeholder="Your password" size="20" maxlength="20" onfocus="if (this.value=='Your password')  this.value='';" />
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<input type="submit" class="btn btn-default" name="Submit" value="提交" onClick="return validateLogin()" />

						<input type="reset" class="btn btn-default" name="Reset" value="重置" />
					</div>
				</div>
			</form>
			<script language="javascript">
				function validateLogin() {
					var sUserName = document.frmLogin.username.value;
					var sPassword = document.frmLogin.password.value;
					if((sUserName == "") || (sUserName == "Your name")) {
						alert("请输入用户名!");
						return false;
					}

					if((sPassword == "") || (sPassword == "Your password")) {
						alert("请输入密码!");
						return false;
					}
				}
			</script>
		</div>
	</body>

</html>