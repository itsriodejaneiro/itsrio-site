<?php 
file_put_contents(realpath(dirname(__FILE__)).'/markers.json', $_POST['markers']);
var_dump(realpath(dirname(__FILE__)).'/markers.json');

