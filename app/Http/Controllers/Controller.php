<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    private $private_key = '6Ld6lNkUAAAAAHNAgT-wdW4E7efCRfwJdWolGRJZ';
    private $url = 'https://www.google.com/recaptcha/api/siteverify';

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
