#!/bin/bash
php -r '
echo "\n ..::Tainacan Theme::..\n";

echo "\nInitiating the installation with composer ... please wait!!\n";
echo "Copying files ...\n";

echo "\nCopying Bootstrap Framework ...\n\n";

    if (!file_exists("src/assets/vendor/bootstrap")) { 
        mkdir("src/assets/vendor/", 0777, true);
        mkdir("src/assets/vendor/bootstrap/", 0777, true); 
        mkdir("src/assets/vendor/bootstrap/scss", 0777, true); 
        mkdir("src/assets/vendor/bootstrap/js", 0777, true); 
    }
    recurse_copy("vendor/twbs/bootstrap/scss", "src/assets/vendor/bootstrap/scss");
    copy("vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js", "src/assets/vendor/bootstrap/js/bootstrap.min.js");
    recurse_copy("vendor/twbs/bootstrap/js/src", "src/assets/vendor/bootstrap/js/src");

echo "Copying Slick Slider...\n\n";
    if (!file_exists("src/assets/vendor/slick")) {
        mkdir("src/assets/vendor/slick/", 0777, true);
        mkdir("src/assets/vendor/slick/css", 0777, true);
        mkdir("src/assets/vendor/slick/js", 0777, true);
        mkdir("src/assets/vendor/slick/fonts", 0777, true);
    }
    recurse_copy("vendor/fabianobn/slick/slick/", "src/assets/vendor/slick/");
    
echo "Finished copying files! \n\n";

function recurse_copy($src,$dst) {
    $dir = opendir($src);
    @mkdir($dst);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != "." ) && ( $file != ".." )) {
            if ( is_dir($src . "/" . $file) ) {
                recurse_copy($src . "/" . $file,$dst . "/" . $file);
            }
            else {
                copy($src . "/" . $file,$dst . "/" . $file);
            }
        }
    }
    closedir($dir);
}

function delete_files($target) {
    if(is_dir($target)){
        $files = glob( $target . "*", GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

        foreach( $files as $file ){
            delete_files( $file );
        }

        rmdir( $target );
    } elseif(is_file($target)) {
        unlink( $target );
    }
}
'