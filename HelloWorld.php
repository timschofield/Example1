<?php

include('includes/session.inc');

$Title = _('Hello World');

include('includes/header.inc');

echo '<p class="page_title_text noPrint" ><img src="'.$RootPath.'/css/'.$Theme.'/images/user.png" width="24px" title="' . _('Hello World') . '" alt="" />' . _('Hello World') . '</p>';

if (isset($_POST['Submit'])) {
	/* Get clients IP address */
	$IPAddress = $_SERVER['REMOTE_ADDR'];

	/* Has user been here before? */
	$SQL = "SELECT count(name) as names
				FROM helloworld
				WHERE name='" . $_POST['Name'] . "'
					AND ipaddress='" . $IPAddress . "'";
	$Result = DB_query($SQL, $db);
	$MyRow = DB_fetch_array($Result);
	if ($MyRow['names'] > 0) {
		prnMsg( _('Welcome back') . ' ' . $_POST['Name'], 'info');
	} else {
		$SQL = "INSERT INTO helloworld (ipaddress,
										name)
									VALUES (
										'" . $IPAddress . "',
										'" . $_POST['Name'] . "'
									)";
		$Result = DB_query($SQL, $db);
		prnMsg( _('Hi') . ' ' . $_POST['Name'], 'info');
	}
} else {
	echo '<div class="page_help_text noPrint">' . _('Enter your name in the box below.') . '</div>';
	echo '<form enctype="multipart/form-data" action="' . htmlspecialchars($_SERVER['PHP_SELF'],ENT_QUOTES,'UTF-8') . '" method="post" class="noPrint">';
	echo '<input type="hidden" name="FormID" value="' . $_SESSION['FormID'] . '" />';
	echo '<div class="centre">
			<input type="text" name="Name" />
		</div>
		<div class="centre">
			<input type="submit" name="Submit" value="Submit" />
		</div>';
	echo '</form>';
}

include('includes/footer.inc');

?>