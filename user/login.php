<?php
require_once 'assets/scripts/data.php';
if (isset($_SESSION['userid']) && isset($_SESSION['email']) && isset($_SESSION['type'])) {
	if (isset($_SESSION['go_to_url'])) {
		$url = $_SESSION['go_to_url'];
		unset($_SESSION['go_to_url']);
		redirect($url);
	}else{
		if ($_SESSION['type'] == 'admin') {
			redirect("dashboard");
		}elseif ($_SESSION['type'] == 'nigerian' || $_SESSION['type'] == 'sec_school' || $_SESSION['type'] == 'RUN' || $_SESSION['type'] == 'virtual' || $_SESSION['type'] == 'foreign') {
			redirect("home");
		}else{
			redirect("../signin");
		}
	}
}else{
	redirect("../signin");
}
?>