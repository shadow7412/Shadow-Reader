<?php
if(php_sapi_name() != 'cli') echo "<pre>";
//this will probably take a while to execute.
//log in to mysql
require "../include/db.php";
require "feed.class.php";
//Get list of threads from mysql
$result = $db->query("SELECT * FROM `rssfeeds`");
echo $db->error;

//set up prepared query for checking to see if we already have an entry (by using the date and title of the item)

while($row = $result->fetch_assoc()){
//if thread does not update often, and it has been checked recently, skip
  //download rss
  $rss = Feed::loadRss($row['url']);
  //for each rss:
  foreach($rss->item as $item){
  //if the current one exists, break here (move to next feed).
    echo $item->title," - ",date("Y-m-d H:i:s",(int)$item->timestamp),"\n";
  }
}
if(php_sapi_name() != 'cli') echo "</pre>";
?>