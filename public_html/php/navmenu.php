<?php
/*
    Navigation Menu Configuration

    Testing: 

    GET ./php/navmenu.php?nav=./php/navmenu.txt

    for command line testing with argument:

        php-cgi ./php/navmenu.php nav=./php/navmenu.txt


    Usage:

        // use default navmenu.txt file
        require_once './php/navmenu.php';
*/
$file = './php/navmenu.txt';
if(isset($_REQUEST['nav'])) {
    $file = $_REQUEST['nav'];
} else {
    if(isset($_SESSION['navmenutxt'])) {
       $file = $_SESSION['navmenutxt'];
    }
}
/*
    Navigation Menu Items (navmenu.txt):

    Home,navsel_1
    Stuff,navsel_2
    Other,navsel_3
    About,navsel_4
    Contact,navsel_5

    The specific action(s) taken by a menu item are implemented 
    in assets/js/menu.js.

    See https://github.com/jxmot/website_template-markdown#editing-the-navigation-menu
    for detailed information.
*/
$defaultnav = array('nav 1,navsel_1','nav 2,navsel_2','nav 3,navsel_3','nav 4,navsel_4','nav 5,navsel_5');

if(file_exists($file)) {
    $fileid = fopen($file,'r');

    $navdata = fread($fileid,512);
    fclose($fileid);

    $navitems = explode("\n", $navdata);
} else {
    $navitems = $defaultnav;
}
/*
    At this time the navigation menu is fixed at 5 items with no sub-menus.
*/
?>
                    <ul id="navmenu" class="navbar-nav">
                        <?php $menuitem = explode(',', $navitems[0]); ?>
                        <li class="nav-item"><span id="<?php echo $menuitem[1]; ?>" class="nav-choice nav-pad nav-hover nav-text-pad"><?php echo $menuitem[0]; ?></span></li>
                        <?php $menuitem = explode(',', $navitems[1]); ?>
                        <li class="nav-item"><span id="<?php echo $menuitem[1]; ?>" class="nav-choice nav-pad nav-hover nav-text-pad"><?php echo $menuitem[0]; ?></span></li>
                        <?php $menuitem = explode(',', $navitems[2]); ?>
                        <li class="nav-item"><span id="<?php echo $menuitem[1]; ?>" class="nav-choice nav-pad nav-hover nav-text-pad"><?php echo $menuitem[0]; ?></span></li>
                        <?php $menuitem = explode(',', $navitems[3]); ?>
                        <li class="nav-item"><span id="<?php echo $menuitem[1]; ?>" class="nav-choice nav-pad nav-hover nav-text-pad"><?php echo $menuitem[0]; ?></span></li>
                        <?php $menuitem = explode(',', $navitems[4]); ?>
                        <li class="nav-item"><span id="<?php echo $menuitem[1]; ?>" class="nav-choice nav-hover nav-text-pad"><?php echo $menuitem[0]; ?></span></li>
                    </ul>
