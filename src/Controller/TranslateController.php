<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class TranslateController extends AbstractController
{
    #[Route('/translate/{locale}', name: 'app_translate')]
    public function translate($locale, Request $request): Response
    {
       

        $request->getSession()->set('_locale',$locale);
        return $this->redirect($request->headers->get('referer'));
    }
}
