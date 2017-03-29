<?php

function genid() {
    
    $id = md5(uniqid(rand(),true));
    return substr($id,0,8);

}

$data = file_get_contents('https://lh5.runstorageapis.com/'.$_GET["id"]);

$a = json_decode($data,true);

$title = $a["setup"]["title"];
$favicon = base64_decode($a["setup"]["favicon"]);
$sstyle = $a["setup"]["style"];

$style = base64_decode($a["styles"][$sstyle][0]);
$menu = base64_decode($a["styles"][$sstyle][1]);

// generate headers
// first the menu

$m = "";

foreach($a["pages"] as $key => $value)
{
    
    $a["pages"][$key]["file"] = $key."-".genid().".html";
    if($key == 0) $a["pages"][$key]["file"] = "index.html";
    $mm = str_replace('%FILENAME',$a["pages"][$key]["file"],$menu);
    $m .= str_replace('%SHOWNAME', base64_decode($value["title"]),$mm);

}

$h = str_replace('%SETUP_TITLE', base64_decode($title), $style);
$h = str_replace('%MENU', $m, $h);

// generate files

// --- PUT YOUR TEMP DIR HERE ---
$temp = "/temp";
// ------------------------------

$zip = new ZipArchive();
$filename = $temp."/website-".genid().".zip";

if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
    exit("cannot open <$filename>\n");
}

$zip->addFromString("favicon.ico" , $favicon);
$zip->addFromString("website-source.json.pkg" , $data);

foreach($a["pages"] as $value)
{
        $dat = $h."<h2>".base64_decode($value["title"])."</h2><br>".base64_decode($value["content"]);
        $dat = str_replace("\n","",$dat);
        $zip->addFromString($value["file"] , $dat);
}

$zip->close();

// set headers
header("Content-Type: application/zip");
header("Content-Disposition: attachment; filename=\"website-".genid().".zip\"");
echo file_get_contents($filename);

// remove temp file
unlink($filename);
?>
