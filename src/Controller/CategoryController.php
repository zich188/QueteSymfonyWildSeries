<?php


namespace App\Controller;


use App\Entity\Category;
use App\Entity\Program;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;
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
     * The controller for the category add form
     * Correspond à la route /categories/new et au name "category_new"
     * @Route("/new", name="new")
     */
    public function new(Request $request) : Response
    {
        // Create a new Category Object
        $category = new Category();
        // Create the associated Form
        $form = $this->createForm(CategoryType::class, $category);
        // Render the form
        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted()) {
            // Deal with the submitted data
            // For example : persiste & flush the entity
            // And redirect to a route that display the result
            $entityManager = $this->getDoctrine()->getManager();
            // Persist Category Object
            $entityManager->persist($category);
            // Flush the persisted object
            $entityManager->flush();
            // Finally redirect to categories list
            return $this->redirectToRoute('category_index');
        }
        return $this->render('category/new.html.twig', [
            "form" => $form->createView(),
        ]);
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