<?php
    function checkArrayForKeys($keys, $array)
    {
        foreach ($keys as $key) {
            if (!isset($array[$key]) || $array[$key] === false) {
                return false;
            }
        }

        return true;
    }

    function associativeToNumArray($keysOrder, $array)
    {
        $value_array = array();

        foreach ($keysOrder as $key) {
            array_push($value_array, $array[$key]);
        }
        
        return $value_array;
    }


    function randomString($length)
    {
        $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    
        $strlength = strlen($characters);
        
        $random = '';
        
        for ($i = 0; $i < $length; $i++) {
            $random .= $characters[rand(0, $strlength - 1)];
        }
    
        return $random;
    }


    //Retourne la valeur se trouvant dans l'indice de recherche
    //Sinon retourne la valeur notFoundValue
    //Le tableau doit être multiDimensionnel
    function includesAt($multiDimArray, $searchIndex, $resultIndex, $search, $notFoundValue = false)
    {
        if (is_array($multiDimArray) && count($multiDimArray) > 0 &&  is_array($multiDimArray[0])) {
            foreach ($multiDimArray as $arr) {
                if ($arr[$searchIndex] == $search) {
                    return $arr[$resultIndex];
                } else {
                    echo $arr[$searchIndex];
                }
            }
        }

        return $notFoundValue;
    }


    function ExceptionHandler($e){
        $date = date('y_m_d');
        $handle = fopen(__DIR__."./../log/" . $date, "a");
        logToFile($handle, $e);
        echo $e->getMessage();
    }

    function logToFile($file, $message){
        if($file){
            fputs($file, "\n\n");
            fputs($file, "*************************************************\n");
            fputs($file, "Date      :   " . date('dmY G:i:s') . "\n");
            fputs($file, "Message   :   " . $message->getMessage() . "\n");
            fputs($file, "File      :   " . $message->getFile() . "\n");
            fputs($file, "Line      :   " . $message->getLine() . "\n");
            fputs($file, "*************************************************\n");
            fputs($file, "\n\n");
        }
        fclose($file);
    }

    set_exception_handler('ExceptionHandler');