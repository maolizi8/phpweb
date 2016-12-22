VERSION 1.0 CLASS
BEGIN
  MultiUse = -1  'True
END
Attribute VB_Name = "Sheet17"
Attribute VB_GlobalNameSpace = False
Attribute VB_Creatable = False
Attribute VB_PredeclaredId = True
Attribute VB_Exposed = True
Option Explicit

'Start Add 2016/03/11 -- Use closed date of bugs to search all the bugs -- by SongMo

Sub get_Closed_bugs()

    'Define variables and initialize them
    Dim tms As Single
    tms = Timer
    
    Dim sht As Worksheet
    Set sht = ThisWorkbook.Worksheets("关闭Bug列表")
    
    Dim startdate As String
    startdate = CStr(CDate(sht.Range("C4").Value))
    Dim enddate As String
    enddate = CStr(CDate(sht.Range("C5").Value) + 1)
    
    'Access database
    sht.ListObjects("Closedbuglist").QueryTable.CommandText = "select jpcategory.cname                            as 'Department Name',                                                                      " _
                                                            & "       jproject.pname                              as 'Project Name',                                                                         " _
                                                            & "       jissue.issuenum                             as 'Issue Number',                                                                         " _
                                                            & "       min(jissue.created)                         as 'Created Date',                                                                         " _
                                                            & "       max(cgroup.created)                         as 'Closed Date',                                                                          " _
                                                            & "       concat(jproject.pkey, '-', jissue.issuenum) as 'Search Key'                                                                            " _
                                                            & "  from jira.jiraissue jissue                                                                                                                  " _
                                                            & "    right join jira.changegroup cgroup         on jissue.id          =  cgroup.issueid                                                        " _
                                                            & "    right join jira.changeitem citem           on cgroup.id          =  citem.groupid                                                         " _
                                                            & "    left  join jira.project jproject           on jissue.project     =  jproject.id                                                           " _
                                                            & "    left  join jira.nodeassociation jnode      on (jproject.id       =  jnode.source_node_id and jnode.association_type = 'ProjectCategory')  " _
                                                            & "    left  join jira.projectcategory jpcategory on jnode.sink_node_id =  jpcategory.id                                                         " _
                                                            & "  where jissue.issuetype                                             =  '1'                                                                   " _
                                                            & "    and citem.NEWSTRING                                              =  'CLOSED'                                                              " _
                                                            & "    and cgroup.CREATED                                               >= '" & startdate _
                                                            & "'   and cgroup.created                                               <  '" & enddate _
                                                            & "' group by jpcategory.cname, jproject.pname, jissue.issuenum;                                                                                 "
    
    sht.ListObjects("Closedbuglist").QueryTable.Refresh
    
    'Show timer
    MsgBox "Refresh OK." & vbNewLine & "统计用时：" & Format(Timer - tms, "0.000s")
    
End Sub

'End Add 2016/03/11 -- Use closed date of bugs to search all the bugs -- by SongMo
