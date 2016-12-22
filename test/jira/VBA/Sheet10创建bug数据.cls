VERSION 1.0 CLASS
BEGIN
  MultiUse = -1  'True
END
Attribute VB_Name = "Sheet10"
Attribute VB_GlobalNameSpace = False
Attribute VB_Creatable = False
Attribute VB_PredeclaredId = True
Attribute VB_Exposed = True
Option Explicit

Sub getBugCreate()
    Dim tms As Single
    tms = Timer
    Dim sht As Worksheet
    Set sht = ThisWorkbook.Worksheets("创建Bug数据")
'time_to_sec(timediff(i.updated, i.created)) as 'Bug_life'
    sht.ListObjects("BugCreate").QueryTable.CommandText = "SELECT concat('W', WEEK(i.created,1)) as Week, " _
& "(SELECT pc.cname from jira.projectcategory pc, jira.nodeassociation n where n.ASSOCIATION_TYPE='ProjectCategory' and n.source_node_id = p.id and n.sink_node_id = pc.id) as Department, " _
& "p.pname as Project," _
& "(SELECT cname FROM jira.component c WHERE id in (SELECT max(n.sink_node_id) FROM jira.nodeassociation n WHERE n.ASSOCIATION_TYPE = 'IssueComponent' AND n.source_node_id  = i.id)) as Component," _
& "count(i.id) as Bug_Count," _
& "pr.pname as Priority " _
& "FROM jira.jiraissue i, jira.project p, jira.priority pr " _
& "where i.project=p.id and i.priority= pr.id and i.issuetype=1 and i.created>='" & sht.Range("C1").Value _
& "' And i.created<'" & CStr(CDate(sht.Range("C2").Value) + 1) & "' group by Week, Priority, Department, Project, Component order BY Week, Department"
    'Debug.Print sht.ListObjects("Buglife").QueryTable.CommandText
    sht.ListObjects("BugCreate").QueryTable.Refresh
    MsgBox "Refresh OK." & vbNewLine & "统计用时：" & Format(Timer - tms, "0.000s")
End Sub

Private Sub Worksheet_Change(ByVal Target As Range)
    If Target.Address = Range("A2").Address And Application.WorksheetFunction.IsNumber(Range("A2")) Then
        Target.Parent.Range("C1").Value = db.dteByWk(Target)
        Target.Parent.Range("C2").Value = Range("C1") + 6
    End If
End Sub

