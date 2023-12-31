<?php
$conn = mysqli_connect('db', 'root', 'MYSQL_ROOT_PASSWORD');
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$dbmake = mysqli_query($conn, 'CREATE DATABASE IF NOT EXISTS PM_1');
if (!$dbmake) {
  die("Database could not be created! " . $conn->connect_error);
}
$dbconn = mysqli_connect('db', 'root', 'MYSQL_ROOT_PASSWORD', 'PM_1');
$sql = "CREATE TABLE IF NOT EXISTS `Credentials`(
    `User_ID` int(8) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `Username` varchar(256),
    `Email` varchar(256),
    `Password` varchar(1024),
    `Salt` varchar(256),
    `Salt2` varchar(256),
    `Secret_Key` varchar(64),
    `IV` varchar(64),
    `Order_ID` varchar(32) DEFAULT '0'
  )";
$tbconn = mysqli_query($dbconn, $sql);
if (!$tbconn) {
  die("Table could not be created! " . $dbconn->connect_error);
}
$sql = "CREATE TABLE IF NOT EXISTS `Password_Reset` (
    `User_ID` int(8) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `Username` varchar(256) DEFAULT NULL,
    `Email` varchar(256) DEFAULT NULL,
    `Reset_Key` varchar(128) DEFAULT NULL,
    `ExpDate` datetime DEFAULT NULL,
    FOREIGN KEY(`User_ID`) REFERENCES `Credentials`(`User_ID`)
  )";
$tbconn = mysqli_query($dbconn, $sql);
if (!$tbconn) {
  die("Table could not be created! " . $dbconn->connect_error);
}
$sql = "CREATE TABLE IF NOT EXISTS `User_Info` (
    `User_ID` int(8) NOT NULL,
    `Website` varchar(512) DEFAULT NULL,
    `Username` varchar(512) DEFAULT NULL,
    `Link` varchar(512) NOT NULL,
    `Password` varchar(256) DEFAULT NULL,
    `IV` varchar(64) DEFAULT NULL,
    `Add_Date` datetime,
    `Description` varchar(512) DEFAULT NULL,
    `Wrd/Phr` tinyint(1) NOT NULL DEFAULT 0,
    `RST` tinyint(1) NOT NULL DEFAULT 0,
    PRIMARY KEY(`User_ID`,`Website`),
    FOREIGN KEY(`User_ID`) REFERENCES `Credentials`(`User_ID`)
  )";
$tbconn = mysqli_query($dbconn, $sql);
if (!$tbconn) {
  die("Table could not be created! " . $dbconn->connect_error);
}
$sql = "CREATE TABLE IF NOT EXISTS `Old_Passwords` (
    `Entry_ID` int(8) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `User_ID` int(8) NOT NULL,
    `Website` varchar(512) NOT NULL,
    `Link` varchar(512) NOT NULL,
    `Old_Hash` varchar(256) DEFAULT NULL,
    `Add_Date` datetime,
    FOREIGN KEY(`User_ID`, `Website`) REFERENCES `User_Info`(`User_ID`,`Website`)
  )";
$tbconn = mysqli_query($dbconn, $sql);
if (!$tbconn) {
  die("Table could not be created! " . $dbconn->connect_error);
}
$sql = "CREATE TABLE IF NOT EXISTS `Files` (
  `User_ID` int(8) NOT NULL AUTO_INCREMENT,
  `File_Name` varchar(256) NOT NULL,
  `Upload_Date` datetime NOT NULL,
  `Size` int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`User_ID`,`File_Name`),
  FOREIGN KEY(`User_ID`) REFERENCES `Credentials`(`User_ID`)
)";
$tbconn = mysqli_query($dbconn, $sql);
if (!$tbconn) {
  die("Table could not be created! " . $dbconn->connect_error);
}
$dbconn->close();
$conn->close();
