<?php 
/*
    GET pdfheading.php?doc=./mdfiles/content/loremispsum.md

    for command line testing with argument:

        php-cgi ./pdfheading.php doc=./mdfiles/content/loremispsum.md

    This will provide rendered HTML piece that can be used as a page 
    heading or footer(works best) in the PDF file.

    This piece will contan:

        * The website server, "www.example.com"
        * The copyright of the file, the file's creation date is
          read and the year is placed in the heading
        * The name of the original file with the ".md" extension

    Use the following to alter the creation date of any file using
    the Windows 10 Powershell - 

    Win 10 powershell commands:

        View properties of a file - 
            Get-ItemProperty -Path pastlorem.md | Format-list -Property * -Force

        Set the creation date of a file - 
            $(Get-Item pastlorem.md).creationtime=$("01/01/2002 00:01 am")

        Set the modification date of a file - 
            $(Get-Item pastlorem.md).lastwritetime=$("01/01/2002 00:01 am")

    The variable `$filecyear` will will be "2002" when this script is executed on
    the file `pastlorem.md`.

    On Linux, change the date with this command - 

        touch -d 20020101 pastlorem.md
*/
$filecyear = '';
$file = '';
// get the file name and the creation date of the file that 
// was passed in the query
if(isset($_REQUEST['doc'])) {
    $file = array_pop(explode('/', $_REQUEST['doc']));
    //$filecyear = date('Y', filectime('./content/'.$file));
    $filecyear = date('Y', filemtime('./content/'.$file));
} else {
    echo "\n<h1>ERROR - missing query to specify file</h1>\n";
}
?>

<div class="pdfhead-respv">
    <table class="pdfhead">
        <tbody>
            <tr>
                <td><?php echo $_SERVER['SERVER_NAME']; ?></td>
                <td>&copy;&nbsp;<?php echo $filecyear ?></td>
                <td><?php echo $file; ?></td>
            </tr>
        </tbody>
    </table>
</div>
