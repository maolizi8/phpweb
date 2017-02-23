#! /usr/bin/python
# -*- coding: utf-8 -*-
"""
Testlink API Sample Python 2.x Client implementation
http://jetmore.org/john/misc/phpdoc-testlink193-api/TestlinkAPI/TestlinkXMLRPCServer.html
"""
import xmlrpclib
 
class TestlinkAPIClient:        
    # substitute your server URL Here
    SERVER_URL = "http://testlink.dds.com/lib/api/xmlrpc/v1/xmlrpc.php"
    
    def __init__(self, devKey):
        self.server = xmlrpclib.Server(self.SERVER_URL)
        self.devKey = devKey
 
    def reportTCResult(self, tcid, tpid,buildid, status):
        data = {"devKey":self.devKey, "testcaseid":tcid, "testplanid":tpid,"buildid":buildid, "status":status}
        return self.server.tl.reportTCResult(data)
 
    def getInfo(self):
        return self.server.tl.about()
    
    def getTestSuiteByID(self,tsid):
        data={"devKey":self.devKey, "testsuiteid":tsid}
        return self.server.tl.getTestSuiteByID(data)
    
    def getProjects (self,devKey):
        data={"devKey":devKey}
        return self.server.tl.getProjects(data)

client = TestlinkAPIClient("ac607c407d3e53472c4b6d7667bdde7g")
proj=client.getProjects("ac607c407d3e53472c4b6d7667bdde7g")
print proj[0]['message']
# print client.getInfo()
# result = client.reportTCResult(288400, 288289,585,"p")
# print result
# print result[0]['message']
# ts=client.getTestSuiteByID(279847)
# print ts
#print ts[0]['message']



