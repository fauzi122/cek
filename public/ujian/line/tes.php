<?php
 
 function koneksimybest() {  
	$mysql=mysql_connect("172.16.192.37","3l_ubS1","BT!bS12021");
	mysql_select_db("uj14n_d3_b51");
	return $mysql;	
}
$dbi=koneksimybest(); 
$login=mysql_query("SELECT * from b51users where userid='8512' ",$dbi);

					$ketemu=mysql_num_rows($login);					 
 	            
					echo " xxx"; 
?>