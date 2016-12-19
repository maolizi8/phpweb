$(document).ready(function()
{
	$('<div id="togglesearchformdiv"><a id="togglesearchformlink"></a></div>').insertAfter("#tbl_search_form").hide();	
	$("#togglesearchformlink").html(PMA_messages.strShowSearchCriteria).bind("click",function()
	{
		var b=$(this);	
		$("#tbl_search_form").slideToggle();
		b.text()==PMA_messages.strHideSearchCriteria?b.text(PMA_messages.strShowSearchCriteria):b.text(PMA_messages.strHideSearchCriteria);
		return false
	});
	$("#tbl_search_form.ajax").live("submit",function(b)
	{
		var c=["IS NULL","IS NOT NULL","= ''","!= ''"];
		$search_form=$(this);
		b.preventDefault();
		$("#sqlqueryresults").empty();
		var f=PMA_ajaxShowMessage(PMA_messages.strSearching,false);
		PMA_prepareForAjaxRequest($search_form);
		var a={};
		$search_form.find(":input").each(function()
		{
			var d=$(this);
			if(d.attr("type")=="checkbox"||d.attr("type")=="radio")
			{
				if(d.is(":checked"))a[this.name]=d.val()
			}
			else a[this.name]=d.val()
		});
		b=$('select[name="param[]"] option').length;
		for(var e=0;e<b;e++)
		if(!($.inArray(a["func["+e+"]"],c)>=0))
		if(a["fields["+e+"]"]==""||a["fields["+e+"]"]==null)
		{
			delete a["fields["+e+"]"];
			delete a["func["+e+"]"];
			delete a["names["+e+"]"];
			delete a["types["+e+"]"];
			delete a["collations["+e+"]"]
		}
		if(a["param[]"]!=null)
		{
			if(a["param[]"].length==b)
			{
				delete a["param[]"];
				a.displayAllColumns=true
			}
		}
		else a.displayAllColumns=true;
		$.post($search_form.attr("action"),a,function(d)
		{
			PMA_ajaxRemoveMessage(f);
			if(typeof d=="string")
			{
				$("#sqlqueryresults").html(d);
				$("#sqlqueryresults").trigger("makegrid");
				$("#tbl_search_form").slideToggle().hide();
				$("#togglesearchformlink").text(PMA_messages.strShowSearchCriteria);				
				$("#togglesearchformdiv").show();PMA_init_slider()
			}
			else
			{
				d.message=undefined&&$("#sqlqueryresults").html(d.sql_query);
				d.error!=undefined&&$("#sqlqueryresults").html(d.error)
			}
		})
	});
	$(".open_search_gis_editor").hide();
	$(".geom_func").bind("change",function()
	{
		var b=$(this);
		var c=["Contains","Crosses","Disjoint","Equals","Intersects","Overlaps","Touches","Within","MBRContains","MBRDisjoint","MBREquals","MBRIntersects","MBROverlaps","MBRTouches",
"MBRWithin","ST_Contains","ST_Crosses","ST_Disjoint","ST_Equals","ST_Intersects","ST_Overlaps","ST_Touches","ST_Within"];
		var f=c.concat(["Envelope","EndPoint","StartPoint","ExteriorRing","Centroid","PointOnSurface"]);
		var a=b.parents("tr").find("td:nth-child(5)").find("select");
		$.inArray(b.val(),c)>=0?a.attr("readonly",true):a.attr("readonly",false);
		c=b.parents("tr").find(".open_search_gis_editor");
		$.inArray(b.val(),f)>=0?c.show():c.hide()
	});
	$(".open_search_gis_editor").live("click",function(b)
	{
		b.preventDefault();
		var c=$(this);b=c.parent("td").children("input[type='text']").val();
		var f=c.parents("tr").find(".geom_func").val();
		f=f=="Envelope"?"polygon":f=="ExteriorRing"?"linestring":"point";
		c=c.parent("td").children("input[type='text']").attr("name");
		var a=$("input[name='token']").val();
		openGISEditor();
		gisEditorLoaded?loadGISEditor(b,"Parameter",f,c,a):loadJSAndGISEditor(b,"Parameter",f,c,a)
	})
},"top.frame_content");
