<?php

require_once __DIR__ . "./../verify.php";

class ContGenerique
{
    public function __construct()
    {
    }

    public function afficherErreur($titre, $message)
    {
        //header('Location: index.php?module=error&title='.$titre.'&message='.$message);
        echo $message;
        exit(0);
    }

}
