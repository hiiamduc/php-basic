<?php
function array_search_recursive($value,$array)
{
    if(is_array($value))
    {
        $length = count($value);
        $return = array();
        var_dump($value);
        foreach($value as $val1)
        {
            if (count($return) == $length) break;
            foreach($array as $key => $val2)
            {
                if($val1 == $val2)
                {
                    $return[] = $key;
                    break;
                }
            } 
        } 
            return !empty($return) ? $return : false;
    } else {
        foreach($array as $key => $val)
        {
            if($value == $val or (is_array($value) && array_search_recursive($value,$array)!=false))
            {
                return $key;
            }
        }
        return false;
    }
}
