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

	class AllController extends Controller {

		/**
		*@Route("/", name="home")
		*@Method({"GET"})
		*/
		public function index() {
			return $this->render('base.html.twig');
		}

		/**
		*@Route("/search", name="search")
		*@Method({"GET", "POST"})
		*/
		public function search(Request $request) {
			$searchParams = $request->getContent();
			$repository = $this->getDoctrine()->getRepository(Author::class);
    		$author = $repository->findOneBy([
    			'firstname' => $searchParams[0]]);
			$response = new Response();
			/*if($author) {
				$result = $author->toArr();
				$response->setContent(json_encode($result));
			}
			else {
				$response->setContent('nothing found');
			}*/
			$response->setContent(json_encode($searchParams));
			$response->headers->set('Access-Control-Allow-Origin', '*');
			return $response;
		}


		/**
		*@Route("/authors", name="getA")
		*@Method({"GET"})
		*/
		public function getAuthors() {
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
		*@Route("/new")
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
		*@Route("/author/{idA}/new")
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
     	* @Route("/edit/{idA}", name="editAuthor")
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
     	* @Route("/author/{idA}/edit/{idB}", name="editBook")
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
	    * @Route("/book/delete/{id}")
	    * @Method({"DELETE"})
	    */
	    public function delete(Request $request, $id) {
	    	$book = $this->getDoctrine()->getRepository(Book::class)->find($id);
	    	$entityManager = $this->getDoctrine()->getManager();
	    	$entityManager->remove($book);
	    	$entityManager->flush();
	    	$response = new Response();
	    	$response->headers->set('Access-Control-Allow-Origin', '*');
	    	$response->send();
	    }

		/**
		*@Route("/book/{idB}/formdata", name="forEditB")
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
		*@Route("/author/{idA}/formdata", name="forEditA")
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
		*@Route("/author/{idA}", name="authorBooks")
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