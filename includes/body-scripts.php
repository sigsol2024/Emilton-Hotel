<?php
/**
 * Body Scripts
 * Output custom scripts right after opening <body> tag
 */

if (function_exists('getSiteSetting')) {
    $bodyScripts = getSiteSetting('body_scripts', '');
    if (!empty($bodyScripts)) {
        echo "\n<!-- Custom Body Scripts -->\n";
        echo $bodyScripts . "\n";
    }
}
?>


