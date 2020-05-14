<?php
require_once RB;

define('DBHOST', 'localhost');
define('DBNAME', 'j977578b_bavky');
define('DBUSER', 'j977578b_bavky');
define('DBPASSWORD', 'Fosypassword1');

R::setup( 'mysql:host=' . DBHOST . ';dbname=' . DBNAME . '',
    DBUSER, DBPASSWORD );