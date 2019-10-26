import pymysql
import json
class BaseSql:
    cursor=""
    conn=""
    sqlconfig={}
    def __init__(self):
        # 连接database
        sqlconfig=BaseSql.output()
        self.conn = pymysql.connect(sqlconfig['host'],sqlconfig['username'],sqlconfig['password'],sqlconfig['database'])
        self.cursor = self.conn.cursor()
    def output():
        file = open("./test_data.json", "rb")
        fileJson = json.load(file)
        return fileJson['sql']
    def Execute(self,sql):
        self.cursor.execute(sql)
        dataname=self.cursor.description  #可以通过此方法在控制台中打印出表中所有的字段名和字段信息
        data=self.cursor.fetchall()
        return self.SqlBack(dataname,data)
    def Close(self):
        # 关闭光标对象
        self.cursor.close()
        # 关闭数据库连接
        self.conn.close()
    def CreateTable(self,sql):
        return Execute(sql)
    def DeleteTable(self,sql):
        return Execute(sql)
    def DeleteData(self,sql):
        return Execute(sql)
    def UpdateData(self,sql):
        return Execute(sql)
    def InsertData(self,sql):
        return Execute(sql)
    def Select(self,sql):
       return BaseSql.Execute(self,sql)
    def SqlBack(self,dataname,data):
        backdata={}
        for k , v in enumerate(data):
            item={}
            for k1 ,v1 in enumerate(dataname):
                item[v1[0]]=v[k1]
            backdata[k]=item
        return backdata
