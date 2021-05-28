<?php


namespace App\Controller;


use App\Entity\Category;
use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoryController
 * @Route ("/categories", name="category_")
 */
class CategoryController extends AbstractController
{
    /**
     * Correspond à la route /categories/ et au name "category_index"
     * @Route ("/", name="index")
     * @return Response
     */
    public function index() : Response
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();
        return $this->render('category/index.html.twig', ['categories' => $categories]);
    }

    /**
     * Correspond à la route /categories/{categoryName} et au name "category_show"
     * @Route ("/{categoryName}/", methods={"GET"}, name="show")
     */
    public function show(string $categoryName): Response
    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findoneBy(['name' => $categoryName]);

        if(!$category) {
            throw $this->createNotFoundException(
                'No category with categoryName : ' . $categoryName . ' found in category\'s table'
            );
        }

        $categoryShow = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(['category' => $category->getId()], ['id' => 'DESC'],3);


        return $this->render('category/show.html.twig', ['category' => $category, 'showByCategories' => $categoryShow]);
    }
}