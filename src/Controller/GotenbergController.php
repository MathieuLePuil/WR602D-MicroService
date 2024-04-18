<?php

namespace App\Controller;

use App\Service\GotenbergService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GotenbergController extends AbstractController
{
    private $gotenbergService;

    public function __construct(GotenbergService $gotenbergService)
    {
        $this->gotenbergService = $gotenbergService;
    }

    #[Route('/api/convert', name: 'api_convert', methods: ['POST'])]
    public function apiConvert(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $url = $data['url'] ?? null;

        if (!$url) {
            return new JsonResponse(['error' => 'URL is required'], Response::HTTP_BAD_REQUEST);
        }

        $outputPath = $this->getParameter('kernel.project_dir').'/public/my.pdf';

        try {
            $this->gotenbergService->convertUrlToPdf($url, $outputPath);

            $pdfContent = file_get_contents($outputPath);

            $response = new Response($pdfContent);
            $response->headers->set('Content-Type', 'application/pdf');

            return $response;
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}