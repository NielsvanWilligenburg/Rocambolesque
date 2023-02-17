<?php

include_once(APPROOT . '/views/includes/header.php');
$data = $data ?? [];

if (isset($_SESSION['id'])) {
	var_dump($_SESSION);
}
?>


<?php

include_once(APPROOT . '/views/includes/footer.php');

?>