	$(function() {
		$(document).on("click", ".addProject", function() {
			$('#addProject').modal({
				backdrop: 'static',
				show: true
			});
		});
		loadProjID();
	});

	function addProjID() {
		if($.trim($("#projname").val()) == "") {
			layer.alert("项目名称不能为空！");
			return;
		} else if($.trim($("#projid").val()) == "") {
			layer.alert("项目ID不能为空！");
			return;
		} else if(isNaN($.trim($("#projid").val()))) {
			layer.alert("项目ID必须为纯数字！");
			return;
		} else {
			var projIDLocal;
			if(localStorage.projIDLocal != null) {
				projIDLocal = JSON.parse(window.localStorage.projIDLocal);
				console.log(projIDLocal);
				projIDLocal.push({
					projname: $.trim($("#projname").val()),
					projid: $.trim($("#projid").val())
				});
			} else {
				projIDLocal = [{
					projname: "",
					projid: ""
				}];
				projIDLocal[0].projname = $.trim($("#projname").val());
				projIDLocal[0].projid = $.trim($("#projid").val());
			}

			window.localStorage.projIDLocal = JSON.stringify(projIDLocal);
			$('#addProject').modal('hide');
			$("#projectsidtbody").empty();
			loadProjID();
		}
	}

	function loadProjID() {
		var projIDList = JSON.parse(window.localStorage.projIDLocal);
		console.log(projIDList);
		var tbody = "";
		for(var i = 0, len = projIDList.length; i < len; i++) {
			tbody += '<tr>';
			tbody += '<td>' + projIDList[i].projid + '</td>';
			tbody += '<td>' + projIDList[i].projname + '</td>';
			tbody += '<td><input type="button" value="删除" class="btn" onclick="deleteProjID(' + i + ')" /></td>';
			tbody += '</tr>';
		}
		$("#projectsidtbody").append(tbody);
	}

	function deleteProjID(i) {
		layer.confirm('确定要删除？', function(index) {
			console.log(i);
			var projIDList = JSON.parse(window.localStorage.projIDLocal);
			projIDList.splice(i, 1);
			window.localStorage.projIDLocal = JSON.stringify(projIDList);
			$("#projectsidtbody").empty();
			loadProjID();
			layer.close(index);
		})
	}

	//	$(function() {
	//		$.ajax({
	//			type : "post",
	//			url : "JiraServlet",
	//			contentType : "application/json; charset=utf-8",
	//			dataType : "json",
	//			success : function(data) {
	//				//console.log(data);
	//				//var projList=eval(data);
	//				var projList = data;
	//				var tbody = "";
	//				for (i = 0, len = projList.length; i < len; i++) {
	//
	//					tbody += '<tr>';
	//					tbody += '<td>' + projList[i].ID + '</td>';
	//					tbody += '<td align="left">' + projList[i].pname + '</td>';
	//					tbody += '</tr>';
	//				}
	//				$("#projectsidtbody").append(tbody);
	//
	//			},
	//			error : function(XMLHttpRequest, textStatus, errorThrown) {
	//				//alert(errorThrown);
	//				console.log(errorThrown);
	//			}
	//		});
	//
	//	})

	var backgrey = document.getElementsByClassName("backgrey")[0];
	var spinner = document.getElementsByClassName("spinner")[0];

	function calMeasure() {
		var projid = $.trim($("#department").val());
		if(projid == "") {
			layer.alert("请输入项目ID！");
			return;
		} else if(isNaN(projid)) {
			layer.alert("项目ID为纯数字！");
			return;
		} else if($.trim($("#startdate").val()) == "") {
			layer.alert("请输入开始日期！");
			return;
		} else if($.trim($("#enddate").val()) == "") {
			layer.alert("请输入结束日期！");
			return;
		} else {
			backgrey.classList.remove("fade");
			spinner.classList.remove("fade");
			$.ajax({
				type: "post",
				url: "CalculateMeasure",
				data: $("#calProjMeasure").serialize(),
				success: function(data) {
					if(data == '[]') {
						backgrey.classList.add("fade");
						spinner.classList.add("fade");
						layer.alert("无相关数据，请修改查询条件！");
					} else {
						var projList = eval(data);
						console.log(projList);
						var tbody = "";
						tbody += '<tr>';
						tbody += '<td>' + projList[0].projectid + '</td>';
						tbody += '<td>' + projList[0].projname + '</td>';
						tbody += '<td>' + projList[0].totalbugs + '</td>';
						tbody += '<td>' + projList[0].realbug + '</td>';
						var valid = Math.round(projList[0].valid * 10000) / 100.00;
						var beforepre = Math
							.round(projList[0].beforepre * 10000) / 100.00;
						var reopen = Math.round(projList[0].reopen * 10000) / 100.00;
						var productenv = Math
							.round(projList[0].productenv * 10000) / 100.00;
						var p0p1 = Math.round(projList[0].p0p1 / 864) / 100.00;
						var p2p3 = Math.round(projList[0].p2p3 / 864) / 100.00;
						tbody += '<td>' + valid + '%</td>';
						tbody += '<td>' + reopen + '%</td>';
						tbody += '<td>' + beforepre + '%</td>';
						tbody += '<td>' + productenv + '%</td>';
						tbody += '<td>' + p0p1 + '</td>';
						tbody += '<td>' + p2p3 + '</td>';
						tbody += '<td>' + projList[0].batch + '</td>';
						tbody += '<td>' + projList[0].createddate + '</td>';
						tbody += '</tr>';

						backgrey.classList.add("fade");
						spinner.classList.add("fade");
						$("#myTab li:eq(0) a").tab('show');

						$("#projMeasBody").append(tbody);
					}
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					layer.alert(errorThrown);
				}
			});
		}

	}

	function calTestTime() {
		var projid = $.trim($("#department").val());
		if(projid == "") {
			layer.alert("请输入项目ID！");
			return;
		} else if(isNaN(projid)) {
			layer.alert("项目ID为纯数字！");
			return;
		} else if($.trim($("#startdate").val()) == "") {
			layer.alert("请输入开始日期！");
			return;
		} else if($.trim($("#enddate").val()) == "") {
			layer.alert("请输入结束日期！");
			return;
		} else {
			backgrey.classList.remove("fade");
			spinner.classList.remove("fade");

			console.log($("#calTeseterWork").serialize())
			$.ajax({
				type: "post",
				url: "CalculateTestTime",
				data: $("#calProjMeasure").serialize(),
				success: function(data) {
					if(data == '[]') {
						backgrey.classList.add("fade");
						spinner.classList.add("fade");
						layer.alert("无相关数据，请修改查询条件！");
					} else {
						var testworkList = eval(data);
						console.log(testworkList);
						var tbody = "";
						tbody += '<tr>';
						var sumworked = Math
							.round(testworkList[0].sumworked / 288) / 100.00;
						tbody += '<td>' + testworkList[0].projid + '</td>';
						tbody += '<td>' + sumworked + '</td>';
						tbody += '<td>' + testworkList[0].batch + '</td>';
						tbody += '<td>' + testworkList[0].createddate +
							'</td>';
						tbody += '</tr>';
						backgrey.classList.add("fade");
						spinner.classList.add("fade");
						$("#myTab li:eq(1) a").tab('show');
						$("#testerWorkBody").append(tbody);
					}
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					layer.alert(errorThrown);
				}
			});
		}
	}

	function calDevelopTime() {
		var projid = $.trim($("#department").val());
		if(projid == "") {
			layer.alert("请输入项目ID！");
			return;
		} else if(isNaN(projid)) {
			layer.alert("项目ID为纯数字！");
			return;
		} else if($.trim($("#startdate").val()) == "") {
			layer.alert("请输入开始日期！");
			return;
		} else if($.trim($("#enddate").val()) == "") {
			layer.alert("请输入结束日期！");
			return;
		} else {
			backgrey.classList.remove("fade");
			spinner.classList.remove("fade");
			$.ajax({
				type: "post",
				url: "CalculateDevelopTime",
				data: $("#calProjMeasure").serialize(),
				success: function(data) {
					console.log(data);
					if(data == '[]') {
						backgrey.classList.add("fade");
						spinner.classList.add("fade");
						layer.alert("无相关数据，请修改查询条件！");
					} else {
						var devworkList = eval(data);
						console.log(devworkList);
						var tbody = "";
						tbody += '<tr>';
						tbody += '<td>' + devworkList[0].projid + '</td>';
						var sumworked = Math
							.round(devworkList[0].sumworked / 288) / 100.00;
						tbody += '<td>' + sumworked + '</td>';
						tbody += '<td>' + devworkList[0].batch + '</td>';
						tbody += '<td>' + devworkList[0].createddate +
							'</td>';
						tbody += '</tr>';
						backgrey.classList.add("fade");
						spinner.classList.add("fade");
						$("#myTab li:eq(2) a").tab('show');

						$("#developerWorkBody").append(tbody);
					}
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					layer.alert(errorThrown);
				}
			});
		}
	}

	function calAllDevelopTime() {
		var projid = $.trim($("#department").val());
		if(projid == "") {
			layer.alert("请输入项目ID！");
			return;
		} else if(isNaN(projid)) {
			layer.alert("项目ID为纯数字！");
			return;
		} else if($.trim($("#startdate").val()) == "") {
			layer.alert("请输入开始日期！");
			return;
		} else if($.trim($("#enddate").val()) == "") {
			layer.alert("请输入结束日期！");
			return;
		} else {
			backgrey.classList.remove("fade");
			spinner.classList.remove("fade");
			$.ajax({
				type: "post",
				url: "CalculateAllDevWorklog",
				data: $("#calProjMeasure").serialize(),
				success: function(data) {
					console.log(data);
					if(data == '[]') {
						backgrey.classList.add("fade");
						spinner.classList.add("fade");
						layer.alert("无相关数据，请修改查询条件！");
					} else {
						var devworkList = JSON.parse(data);
						console.log(devworkList);
						var tbody = "";
						tbody += '<tr>';
						tbody += '<td>' + devworkList.project + '</td>';
						tbody += '<td>' + devworkList.pname + '</td>';
						var sumwtest = Math.round(devworkList.sumtest / 288) / 100.00;
						var sumdevelop = Math.round(devworkList.sumdevelop / 288) / 100.00;
						tbody += '<td>' + sumdevelop + '</td>';
						tbody += '<td>' + sumwtest + '</td>';
						tbody += '<td>' + devworkList.batch + '</td>';
						tbody += '<td>' + devworkList.createddate + '</td>';
						tbody += '</tr>';
						backgrey.classList.add("fade");
						spinner.classList.add("fade");
						$("#myTab li:eq(3) a").tab('show');
						$("#alldeveloperWorkBody").append(tbody);
					}
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					layer.alert(errorThrown);
				}
			});
		}
	}