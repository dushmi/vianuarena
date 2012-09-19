<?php
    // the image
    $print_rating = "Rating: " . $view['rating'];
    $my_img = imagecreate(200, 80);
    $my_img = imagecreatefromjpeg (IA_ROOT_DIR . "www/static/images/widget.jpg");
    $background = imagecolorallocate($my_img, 154, 205, 50);
    $text_color = imagecolorallocate($my_img, 255, 255, 255);
    $rating_value = (int) $view['rating'];
    if($rating_value >= 600) {
        $line_color = imagecolorallocate($my_img, 178, 34, 34);
    } else if ($rating_value >= 520) {
        $line_color = imagecolorallocate($my_img, 255, 255, 0);
    } else {
        $line_color = imagecolorallocate($my_img, 50, 205, 50);
    }
    imagestring($my_img, 3, 15, 42, $view['name'], $text_color);
    imagestring($my_img, 3, 115, 5, $print_rating, $text_color);
    imagestring($my_img, 3, 95, 19, "Succes: " . $view['succes'], $text_color);
    imagestring($my_img, 3, 15, 54, "Probleme rezolvate: " . $view['task_data_succes'], $text_color);
    imagestring($my_img, 3, 15, 65, "Probleme incercate: " . $view['task_data_failed'], $text_color);
    imagesetthickness($my_img, 5);
    imageline($my_img, 0, 38, 200, 38, $line_color);
    header("Content-type: image/png");
    imagepng($my_img);
    imagecolordeallocate($my_img, $line_color);
    imagecolordeallocate($my_img, $text_color);
    imagecolordeallocate($my_img, $background);
    imagedestroy($my_img);
?>
