<?php 

$mediumJSON = curl("https://medium.com/@ITSriodejaneiro/latest?format=json");
$youtubeJSON = curl("https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId=".YOUTUBE_ID."&key=".YOUTUBE_KEY);

var_dump(json_decode(str_replace('])}while(1);</x>', '', $mediumJSON)));
die;
?>
