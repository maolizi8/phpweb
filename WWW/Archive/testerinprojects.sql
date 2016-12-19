# Host: localhost  (Version: 5.5.40)
# Date: 2016-08-05 15:00:19
# Generator: MySQL-Front 5.3  (Build 4.120)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "testerinprojects"
#

DROP TABLE IF EXISTS `testerinprojects`;
CREATE TABLE `testerinprojects` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `testerid` int(11) NOT NULL DEFAULT '0',
  `project` varchar(255) DEFAULT NULL,
  `starttime` date DEFAULT NULL,
  `completetime` date DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

#
# Data for table "testerinprojects"
#

/*!40000 ALTER TABLE `testerinprojects` DISABLE KEYS */;
INSERT INTO `testerinprojects` VALUES (1,1,'会员中心','2016-08-12','2016-08-18',0),(2,1,'车享家','2016-07-12','2016-08-12',1),(3,2,'微信','2016-08-12','2016-09-12',0),(4,1,'违章','2016-08-12','2016-09-12',0),(5,1,'车务','2016-06-12','2016-07-12',2),(6,2,'泊车','2016-06-12','2016-07-12',2),(7,2,'泊车','2016-06-12','2016-07-12',2),(8,2,'泊车','2016-06-12','2016-07-12',2),(9,2,'泊车','2016-06-12','2016-07-12',2),(10,2,'泊车','2016-06-12','2016-07-12',2),(11,2,'泊车','2016-06-12','2016-07-12',2),(12,2,'泊车','2016-06-12','2016-07-12',2),(13,2,'泊车','2016-06-12','2016-07-12',2),(14,2,'泊车','2016-06-12','2016-07-12',2),(15,2,'测试','2016-08-01','2016-08-24',1),(16,2,'测试','2016-08-01','2016-08-24',1),(17,2,'测试','2016-08-19','2016-08-24',0),(18,2,'测试','2016-07-14','2016-07-27',2);
/*!40000 ALTER TABLE `testerinprojects` ENABLE KEYS */;
