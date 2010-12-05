<?php

function yield($template = 'template') {
	global $response; // temporary hack
	return $response -> storage[$template];
}

?>
