<?php
function generateRandomString($length = 12) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomIndex = random_int(0, $charactersLength - 1); // امن و مناسب رمز عبور
        $randomString .= $characters[$randomIndex];
    }
    return $randomString;
}
?>