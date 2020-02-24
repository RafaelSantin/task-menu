<?php

namespace App\Http\Utils;

Class GeneralUtils 
{
	public $depth = 1 ;
    public static function verifyDepth(array $array, $max_depth){    

    	if (isset($array['children']) && !empty($array['children']))
    	{
    		$depth++;
    		self::verifyDepth($array['children']);
    	}

    	return $depth;

    }

}