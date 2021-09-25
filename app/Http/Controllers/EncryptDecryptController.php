<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EncryptDecryptController extends Controller
{
    public function encrypt($string)
    {
		return str_replace(['+','/','='], ['-','_',''], base64_encode($string));
    }
    public function decrypt($string)
    {
    	return base64_decode(str_replace(['-','_'], ['+','/'], $string));
    }
}
