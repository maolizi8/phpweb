Attribute VB_Name = "db"
Option Explicit

Public Function cnnMA() As ADODB.Connection
    Dim conn As New ADODB.Connection
    conn.ConnectionString = "DRIVER={MySQL ODBC 5.3 Unicode Driver};UID=pm;PWD=pm@@1234;SERVER=10.32.135.62;DATABASE=pm;PORT=3306;"
    'conn.Open
    Set cnnMA = conn
End Function

Public Function dteByWk(ByVal wk As Range) As Date
    Dim w As Integer
    w = CInt(wk.Value)
    dteByWk = CDate(CDate("2015-1-5") + (w - 2) * 7)
End Function

Public Function getSelCol(ByRef arg As Range) As Range
    Dim rg As Range
    If arg.Columns.Count > 1 Then
        Set rg = arg.Parent.Range(arg.Item(1).Offset(0, 1 - arg.Column), arg.Item(1).Offset(arg.Rows.Count - 1, 1 - arg.Column))
    Else
        Set rg = arg.Offset(0, 1 - arg.Column)
    End If
    Set getSelCol = rg
End Function

Public Function is_ext(ByRef cnn As ADODB.Connection, sql As String) As Boolean
    Dim str As String
    Dim rs As New ADODB.Recordset
    Dim n As Integer

    rs.Open sql, cnn, adOpenDynamic, adLockReadOnly
    n = CInt(rs(0).Value)
    If rs.State = 1 Then
        rs.Close
    End If
    is_ext = (n > 0)
End Function
