<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RecordRepository;


class DataController extends AbstractController
{
    /**
     * @Route("/", name="data")
     */
    public function index(Request $request, RecordRepository $recordRepository): Response
    {
        
        dump(
            $recordRepository->getNotExistingRecords($request->query->get('ident')),
            $recordRepository->getUpdatedRecords($request->query->get('ident'), $request->query->get('version')),
            $recordRepository->getNotFilledRecords($request->query->get('ident'))
        );exit;
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/DataController.php',
        ]);
    }
}
