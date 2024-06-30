<?php
if (!class_exists('MyDB')) {
  class MyDB extends SQLite3
  {
      function __construct()
      {
          $this->open(__DIR__ . '/../database/Pastelaria.db');
      }
  }
}


$db = new MyDB();
if (!$db) {
  echo $db->lastErrorMsg();
}

$conn = $db;