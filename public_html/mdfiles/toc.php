<?php
/*
    GET toc.php?toc=./content/toc.txt

    for command line testing with argument:

        php-cgi ./toc.php toc=./content/toc.txt


    This will render a simple TOC. It's arranged as 2 rows 
    of 3 columns using Bootstrap 4.

    A text file is read, and parsed into an array of objects,
    where a TOC item menu text and resource pointer (a path to 
    a markdown text file) is stored.

    The contets of the TOC text file look like this - 

README1,./mdfiles/README1.md
README2,./mdfiles/README2.md
README3,./mdfiles/README3.md
README4,./mdfiles/README4.md
README5,./mdfiles/README5.md
README6,./mdfiles/README6.md[EOF]

    Make sure there is no newline at the last character of the
    file. This code is reliant upon that. And does not test for 
    EOF newlines.

*/
// always the same TOC.txt file, edit as needed
$file = './content/toc.txt';
// or pass the desired toc.txt file in a query
if(isset($_REQUEST['toc'])) {
    $file = $_REQUEST['toc'];
}

if(file_exists($file)) {
    $fileid = fopen($file,'r');

    $tocdata = fread($fileid,512);
    fclose($fileid);

    $tocitems = explode("\n", $tocdata);

    // Include the CSS here, all of the "mdtoctable..." classes are there. 
    // The query in the URL is a way to bypass browser and/or server caching 
    // of the CSS file. 
    echo "\n".'<link rel="stylesheet" href="./assets/css/toc.css?_='.time().'"/>'."\n";

    if(($x = count($tocitems)) >= 3) {
        echo '<div id="mdtoctable" class="container mdtoctable-center mdtoctable-width">'."\n";
        echo '    <div class="row row-cols-3">'."\n";
    } else {
        echo '<div id="mdtoctable" class="container mdtoctable-center mdtoctable-narrow">'."\n";
        echo '    <div class="row row-cols-'.$x.'">'."\n";
    }

    $idnum = 1;
    foreach($tocitems as &$item) {
        $menu = explode(',', $item);

        echo '        <div class="col center-text">'."\n";
        echo '            <span id="toc_'.$idnum.'" data-mdfile="'.$menu[1].'" class="toc-item toc-font nav-hover nav-text-pad">'.$menu[0].'</span>'."\n";
        echo "        </div>\n";

        if(($idnum === 3) && (count($tocitems) > $idnum)) {
            echo "    </div>\n";
            echo '    <div class="row">'."\n";
        }

        $idnum += 1;
    }
    // break the reference with the last element
    unset($item); 

    echo "    </div>\n";
    echo "</div>\n";

    echo '<div id="mdfont-ctrls" class="text-center" style="display:none;">'."\n";
    echo "    <h4>Choose Font Below:</h4>\n";
    echo '    <div id="mdfontsel" class="mdtoggle">'."\n";
    echo '        <h4 id="mdfont_a" class="mdfont_item mdfont-active">&nbsp;A&nbsp;</h4>&nbsp;<h4 id="mdfont_b" class="mdfont_item mdfont-inactive nav-hover">&nbsp;B&nbsp;</h4>'."\n";
    echo "    </div>\n";
    echo "</div>\n";

    echo '<div id="pdfout-ctrls" class="text-center" style="display:none;">'."\n";
    echo "    <br>\n";
    echo "    <h4>Save this as a PDF?</h4>\n";
    echo '    <button id="topdfbtn" type="button" class="btn btn-info btn-sm">Save PDF</button>'."\n";
    echo "</div>\n";

} else {
    echo "<h1>TOC File was not found - {$file}</h1>\n";
}
?>