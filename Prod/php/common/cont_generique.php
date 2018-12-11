<?php

require_once __DIR__ . "./../verify.php";

class ContGenerique
{
    public function __construct()
    {
    }

    public function afficherErreur($titre, $message)
    {
        $date = date('y_m_d');
        $handle = fopen(__DIR__."./../log/" . $date, "a");
        $this->logToFile($handle, error_get_last(), $titre);
        //header('Location: index.php?module=error&title='.$titre.'&message='.$message);
        exit(0);
    }

    public function logToFile($file, $message, $titre){
        if($file){
            fputs($file, "\n\n");
            fputs($file, "*************************************************\n");
            fputs($file, "Date      :   " . date('dmY G:i:s') . "\n");
            fputs($file, "Titre     :   " . $titre . "\n");
            fputs($file, "Message   :   " . $message['message'] . "\n");
            fputs($file, "File      :   " . $message['file'] . "\n");
            fputs($file, "Line      :   " . $message['line'] . "\n");
            fputs($file, "*************************************************\n");
            fputs($file, "\n\n");
        }
        fclose($file);
    }
}
