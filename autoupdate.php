<?php
	$deleteOlderBackup = shell_exec('rm -r ~/backup/box');
	$updateOlderBackup = shell_exec('mv ~/box ~/backup ');

	$createNewBackup = shell_exec('cp -r /var/www/box ~/');
	$gitPull = shell_exec('git pull');

	$to = 'mcs1901@outlook.com';
	$subject = 'Auto update report from PetBox';
	$message = 'delete older backup: '.$deleteOlderBackup.'// update older backup: '.$updateOlderBackup.' // create new backup: '.$createNewBackup.'  // git pull: '.$gitPull;
	mail($to,$subject,$message)
 ?>
