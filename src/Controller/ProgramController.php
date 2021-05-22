<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProgramController
 * @Route ("/programs", name="program_")
 */
Class ProgramController extends AbstractController
{
    /**
     * Correspond à la route /programs/ et au name "program_index"
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('program/index.html.twig', ['website' => 'Wild Séries',]);
    }

    /**
     * Correspond à la route /programs/{id} et au name "program_show"
     * @Route("/{id}/", methods={"GET"}, requirements={"id"="\d+"}, name="show")
     */
    public function show(string $id): Response
    {
        return $this->render('program/show.html.twig', ['id' => $id]);
    }
}
