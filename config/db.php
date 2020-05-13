<?php
require_once RB;

define('DBHOST', 'localhost');
define('DBNAME', 'bavky');
define('DBUSER', 'root');
define('DBPASSWORD', '');

R::setup( 'mysql:host=' . DBHOST . ';dbname=' . DBNAME . '',
    DBUSER, DBPASSWORD );