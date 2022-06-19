<?php

namespace App\Controller;

class ErrorController extends BaseController
{
    public static function Display(\Exception $e) : string
    {
        $errCtrl = new ErrorController();
        
        switch($e)
        {
            case str_contains($e, '403'):
                return $errCtrl->renderError(null, '403');

            case str_contains($e, '404'):
                return $errCtrl->renderError(null, '404');

            default:
                return $errCtrl->renderError($e->getMessage());
        }
    }
    
    public function renderError(?string $message, string $type = 'runtime') : string
    {
        $data = [ 
            'error_type' => $type,
            'error_str' => $message
        ];

        return $this->render('error.twig', $data);
    }
}