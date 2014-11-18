<?php 
/**
 * Description of Update
 *
 * Check the $_REQUEST and create new instans 
 *
 * @author Hristiyan
 */
require_once './lib/Cv.php';
// Proceed client request
$Request = @$_REQUEST;
if( empty( $Request ) )die;
$Object = @$_REQUEST['PHPobject'];
$Action = @$_REQUEST['PHPaction'];
if( empty($Object) ) { exit; }
unset( $_REQUEST['PHPobject']); 
unset( $_REQUEST['PHPaction']);
$Handle = new $Object();
$Handle->$Action( $_REQUEST );