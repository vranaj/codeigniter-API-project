<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pdf {

    function pdf_create($html_file_name, $pdf_file_name, $html_data) {
        //Folders where the files will be created/located
        $document_root = $_SERVER['DOCUMENT_ROOT'];
        //$wkhtmltopdf_path = $document_root . '/ualpms_1_3_0/utilities/wkhtmltopdf/wkhtmltopdf';

        $wkhtmltopdf_path = '"C:/Program Files/wkhtmltopdf/bin/wkhtmltopdf.exe"';
        //$wkhtmltopdf_path = "/usr/local/bin/wkhtmltopdf";

        $pdf_path = $document_root . '/uaprocurement/utilities/pdf/';

        //Generate the folder path with file name
        $html_file_path = $pdf_path . $html_file_name;
        $pdf_file_path = $pdf_path . $pdf_file_name;
        //print_r($html_file_path);
        //print_r($pdf_file_path);
       // print_r($html_data);die();
        //Create the temporary HTML file to be converted to PDF
        if (!write_file($html_file_path, $html_data, 'w+')) {
            echo 'Unable to write to file';
        }

        //Create the PDF File
        passthru("$wkhtmltopdf_path $html_file_path $pdf_file_path");

        //Delete the temporary HTML file
        unlink($html_file_path);

        //Retrun the PDF file Path
        return $pdf_file_path;
    }

    function make_pdf($html_full_path, $html_data, $pdf_full_path) {
        //Folders where the files will be created/located
        //$document_root = $_SERVER['DOCUMENT_ROOT'];
        //$wkhtmltopdf_path = $document_root . '/uaprocurement/utilities/wkhtmltopdf/wkhtmltopdf';
        $wkhtmltopdf_path = '"C:/Program Files/wkhtmltopdf/bin/wkhtmltopdf.exe"';
        //$wkhtmltopdf_path = "/usr/local/bin/wkhtmltopdf";

        //$pdf_path = $document_root . '/uaprocurement/utilities/pdf/';
        //Generate the folder path with file name
        //$html_file_path = $pdf_path . $html_file_name;
        //$pdf_file_path = $pdf_path . $pdf_file_name;
        //Create the temporary HTML file to be converted to PDF
        if (!write_file($html_full_path, $html_data, 'a+')) {
            return FALSE;
        }
        //Create the PDF File
        passthru("$wkhtmltopdf_path $html_full_path $pdf_full_path");

        //Delete the temporary HTML file
        unlink($html_full_path);

        //Retrun the PDF file Path
        return $pdf_full_path;
    }

}
