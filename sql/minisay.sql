
CREATE TABLE `isay_article` (
  `gid` int(11) NOT NULL auto_increment,
  `content` text NOT NULL,
  `postdate` date default NULL,
  `posttime` time default NULL,
  PRIMARY KEY  (`gid`)
) default character set 'utf8';


INSERT INTO `isay_article` (`gid`, `content`, `postdate`, `posttime`) VALUES
(1, '欢迎使用 minisay 笔记程序。', '2010-12-22', '21:29:50');


CREATE TABLE `isay_message` (
  `mid` int(11) NOT NULL auto_increment,
  `poster` varchar(40) NOT NULL,
  `message` text NOT NULL,
  `reply` text,
  `postdate` date default NULL,
  `posttime` time default NULL,
  PRIMARY KEY  (`mid`)
) default character set 'utf8';


INSERT INTO `isay_message` (`mid`, `poster`, `message`, `reply`, `postdate`, `posttime`) VALUES
(1, 'isayer', 'minisay，记录生活的点滴。', '', '2010-12-23', '00:12:57');
