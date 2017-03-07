<?php
session_start();
include('core.php');
if($_FILES["usrf"]["tmp_name"] != "")
{
$_SESSION = json_decode(file_get_contents($_FILES["usrf"]["tmp_name"]),true);
header('Location: /?s=1');
exit;
}
echohead();
?>
<h3>Open .JSON.PKG file</h3>

Here we allow you to upload .JSON.PKG files to re-open websites you created in the past.<br><br>
<form method="post" enctype="multipart/form-data">

<input class="form-control" type="file" name="usrf">
<br><br>
<input type="submit" value="Open" class="btn btn-primary">
</form>