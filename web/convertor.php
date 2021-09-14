<?php
ob_end_flush();
use Mpdf\Mpdf;
// Type is something is Used In Pdf (we have row the name of Type in Pdf)
function LibraryPdf($title , $body, $type = null, $confirmDate= null , $number= null){
require_once __DIR__ . '/vendor/autoload.php';

    // Adding font Size and And Our Font in here -----------------------------------------------------------------------
    $mpdf = new Mpdf([
        'tempDir' => __DIR__ . '/tmp',
        'default_font_size' => 10,
        'default_font' => 'iransans',
        'debug' => true,
        'allow_output_buffering' => true
    ]);

    // Set Water Mark Image to our Pdf ---------------------------------------------------------------------------------
    $mpdf -> SetWatermarkImage("images/print-watermark.png", 1);
    $mpdf->showWatermarkImage = true;
    
    // set date happens Here -------------------------------------------------------------------------------------------
    $date = jdate();
    $date1 = $date -> getYear();
    $date2 = $date -> getMonth();
    $date3 = $date -> getDay();
    $date4 = $date1."/".$date2."/".$date3;

    // Important => Our Html Body That contains special Elements and some Css Codes ------------------------------------
    $data ="
        <html lang=\"fa\">
        <head>
            <link rel=\"stylesheet\" media=\"print\" href=\"Css/style.css\" />
            <meta http-equiv=\"Content-Type\" content=\"text/html\"; charset=\"utf-8\" />
            <style>
            @page {
                
                margin-header: 7mm;
                margin-footer: 7mm;
                margin: 8%;
                header: html_Chapter2HeaderEven;
                footer: html_Chapter2FooterOdd;
            }
            </style>
        </head>
        <body style=\"background-image: url(\"print-watermark.png\");\">

        <htmlpageheader name=\"Chapter2HeaderEven\" style=\"display:none\">
            <header  class=\"header\">
                <img src=\"images/1.jpg\" width=\"100%\" />
            </header>
            <p class=\"date-paragraph\">تاریخ چاپ : <br /> $date4</p>
        </htmlpageheader>
            <h3 class=\"h2\">
                <bold>$title</bold>
            </h3>". 

            ($type && $confirmDate && $number ? "<table class=\"headerTableTD\" width=100% dir=\"rtl\">
                <tr>
                    <td>
                        <p>
                            نوع: $type  
                        </p>
                    </td>
                    <td style=\"text-align: center;\">
                        <p>
                            تاریخ تصویب: $confirmDate  
                        </p>
                    </td>
                    <td style=\"text-align: left;\">
                        <p>
                            شماره: $number
                        </p>
                    </td>
                </tr>
            </table>
            ": '').            
            "<div class=\"p\" style=\"direction: rtl;\">
                $body
            </div>
            <htmlpagefooter name=\"Chapter2FooterOdd\" style=\"display:none\">
                <footer class=\"footer\">
                    <img src=\"images/2.jpg\" width=\"100%\" />
                </footer>
            </htmlpagefooter>
        </body>
        </html>
    ";


    // Some Codes Commented That May We need Later ----------------------------------------------------------------
    // $header = "
    // <header  class=\"header\">
    //     <img src=\"1.jpg\" width=\"100%\" />
    // </header>
    // <p class=\"date-paragraph\">تاریخ چاپ :$date4</p>";

    // $mpdf->SetHTMLHeader($header);


    // $mpdf->SetHTMLFooter('
    // <footer class="footer">
    //     <img src="2.jpg" width="100%" />
    // </footer>');

    // Load Our Html -----------------------------------------------------------------------------------------------
    $mpdf->WriteHTML($data);
    ob_end_clean();
    // Store Print -------------------------------------------------------------------------------------------------
    return $mpdf->Output();
}


