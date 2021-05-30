<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
    public function show(Program $program): Response
    {

        $seasons = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findAll();

        if(!$program) {
            throw $this->createNotFoundException(
                'No program with id : ' . $program . ' found in program\'s table'
            );
        }

        return $this->render('program/show.html.twig', ['program' => $program, 'seasons' => $seasons]);
    }

    /**
     * Correspond à la route /programs/{program}/seasons/{season} et au name "program_season_show"
     * @Route("/{program}/seasons/{season}", name="season_show")
     */
    public function showSeason(Program $program, Season $season)
    {
        return $this->render('program/season_show.html.twig', ['program' => $program, 'season' => $season]);
    }

    /**
     * Correspond à la route /programs/{programId}/seasons/{seasonId}/episodes/{episodeId} et au name "program_episode_show"
     * @Route ("/{program}/seasons/{season}/episodes/{episode}", name="episode_show")
     */
    public function showEpisode(Program $program, Season $season, Episode $episode): Response
    {
        return $this->render('program/episode_show.html.twig', ['program' => $program, 'season' => $season,
            'episode' => $episode]);
    }

}
