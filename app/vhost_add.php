<?php
include 'function.php';

if (is_post()) {
    $r = rand(100,999);
	$file = "temp/config".$r;
	
	$domain_name = $_POST['domain_name'];
	$name = $_POST['name'];
	$git = $_POST['git'];
	
	// add record to db
	$sql = "insert into vhost values(null, '$name', '$git', '$domain_name', '/var/www/$name', '$name.conf', 0)";
	
	db_exec($sql);
    
	$content = $_POST['vhost_conf']; 
	write_file($file, $content);
	
	system("./conf_bin $file $name.conf");
	system("rm -f $file");
}
?>

<form action="vhost_add.php" method="post">
name: <input name="name" /><br/>
domain_name: <input name="domain_name" /><br/>
<!--document_root: <input name="document_root" /><br/>-->
git: <input name="git" /><br/>

<br/>
vhost config example:
<select>
<option>basic</option>
<option>normal</option>
<option>https</option>
</select><br/>
<textarea name="vhost_conf" cols="60" rows="11">
<VirtualHost *:80>
        ServerName your_domain 
        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/your_dir


        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined

</VirtualHost>
</textarea>
<input value="add" type="submit"/>
</form>
