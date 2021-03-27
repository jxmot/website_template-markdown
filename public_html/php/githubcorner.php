<?php
/*
    https://github.com/jxmot/github-corners-php


    githubcorner.php - A wrapper around some HTML/CSS that will 
    render a corner icon with an octocat in it. It is also a link
    to a specified GitHub repository.

    The HTML/CSS code was originally found at - 

        https://github.com/tholman/github-corners

    And has been modified to have the following features:

        * Configurable via a text file - 
            * corner side
            * background color
            * foreground color
            * CSS file
            * target repo
            * link title

    Usage:

        Neccessary files:
            * githubcorner.php (this file)
            * githubcorner.css (styling)
            * githubcorner.txt (configuration)

        NOTE: All "paths" to files are relative to where
        this file is required by its host-file.

        PHP - 

            // specifiy a config file
            $_SESSION['ghccfg'] = './githubcorner.txt'; 
            require_once './githubcorner.php'; 


            // specifiy a different config file
            $_SESSION['ghccfg'] = './someother.txt'; 
            require_once './githubcorner.php'; 


            // use the default config file
            require_once './githubcorner.php'; 


            // use the default config file, but over-ride
            // the colors
            $_SESSION['ghcfill'] = 'black'; 
            $_SESSION['ghccolor'] = '#00ff00'; 
            require_once './githubcorner.php'; 


            // specifiy a config file, and over-ride
            // the colors
            $_SESSION['ghccfg'] = './githubcorner.txt'; 
            $_SESSION['ghcfill'] = 'black'; 
            $_SESSION['ghccolor'] = '#00ff00'; 
            require_once './githubcorner.php'; 

*/

// get the config file name...
$file = './githubcorner.txt';
if(isset($_SESSION['ghccfg'])) {
   $file = $_SESSION['ghccfg'];
}

// default values, used if there is no 
// config file present
$css = './githubcorner.css';
$side = 'right';
$fill = 'purple';
$color = 'white';
$repo = 'https://github.com/';
$linkmsg = 'View source on GitHub';

// read the config file if it exists, otherwise
// use the defaults from above.
if(file_exists($file)) {
    $fileid = fopen($file,'r');
    $ghcdata = fread($fileid,128);
    fclose($fileid);

    list($css,$side,$fill,$color,$repo,$linkmsg) = explode(',', $ghcdata);
}

/*
    Over-ride settings in githubcorner.txt or 
    the defaults.
*/
if(isset($_SESSION['ghccss'])) {
    $css = $_SESSION['ghccss'];
    unset($_SESSION['ghccss']);
}

if(isset($_SESSION['ghcside'])) {
    $side = $_SESSION['ghcside'];
    unset($_SESSION['ghcside']);
}

if(isset($_SESSION['ghcfill'])) {
    $fill = $_SESSION['ghcfill'];
    unset($_SESSION['ghcfill']);
}

if(isset($_SESSION['ghccolor'])) {
    $color = $_SESSION['ghccolor'];
    unset($_SESSION['ghccolor']);
}

if(isset($_SESSION['ghcrepo'])) {
    $repo = $_SESSION['ghcrepo'];
    unset($_SESSION['ghcrepo']);
}

if(isset($_SESSION['ghcmsg'])) {
    $linkmsg = $_SESSION['ghcmsg'];
    unset($_SESSION['ghcmsg']);
}

// this will over-ride any CSS class influence
$stylebg = 'style="fill:'.$fill.'!important;"';
$styleco = 'color:'.$color.'!important;';
$stylefg = 'style="color:'.$color.'!important;"';
?>
<!-- octocat in the corner 

    The code below is NOT the common code you
    find in their repo. This has been retrieved
    from a pull request, the change made causes
    the active area of the link to be a triangle
    and not a square that went beyond the icon.

    https://github.com/tholman/github-corners/pull/41

-->
                <link rel="stylesheet" href="<?php echo $css; ?>"/>
                <svg class="github-corner-svg-<?php echo $side; ?> github-corner-svg" width="80" height="80" viewBox="0 0 250 250" aria-hidden="true">
                    <a href="<?php echo $repo; ?>" target="_blank" class="github-corner-link github-corner" <?php echo $stylebg; ?> title="<?php echo $linkmsg; ?>">
                        <path d="M0,0 L115,115 L130,115 L142,142 L250,250 L250,0 Z"></path>
                        <path fill="currentColor" class="octo-arm" style="transform-origin: 130px 106px; <?php echo $styleco; ?>" d="M128.3,109.0 C113.8,99.7 119.0,89.6 119.0,89.6 C122.0,82.7 120.5,78.6 120.5,78.6 C119.2,72.0 123.4,76.3 123.4,76.3 C127.3,80.9 125.5,87.3 125.5,87.3 C122.9,97.6 130.6,101.9 134.4,103.2"></path>
                        <path fill="currentColor" <?php echo $stylefg; ?> d="M115.0,115.0 C114.9,115.1 118.7,116.5 119.8,115.4 L133.7,101.6 C136.9,99.2 139.9,98.4 142.2,98.6 C133.8,88.0 127.5,74.4 143.8,58.0 C148.5,53.4 154.0,51.2 159.7,51.0 C160.3,49.4 163.2,43.6 171.4,40.1 C171.4,40.1 176.1,42.5 178.8,56.2 C183.1,58.6 187.2,61.8 190.9,65.4 C194.5,69.0 197.7,73.2 200.1,77.6 C213.8,80.2 216.3,84.9 216.3,84.9 C212.7,93.1 206.9,96.0 205.4,96.6 C205.1,102.4 203.0,107.8 198.3,112.5 C181.9,128.9 168.3,122.5 157.7,114.1 C157.9,116.9 156.7,120.9 152.7,124.9 L141.0,136.5 C139.8,137.7 141.6,141.9 141.8,141.8 Z"></path>
                    </a>
                </svg>
 