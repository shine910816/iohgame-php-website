<?php
function badImage()
{
    $im = imagecreatetruecolor(190, 190);
    $co = imagecolorallocatealpha($im, 255, 255, 255, 127);
    imagefill($im, 0, 0, $co);
    imagepng($im);
    imagedestroy($im);
}
header("Content-type:image/png");
if (isset($_GET["person"])) {
    $url = "https://ak-static.cms.nba.com/wp-content/uploads/headshots/nba/latest/260x190/" . $_GET["person"] . ".png";
    $url_header = get_headers($url);
    if (strpos($url_header[0], "200 OK") === false) {
        badImage();
    } else {
        $file_content = file_get_contents($url);
        //$thumb = imagecreate(190, 190);
        $thumb = imagecreatetruecolor(190, 190);
        $co = imagecolorallocatealpha($thumb, 255, 255, 255, 127);
        imagefill($thumb, 0, 0, $co);
        $source = imagecreatefromstring($file_content);
        imagecopy($thumb, $source, 0, 0, 35, 0, 190, 190);
        imagepng($thumb);
        imagedestroy($source);
        imagedestroy($thumb);
    }
} else {
    badImage();
}
?>