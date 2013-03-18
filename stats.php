<html>
<body>
<p>This is just a lazy page so I can read some of the metrics.</br>
I'll probably wrap this up nicely into a trends one day - with graphs and stuff.</p>
<?php
function sql2table($r,$h){
	if(isset($h)) echo "<h1>$h</h1>";
	echo "<table border=1>";
	$first=true;
	while($row = $r->fetch_assoc()){
		if($first){
			$first=false;
			echo "<tr><th>",implode(array_keys($row),"</th><th>"),"</th></tr>\n";
		}
		echo "<tr><td>",implode($row,"</td><td>"),"</td></tr>\n";
	}
	echo "</table>";
}
require "include/db.php";
sql2table($db->query("SELECT * FROM scrapemetrics ORDER BY date DESC"),"Scrape History");
?>
</body>
</html>