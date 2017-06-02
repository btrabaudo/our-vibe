<?php
require "cloudinary.php" ;
require "api.php" ;
$api = new \Cloudinary\Api();
$result = $api->resources();
