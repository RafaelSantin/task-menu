<?php

namespace App\Http\Utils;
use Illuminate\Support\Facades\Log;

Class GeneralUtils 
{
	

    public static function getDepthArray($array, $max_depth, $depth = null){    

    	if(is_null($depth))
    	{
    		$depth = 1;
    	}		
        foreach ($array as $value) {
            if (isset($value['children']) && !empty($value['children']))
            {
                $depth = self::getDepthArray($value['children'],$max_depth, $depth + 1);
            }
        }

    	
    	return !empty($depth) ? $depth : 0 ;

    }

}