<?php
namespace App\Controller;

	use App\Entity\Author;
	use App\Entity\Book;

	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\Routing\Annotation\Route;
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\Form\Extension\Core\Type\TextType;
	use Symfony\Component\Form\Extension\Core\Type\SubmitType;

	class AllController extends Controller{
		/**
		*@Route("/", name="home")
		*@Method({"GET"})
		*/

		public function index() {
			$authors = $this->getDoctrine()->getRepository(Author::class)->findAll();
			return $this->render('index.html.twig', array('authors' => $authors));
		}

		/**
		*@Route("/new")
		*Method({"GET", "POST"})
		*/
		public function newA(Request $request) {
			$author = new Author();

			$form = $this->createFormbuilder($author)->
				add('firstname', TextType::class, array('attr' => array('class' => 'form-control')))
				->add('secondname', TextType::class, array('attr' => array('class' => 'form-control')))
				->add('save', SubmitType::class, array('label'=>'Создать', 'attr'=> array('class' =>'btn btn-success mt-3')))
				->getForm();

			$form->handleRequest($request);

			if($form->isSubmitted() && $form->isValid()) {
				$author = $form->getData();
				$entityManager =  $this->getDoctrine()->getManager();
        		$entityManager->persist($author);
        		$entityManager->flush();

        		return $this->redirectToRoute('home');
			}

			return $this->render('new.html.twig', array('form' => $form->createView()));
		}

		/**
		*@Route("/author/{idA}/new")
		*Method({"GET", "POST"})
		*/
		public function newB(Request $request, $idA) {
			$book = new Book();

			$form = $this->createFormbuilder($book)->
				add('name', TextType::class, array('attr' => array('class' => 'form-control')))
				->add('year', TextType::class, array('attr' => array('class' => 'form-control')))
				->add('save', SubmitType::class, array('label'=>'Создать', 'attr'=> array('class' =>'btn btn-success mt-3')))
				->getForm();

			$form->handleRequest($request);

			if($form->isSubmitted() && $form->isValid()) {
				$book = $form->getData();
				$book->setAuthorid($idA);
				$entityManager =  $this->getDoctrine()->getManager();
        		$entityManager->persist($book);
        		$entityManager->flush();

        		return $this->redirectToRoute('authorBooks', ['idA'=>$idA]);
			}

			return $this->render('new.html.twig', array('form' => $form->createView()));
		}

		/**
     	* @Route("/edit/{idA}", name="editAuthor")
     	* Method({"GET", "POST"})
     	*/
    	public function editA(Request $request, $idA) {
    		$author = new Author();
    		$author = $this->getDoctrine()->getRepository(Author::class)->find($idA);
    		$form = $this->createFormBuilder($author)
	    		->add('firstname', TextType::class, array('attr' => array('class' => 'form-control')))
	    		->add('secondname', TextType::class, array('attr' => array('class' => 'form-control')))
	    		->add('save', SubmitType::class, array('label' => 'Изменить', 'attr' => array('class' => 'btn btn-success mt-3')))
	    		->getForm();

    		$form->handleRequest($request);

    		if($form->isSubmitted() && $form->isValid()) {
    			$entityManager = $this->getDoctrine()->getManager();
    			$entityManager->flush();

    			return $this->redirectToRoute('home');
    		}
    		return $this->render('edit.html.twig', array('form' => $form->createView()));
    	}

    	/**
     	* @Route("/author/{idA}/edit/{idB}", name="editBook")
     	* Method({"GET", "POST"})
     	*/
    	public function editB(Request $request, $idB, $idA) {
    		$book = new Book();
    		$book = $this->getDoctrine()->getRepository(Book::class)->find($idB);
    		$form = $this->createFormBuilder($book)
	    		->add('name', TextType::class, array('attr' => array('class' => 'form-control')))
	    		->add('year', TextType::class, array('attr' => array('class' => 'form-control')))
	    		->add('save', SubmitType::class, array('label' => 'Изменить', 'attr' => array('class' => 'btn btn-success mt-3')))
	    		->getForm();

    		$form->handleRequest($request);

    		if($form->isSubmitted() && $form->isValid()) {
    			$entityManager = $this->getDoctrine()->getManager();
    			$entityManager->flush();

    			return $this->redirectToRoute('authorBooks', ['idA'=>$idA]);
    		}
    		return $this->render('edit.html.twig', array('form' => $form->createView()));
    	}


		 /**
	     * @Route("/book/delete/{id}")
	     * @Method({"DELETE"})
	     */
	    public function delete(Request $request, $id) {
	    	$book = $this->getDoctrine()->getRepository(Book::class)->find($id);
	    	$entityManager = $this->getDoctrine()->getManager();
	    	$entityManager->remove($book);
	    	$entityManager->flush();
	    	$response = new Response();
	    	$response->send();
	    }


		/**
		*@Route("/author/{idA}", name="authorBooks")
		*/
		public function books($idA) {
			$books = $this->getDoctrine()->getRepository(Book::class)->findBy(['authorid'=>$idA]);

			$author = $this->getDoctrine()->getRepository(Author::class)->find($idA);

			return $this->render('books.html.twig', array('books' => $books, 'author' => $author));
		}
	}