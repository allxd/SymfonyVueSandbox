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

	use App\Service\DataBaseOperations;
	use App\Utils\ResponseMaker;
	use App\DTO\AuthorDTO;

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
		public function search(DataBaseOperations $databaseOperations, Request $request) {
			$response = new JsonResponse();
			$response->setData($databaseOperations->searchByAuthorName($request));
			return $response;
		}


		/**
		*@Route("/api/authorslist", name="getAllAuthors", options={"expose" = true})
		*@Method({"GET"})
		*/
		public function getAllAuthors(DataBaseOperations $databaseOperations) {
			$response = new JsonResponse();
			$response->setData($databaseOperations->getAllAuthors());
			return $response;
		}

		/**
		*@Route("/api/new", name="createAuthor", options={"expose" = true})
		*Method({"GET", "POST"})
		*/
		public function newA(DataBaseOperations $databaseOperations, Request $request) {
			$response = new JsonResponse();
			$response->setData($databaseOperations->createNewAuthor($request));
			return $response;
		}

		/**
		*@Route("/api/author/{idA}/new", name="createBook", options={"expose" = true})
		*Method({"GET", "POST"})
		*/
		public function newB(DataBaseOperations $databaseOperations, Request $request, $idA) {
			$response = new JsonResponse();
			$response->setData($databaseOperations->createNewBook($request, $idA));
			return $response;
		}

		/**
     	* @Route("/api/edit/{idA}", name="editAuthor", options={"expose" = true})
     	* Method({"GET", "POST"})
     	*/
    	public function editA(DataBaseOperations $databaseOperations, Request $request, $idA) {
    		$response = new JsonResponse();
			$response->setData($databaseOperations->editAuthor($request, $idA));
			return $response;
    	}

    	/**
     	* @Route("/api/author/{idA}/edit/{idB}", name="editBook", options={"expose" = true})
     	* Method({"GET", "POST"})
     	*/
    	public function editB(DataBaseOperations $databaseOperations, Request $request, $idB, $idA) {
    		$response = new JsonResponse();
			$response->setData($databaseOperations->editBook($request, $idB));
			return $response;
    	}


		/**
	    * @Route("/api/book/delete/{idB}", name="deleteBook", options={"expose" = true})
	    * @Method({"DELETE"})
	    */
	    public function delete(DataBaseOperations $databaseOperations, $idB) {
			$response = new JsonResponse();
			$response->setData($databaseOperations->deleteBook($idB));
			return $response;
	    }

		/**
		*@Route("/api/book/{idB}/formdata", name="formdataBook", options={"expose" = true})
		*@Method({"GET"})
		*/
		public function getFormdataB(DataBaseOperations $databaseOperations, $idB) {
			$response = new JsonResponse();
			$response->setData($databaseOperations->getFormDataBook($idB));
			return $response;
		}

		/**
		*@Route("/api/author/{idA}/formdata", name="formdataAuthor", options={"expose" = true})
		*@Method({"GET"})
		*/
		public function getFormdataA(DataBaseOperations $databaseOperations, $idA) {
			$response = new JsonResponse();
			$response->setData($databaseOperations->getFormDataAuthor($idA));
			return $response;
		}

		/**
		*@Route("/api/author/{idA}", name="booksList", options={"expose" = true})
		*/
		public function books(DataBaseOperations $databaseOperations, $idA) {
			$response = new JsonResponse();
			$response->setData($databaseOperations->getBooks($idA));
			return $response;
		}
	}