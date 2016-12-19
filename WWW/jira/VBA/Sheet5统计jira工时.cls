VERSION 1.0 CLASS
BEGIN
  MultiUse = -1  'True
END
Attribute VB_Name = "Sheet5"
Attribute VB_GlobalNameSpace = False
Attribute VB_Creatable = False
Attribute VB_PredeclaredId = True
Attribute VB_Exposed = True
Option Explicit

Sub getWorklog()
    Dim tms As Single
    tms = Timer
    Dim sht As Worksheet
    Set sht = ThisWorkbook.Worksheets("统计JIRA工时")

    sht.ListObjects("worklog").QueryTable.CommandText = "SELECT (SELECT concat(pkey, '-', i.issuenum) FROM jira.project WHERE id = i.project ) issue_id," _
    & "(SELECT it.pname from jira.issuetype it where i.ISSUETYPE=it.id) Issue_Type," _
    & "(SELECT iss.pname from jira.issuestatus iss where i.issuestatus=iss.id) Issue_Status," _
    & "(select  lower_user_name from jira.app_user where user_key = w.UPDATEAUTHOR) as ""填报人"", w.startdate, w.updated, ( SELECT cname FROM jira.projectcategory WHERE id = ( SELECT sink_node_id FROM jira.nodeassociation n" _
    & " WHERE n.ASSOCIATION_TYPE = 'ProjectCategory' AND n.source_node_id IN ( SELECT project FROM jira.jiraissue WHERE id = i.id ) ) ) department, " _
    & "(SELECT pname FROM jira.project WHERE id = i.project ) project, " _
    & "(SELECT distinct cname FROM jira.component c WHERE id = (SELECT min(n.sink_node_id) FROM jira.nodeassociation n  WHERE n.ASSOCIATION_TYPE = 'IssueComponent'  AND n.source_node_id = i.id)) as component, " _
    & "sum(ifnull(i.TIMEORIGINALESTIMATE,0)) / 3600 AS 估算工时, sum(ifnull(w.timeworked,0)) / 3600 AS 实际填写工时 FROM jira.worklog w, jira.jiraissue i WHERE w.issueid = i.id " _
    & "AND w.STARTDATE >= '" & CStr(CDate(sht.Range("C1").Value)) _
    & "' And w.startdate<'" & CStr(CDate(sht.Range("C2").Value) + 1) & "' GROUP BY w.id"
    'Debug.Print sht.ListObjects("worklog").QueryTable.CommandText

'    sht.ListObjects("worklog").QueryTable.CommandText = "SELECT (SELECT concat(pkey, '-', i.issuenum) FROM jira.project WHERE id = i.project ) issue_id," _
'    & " w.UPDATEAUTHOR, w.startdate, w.updated, ( SELECT cname FROM jira.projectcategory WHERE id = ( SELECT sink_node_id FROM jira.nodeassociation n" _
'    & " WHERE n.ASSOCIATION_TYPE = 'ProjectCategory' AND n.source_node_id IN ( SELECT project FROM jira.jiraissue WHERE id = i.id ) ) ) department, " _
'    & "( SELECT pname FROM jira.project WHERE id = i.project ) project, " _
'    & "sum(w.timeworked) / 3600 AS 实际填写工时 FROM jira.worklog w, jira.jiraissue i WHERE w.issueid = i.id " _
'    & "AND w.STARTDATE >= '" & sht.Range("C1").Value _
'    & "' And w.startdate<'" & CStr(CDate(sht.Range("C2").Value) + 1) & "' GROUP BY w.issueid, w.id, w.UPDATEAUTHOR"
    'Debug.Print sht.ListObjects("worklog").QueryTable.CommandText
    
    sht.ListObjects("worklog").QueryTable.Refresh
    MsgBox "Refresh OK." & vbNewLine & "统计用时：" & Format(Timer - tms, "0.000s")
End Sub

Private Sub Worksheet_Change(ByVal Target As Range)
    If Target.Address = Range("A2").Address And Application.WorksheetFunction.IsNumber(Range("A2")) Then
        Target.Parent.Range("C1").Value = db.dteByWk(Target)
        Target.Parent.Range("C2").Value = Range("C1") + 6
    End If
End Sub

Sub saveWklog()

    If MsgBox("请确认" & vbNewLine & "1. 度量报告已经定稿；" & vbNewLine & "2. 本期（月）需要提交的数据已经全部在下方列出。", vbOKCancel, "确认") = vbCancel Then
        Exit Sub
    End If

    On Error GoTo final
    Dim cnn As New ADODB.Connection
    cnn.ConnectionString = "DRIVER={MySQL ODBC 5.3 Unicode Driver};UID=pm;PWD=pm@@1234;SERVER=10.32.135.62;DATABASE=pm;PORT=3306;"
    'Set cnn = db.cnnMA
    cnn.Open

    Dim arg, rg As Range
    Dim sql As String
    Dim b As Boolean
    Dim n As Integer
    
    Set arg = ThisWorkbook.Worksheets("统计JIRA工时").Range("A4")
    Set rg = arg.Offset(1)
    Do While rg.Value <> ""

        If Not b Then
            If db.is_ext(cnn, "select count(*) from pm.ma_snp_worklog where Member='" & rg.Offset(0, 2).Value & "' AND WorkinDate='" & rg.Offset(0, 8).Value & "' AND FillDate='" & rg.Offset(0, 9).Value & "'") Then
                If MsgBox("需要提交的第【" & rg.Row & "】行数据在数据库中已经存在" & vbNewLine & "（按人员，startdate,updated），是否继续？" & vbNewLine & "选择【是】将不再提示，继续全部提交。", vbYesNo) = vbNo Then
                    Exit Do
                Else
                    b = True
                End If
            End If
        End If
        
        sql = "INSERT INTO pm.ma_snp_worklog (Weeknum, Issue_id, Member, department, prj, component, workHour, estHour, WorkinDate, FillDate, IssueType, IssueStatus, DepByMember, Oper, OpTime) VALUES ('" _
        & rg.Offset(0, 0) & "', '" & rg.Offset(0, 1) & "', '" & rg.Offset(0, 2) & "', '" & rg.Offset(0, 3) & "', '" _
        & rg.Offset(0, 4) & "', '" & rg.Offset(0, 5) & "', " & rg.Offset(0, 6) & ", " & rg.Offset(0, 7) & ", '" & Format(rg.Offset(0, 8), "yyyy-mm-dd hh:mm:ss") & "', '" & Format(rg.Offset(0, 9), "yyyy-mm-dd hh:mm:ss") & "', '" _
        & rg.Offset(0, 10) & "', '" & rg.Offset(0, 11) & "', '" & rg.Offset(0, 12) & "', '" & Environ("USERNAME") & "', '" & Now() & "')"
        cnn.Execute sql
        n = n + 1
        Set rg = rg.Offset(1)
    Loop
final:
    If cnn.State = 1 Then
        cnn.Close
    End If
    MsgBox "处理完成。提交了" & n & "条数据。"
End Sub


