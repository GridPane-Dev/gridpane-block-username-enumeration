<?php
if (!is_admin() && isset($_REQUEST['author'])) {
	status_header(404);
	die();
}

