#!/usr/bin/php

<?php
$username = "fltbackup";
$password = "2succeeD";
$url      = '192.168.1.138';
// Make our connection
$connection = ssh2_connect($url);
 
// Authenticate
if (!ssh2_auth_password($connection, $username, $password))
	 {echo('Unable to connect.');}
 
// Create our SFTP resource
if (!$sftp = ssh2_sftp($connection))
     {echo ('Unable to create SFTP connection.');}


$localDir  = 'file:///home/flt/Downloads/dbs';
$remoteDir = '/home/fltbackup/Dropbox/dbs/reports';
// download all the files
$files = scandir ('ssh2.sftp://' . $sftp . $remoteDir);
if (!empty($files)) {
  foreach ($files as $file) {
    if ($file != '.' && $file != '..') {
      ssh2_scp_recv($connection, "$remoteDir/$file", "$localDir/$file");
    }
  }
}
?>