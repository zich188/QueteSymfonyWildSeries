<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Program;
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
     * @return Response A response instance
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();
        return $this->render('program/index.html.twig', ['programs' => $programs]);
    }

    /**
     * Correspond à la route /programs/{id} et au name "program_show"
     * @Route("/{id}/", methods={"GET"}, requirements={"id"="\d+"}, name="show")
     */
    public function show(int $id): Response
    {
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['id' => $id]);

        if(!$program) {
            throw $this->createNotFoundException(
                'No program with id : ' . $id . ' found in program\'s table'
            );
        }

        return $this->render('program/show.html.twig', ['program' => $program]);
    }
}
