<?php

    	function __autoload( $className ) {
  $className = str_replace( "..", "", $className );
  require_once( "classes/$className.php" );
  echo "Loaded classes/$className.php<br>";
}
$member = new Member();
echo "Создан обьект: ";

?>
