<?php

$base_url = 'https://realrussia.co.uk/';

$conn = new mysqli("localhost","rr_wp_user","m%dA3sEj?:D=","rr_wp");

// Check connection

if ($conn -> connect_errno) {

  echo "Failed to connect to MySQL: " . $conn -> connect_error;

  exit();

}