<?php

namespace App\Controller;

use App\Service\GotenbergService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GotenbergController extends AbstractController
{
    private $gotenbergService;

    public function __construct(GotenbergService $gotenbergService)
    {
        $this->gotenbergService = $gotenbergService;
    }

    #[Route('/convert', name: 'convert')]
    public function convert(): Response
    {
        $url = 'https://sparksuite.github.io/simple-html-invoice-template/';
        $outputPath = $this->getParameter('kernel.project_dir').'/public/my.pdf';

        try {
            $this->gotenbergService->convertUrlToPdf($url, $outputPath);
            return new Response('Conversion réussie.');
        } catch (\Exception $e) {
            return new Response('Conversion non réussie.');
        }


    }
}