<?php

while( list( $field, $value ) = each( $_POST )) {

	echo $field . ": " . $value . "<br />";

}
?>