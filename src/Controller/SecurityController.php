<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SecurityController extends AbstractController
{
    #[Route('/logout', name: 'app_logout')]
    public function index(): Response
    {
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}