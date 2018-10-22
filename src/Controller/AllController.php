<?php
namespace App\Controller;

	use App\Entity\Author;
	use App\Entity\Book;

	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\Routing\Annotation\Route;
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\Form\Extension\Core\Type\TextType;
	use Symfony\Component\Form\Extension\Core\Type\SubmitType;

	//use App\Service\SearchFunctions;

	class AllController extends Controller {

		/**
		*@Route("/", name="home")
		*@Method({"GET"})
		*/
		public function index() {
			return $this->render('base.html.twig');
		}

		/**
		*@Route("/search", name="search", options={"expose" = true})
		*@Method({"GET", "POST"})
		*/
		public function search(Request $request) {
			$response = new Response();
			$searchParams = json_decode($request->getContent());
			/*$searchResult = $searchFunctions->searchAuthor('SecondName1');
			$response->setContent($searchFunctions->searchAuthor('SecondName1'));*/
			$repository = $this->getDoctrine()->getRepository(Author::class);
    		$author = $repository->findOneBy([
    			'secondname' => $searchParams[0]]);
			$response = new Response();
			if($author) {
				$result = $author->getId();
				$response->setContent(json_encode($result));
			}
			else {
				$response->setContent('nothing found');
			}
			$response->headers->set('Access-Control-Allow-Origin', '*');
			return $response;
		}


		/**
		*@Route("/api/authorslist", name="getAllAuthors", options={"expose" = true})
		*@Method({"GET"})
		*/
		public function getAllAuthors() {
			$authors = $this->getDoctrine()->getRepository(Author::class)->findAll();
			$authorsArr = array();
			foreach ($authors as $author) {
				$authorsArr[] = $author->toArr();
			}
			$response = new Response();
			$response->setContent(json_encode($authorsArr));
			$response->headers->set('Access-Control-Allow-Origin', '*');
			return $response;
		}

		/**
		*@Route("/api/new", name="createAuthor", options={"expose" = true})
		*Method({"GET", "POST"})
		*/
		public function newA(Request $request) {
			$author = new Author();
			$authorData = json_decode($request->getContent(), true);

			$author->setFirstname($authorData['firstname']);
			$author->setSecondname($authorData['secondname']);
			$entityManager =  $this->getDoctrine()->getManager();
        	$entityManager->persist($author);
        	$entityManager->flush();

			$response = new Response();
			$response->headers->set('Access-Control-Allow-Origin', '*');
			return $response;
		}

		/**
		*@Route("/api/author/{idA}/new", name="createBook", options={"expose" = true})
		*Method({"GET", "POST"})
		*/
		public function newB(Request $request, $idA) {
			$book = new Book();
			$bookData = json_decode($request->getContent(), true);

			$book->setName($bookData['name']);
			$book->setYear($bookData['year']);
			$book->setAuthorid($idA);
			$entityManager =  $this->getDoctrine()->getManager();
        	$entityManager->persist($book);
        	$entityManager->flush();

			$response = new Response();
			$response->headers->set('Access-Control-Allow-Origin', '*');
			return $response;
		}

		/**
     	* @Route("/api/edit/{idA}", name="editAuthor", options={"expose" = true})
     	* Method({"GET", "POST"})
     	*/
    	public function editA(Request $request, $idA) {
    		$author = new Author();
    		$author = $this->getDoctrine()->getRepository(Author::class)->find($idA);
    		if($author) {
    			$newData = json_decode($request->getContent(), true);
    			$author->setFirstname($newData['firstname']);
				$author->setSecondname($newData['secondname']);
				$entityManager = $this->getDoctrine()->getManager();
    			$entityManager->flush();
    		}

    		$response = new Response();
			$response->headers->set('Access-Control-Allow-Origin', '*');
			return $response;
    	}

    	/**
     	* @Route("/api/author/{idA}/edit/{idB}", name="editBook", options={"expose" = true})
     	* Method({"GET", "POST"})
     	*/
    	public function editB(Request $request, $idB, $idA) {
    		$book = new Book();
    		$book = $this->getDoctrine()->getRepository(Book::class)->find($idB);
    		if($book) {
    			$newData = json_decode($request->getContent(), true);
    			$book->setName($newData['name']);
				$book->setYear($newData['year']);
				$entityManager = $this->getDoctrine()->getManager();
    			$entityManager->flush();
    		}

    		$response = new Response();
			$response->headers->set('Access-Control-Allow-Origin', '*');
			return $response;
    	}


		/**
	    * @Route("/api/book/delete/{id}", name="deleteBook", options={"expose" = true})
	    * @Method({"DELETE"})
	    */
	    public function delete(Request $request, $id) {
	    	$book = $this->getDoctrine()->getRepository(Book::class)->find($id);
	    	if($book) {
	    		$entityManager = $this->getDoctrine()->getManager();
	    		$entityManager->remove($book);
	    		$entityManager->flush();
	    	}
	    	$response = new Response();
	    	$response->headers->set('Access-Control-Allow-Origin', '*');
			$response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');

	    	return $response;
	    }

		/**
		*@Route("/api/book/{idB}/formdata", name="formdataBook", options={"expose" = true})
		*@Method({"GET"})
		*/
		public function getFormdataB(Request $request, $idB) {
			$book = new Book();
    		$book = $this->getDoctrine()->getRepository(Book::class)->find($idB);
    		$res = array();
    		$res[] = $book->toArr();
    		$response = new Response();
			$response->setContent(json_encode($res));
			$response->headers->set('Access-Control-Allow-Origin', '*');
			return $response;
		}

		/**
		*@Route("/api/author/{idA}/formdata", name="formdataAuthor", options={"expose" = true})
		*@Method({"GET"})
		*/
		public function getFormdataA(Request $request, $idA) {
			$author = new Author();
    		$author = $this->getDoctrine()->getRepository(Author::class)->find($idA);
    		$res = array();
    		$res[] = $author->toArr();
    		$response = new Response();
			$response->setContent(json_encode($res));
			$response->headers->set('Access-Control-Allow-Origin', '*');
			return $response;
		}

		/**
		*@Route("/api/author/{idA}", name="booksList", options={"expose" = true})
		*/
		public function books($idA) {
			$books = $this->getDoctrine()->getRepository(Book::class)->findBy(['authorid'=>$idA]);

			$author = $this->getDoctrine()->getRepository(Author::class)->find($idA);

			$booksArr = array();
			foreach ($books as $book) {
				$booksArr[] = $book->toArr();
			}

			$booksArr[] = $author->toArr();

			$response = new Response();
			$response->setContent(json_encode($booksArr));
			$response->headers->set('Access-Control-Allow-Origin', '*');
			return $response;
		}
	}