# -*- coding: utf-8 -*-

#send mail automatically
#read an excel file and display as table on html

from smtplib import SMTP_SSL
from email.header import Header
from email.mime.text import MIMEText
import xlrd
import os,time
import base64

#class: handling the type of data of excel
#converse float to int; converse float to str
class judgeFloat:
    def floatToInt(self,variable):
        variable="%d"%variable
        return variable
    def floatToStr(self,variable):
        variable=xlrd.xldate_as_tuple(variable,0)
        variable=list(variable)
        if variable[1]<10:
            variable[1]='0'+str(variable[1])
        variable=str(variable[0])+str(variable[1])+str(variable[2])
        return variable

def mailWrite(filename,address):
    header='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>'
    th='<body text="#000000">committed缺陷详情：<br /><table border="1" cellspacing="0" cellpadding="3" bordercolor="#000000" width="80%" align="left" ><tr bgcolor="#F79646" align="left" ><th>标识</th><th>摘要</th><th>状态</th><th>优先级</th><th>严重性</th><th>标记</th><th>所有者</th><th>创建时间</th><th>修改时间</th></tr>'
    
    filepath=address+filename
    book=xlrd.open_workbook(filepath)
    sheet=book.sheet_by_index(0)
    #get the number of cols and rows in excel
    nrows = sheet.nrows-1
    ncols = sheet.ncols
    body=''
    cellData=1
    tr=''
    for i in range(1,nrows+1):
        td=''
        for j in range(ncols):
            #get the date value of cell to cellData
            cellData=sheet.cell_value(i,j)
            #type of data which is read from excel is float 
            #converse the type float to datetime
            if isinstance(cellData,float):
                if j==0 and i>0:
                    cellDataNew=judgeFloat()
                    cellData=cellDataNew.floatToInt(cellData)
                else:
                    cellDataNew=judgeFloat()
                    cellData=cellDataNew.floatToStr(cellData)
            else:
                pass
            tip='<td>'+cellData+'</td>'
            td=td+tip
        tr='<tr>'+td+'</tr>'
        # tr=tr.encode('utf-8')
        body=body+tr
    tail='</table></body></html>'
    mail=header+th+body+tail
    return mail

def mailSend(mail):
    mail_info = {
        "from": "XXX@qq.com",
        "to": ["XXX@qq.com","XXX@qq.com","XXX@qq.com"],
        "hostname": "smtp.qq.com",
        "username": "XXX@qq.com",
        "password": "XXXX",
        "mail_subject": "send mails automatically",
        "mail_encoding": "utf-8"
    }
    smtp = SMTP_SSL(mail_info["hostname"])
    smtp.set_debuglevel(1)
    
    smtp.ehlo(mail_info["hostname"])
    smtp.login(mail_info["username"], mail_info["password"])

    msg = MIMEText(mail, "html", mail_info["mail_encoding"])
    msg["Subject"] = Header(mail_info["mail_subject"], mail_info["mail_encoding"])
    msg["from"] = mail_info["from"]
    msg["to"] = ','.join(mail_info["to"])   #【注意】 此处是逗号连接的字符串
    smtp.sendmail(mail_info["from"], mail_info["to"], msg.as_string())  #【注意】 接收邮件的是list
    smtp.quit()
    

def main():
    filename='Sheet1.xlsx'
    address='E:/workspaces/mail/'
    #openFile(filename,address)
    mail=mailWrite(filename,address)
    #print(mail)
    mailSend(mail)


if __name__=="__main__":
    main()




   
