-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************
 
--
-- Table `tl_tabletoxml_export`
--

CREATE TABLE `tl_tabletoxml_export` (
    `id` int(10) unsigned NOT NULL auto_increment,
    `tstamp` int(10) unsigned NOT NULL default '0',
    `title` varchar(64) NOT NULL default '',    
    `description` text NULL,  
    `tables` varchar(128) NOT NULL default '', 
    `fields` blob NULL,
    `exportMode` varchar(1) NOT NULL default '',
    `xmlTemplate` text NULL,
    `xmlSaveField` varchar(128) NOT NULL default '', 
    `xmlSaveName` varchar(256) NOT NULL default '', 
    `xmlSavePath` varchar(512) NOT NULL default '', 
    PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
