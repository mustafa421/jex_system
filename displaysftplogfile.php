<?php



echo "<br>";echo "<br>";echo "<br>";echo "<br>";
   echo "<b><font color='blue'>Nightly SFTP LogFile</font></b>";
   echo "<br>";
   echo "<b><font color='blue'>*******************</font></b>";
echo "<br>";



$lines = file('sftplog.txt');
 

echo 'Contents of sftplog.txt using file():
';echo "<br>";
foreach ($lines as $line)
{
echo htmlspecialchars($line) . '<br>';
}
 

?>