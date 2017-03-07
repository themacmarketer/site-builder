<?php
session_start();
include('core.php');


if($_GET["s"] == "" OR $_GET["s"] == "1")
{
echohead();
// title, favicon, footer & style
if($_SESSION["setup"]["favicon"] != "") $ainfo = " (Leave empty if you dont want to change your favicon. <a href='data:image/x-icon;base64,".$_SESSION["setup"]["favicon"]."' target='_blank'>Show current favicon</a>)";
if($_SESSION["setup"]["style"] != "")
{
 if($_SESSION["setup"]["style"] == "1") $df1 = " checked";
 elseif($_SESSION["setup"]["style"] == "2") $df2 = " checked";
 elseif($_SESSION["setup"]["style"] == "3") $df3 = " checked";
}
echo '<h3>Step 1: Basic Setup</h3><br><b>Attention:</b> This feature is still in <b>Beta</b> and might contain bugs.<br><br><form action="?s=2" method="post" enctype="multipart/form-data">
Select a title for your new website:<br><br>
<b><input name="title" type="text" required="true" class="form-control" placeholder="Something big!" value="'.addslashes(base64_decode($_SESSION["setup"]["title"])).'">
</b><br><br>
Upload a favicon (.ico) for your website'.$ainfo.' (Optional):<br><br>
<input type="file" class="form-control" name="favicon">
<br><br>
Select the style you want to use for your website:<b>
<div class="radio">
  <label><input type="radio" name="optradio" value="1"'.$df1.'>Default (<a href="https://defaultstyle-example.play-them-all.com/index.html">Demo</a>)</label>
</div>
<div class="radio">
  <label><input type="radio" name="optradio" value="2"'.$df2.'>Simple (<a href="https://simplestyle-example.play-them-all.com/index.html">Demo</a>)</label>
</div>
<div class="radio">
  <label><input type="radio" name="optradio" value="3"'.$df3.'>Blank (<a href="https://blankstyle-example.play-them-all.com/index.html">Demo</a>)</label>
</div></b>
<br><br>
<input type="submit" value="Continue" class="btn btn-primary">
</form>';
}
elseif($_GET["s"] == "2")
{
// process
if($_POST["title"] == "" OR $_POST["optradio"] == "") exit("missing values!");
$_SESSION["setup"]["title"] = base64_encode($_POST["title"]);
$_SESSION["setup"]["style"] = $_POST["optradio"];
if($_FILES["favicon"]["tmp_name"] != "") $_SESSION["setup"]["favicon"] = base64_encode(file_get_contents($_FILES["favicon"]["tmp_name"]));

header('Location: ?s=3');
exit;

}
elseif($_GET["s"] == "3")
{
// pages


$page = $_GET["p"];
if($page == "") $page = 0;
if($_POST["title"] != "")
{
$_SESSION["pages"][$page-1]["title"] = base64_encode($_POST["title"]);
$_SESSION["pages"][$page-1]["content"] = base64_encode($_POST["content"]);
if($_GET["done"] == "true")
{
header('Location: /?s=4');
exit;
}
}

if($_SESSION["pages"][$page]["title"] == "")
{
$_SESSION["pages"][$page]["title"] = base64_encode("Title");
$_SESSION["pages"][$page]["content"] = base64_encode("This is a page created using the <b>RunStorage Site Builder</b>.");
}



echohead();
echo '<h3>Step 2: Website Content (Page '.($page+1).': '.base64_decode($_SESSION["pages"][$page]["title"]).')</h3><br>
<form action="?s=3&p='.count($_SESSION["pages"]).'" method="post" id="formk">
<input class="form-control" name="title" placeholder="Enter title" value="'.addslashes(base64_decode($_SESSION["pages"][$page]["title"])).'"><br><br>
<textarea class="form-control" id="editor1">'.base64_decode($_SESSION["pages"][$page]["content"]).'</textarea>
<textarea name="content" style="display:none;" id="content">Text</textarea>
<br>
	    <script type="text/javascript" >
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( \'editor1\' );
            </script>
            
</form>
<br><div class="row">
<div class="col-sm-4">
<div class="form-group">
  <label for="sel1">Open another page:</label>
  <select class="form-control" id="sel1" onchange="window.location = \'/?s=3&p=\' + this.value;">
';
echo '<option value="'.$page.'">Page '.($page+1).' ('.base64_decode($_SESSION["pages"][$page]["title"]).')</option>';
for($i = 0; $i < count($_SESSION["pages"]); $i++)
{
if($i == $page) continue;
echo '<option value="'.$i.'">Page '.($i+1).' ('.base64_decode($_SESSION["pages"][$i]["title"]).')</option>';

}
echo '
  </select>
</div></div>
<div class="col-sm-4">
<div class="form-group">
  <label for="sel2">Create one more page:</label><br>
  <a href="#" onclick="document.getElementById(\'content\').value = CKEDITOR.instances.editor1.getData(); document.getElementById(\'formk\').submit();" id="sel2">Add Page</a>
</div>
</div>
<div class="col-sm-4">
<div class="form-group">
  <label for="sel3">Finish creating/editing pages:</label><bR>
  <a href="#" onclick="document.getElementById(\'content\').value = CKEDITOR.instances.editor1.getData(); document.getElementById(\'formk\').action = \'?s=3&p='.count($_SESSION["pages"]).'&done=true\'; document.getElementById(\'formk\').submit();" id="sel3">Done.</a>
</div>
</div>
</div>';

}
elseif($_GET["s"] == "4")
{
$_SESSION["styles"][1][0] = base64_encode(file_get_contents('styles/style-1.html'));
$_SESSION["styles"][2][0] = base64_encode(file_get_contents('styles/style-2.html'));
$_SESSION["styles"][3][0] = base64_encode(file_get_contents('styles/style-3.html'));
$_SESSION["styles"][1][1] = base64_encode(file_get_contents('styles/menu-1.html'));
$_SESSION["styles"][2][1] = base64_encode(file_get_contents('styles/menu-2.html'));
$_SESSION["styles"][3][1] = base64_encode(file_get_contents('styles/menu-3.html'));

// %SETUP_TITLE %MENU
// %FILENAME %SHOWNAME

$_SESSION["json"] = json_encode($_SESSION);

// config variables
$url = "https://otisoft.sourceforge.io/api/v1/";
 
$data = $_SESSION["json"];
 
// process data & upload with cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain','Content-Length: ' . strlen($data)));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result  = curl_exec($ch);
curl_close($ch);
 
// handle result
$result_object = json_decode($result);
 
$success = $result_object->success;
$file_id = $result_object->file_id;
 
if(!$success) exit("Error: API-Request returned false!");
if($file_id == "") exit("Error: required values missing in result!");
 
$url = "https://lh5.runstorageapis.com/".$file_id;

session_destroy();
echohead();

echo '<h3>Step 3: Download</h3><br>Your website has been created. We recommend hosting the rendered files on RunStorage Cloud because this is the easiest solution you can imagine.<br><br><pre><a href="https://www.runstorage.com/cloud" target="_blank">https://www.runstorage.com/cloud</a></pre>
<br>You can download the sources in our .JSON.PKG format <a href="/download?id='.$file_id.'">here</a>. This file can be re-opened, so you can edit your website later.<br>To publish your site, we can render HTML files for you. To do so, click <a href="/render?id='.$file_id.'">here</a>.<br><br>
<a href="/render?id='.$file_id.'" class="btn btn-primary">Download ZIP</a>';

}
elseif($_GET["s"] == "dl")
{
header("Content-Type: application/json");

header("Content-Disposition: attachment; filename=\"website-".time().".json.pkg\"");
    
echo $_SESSION["json"];

}

?>