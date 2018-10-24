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
	use App\ExceptionHandler\AppException;
	use App\Utils\JsonSuccessResponseModel;
	use App\Utils\JsonErrorResponseModel;
	//use App\ExceptionHandler\AppException;

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
		public function searchByAuthorNameAction(DataBaseOperations $databaseOperations, Request $request) {
			$response = new JsonResponse();
			$response->setData($databaseOperations->searchByAuthorName($request));
			return $response;
		}

		/**
		*@Route("/api/authorslist", name="getAllAuthors", options={"expose" = true})
		*@Method({"GET"})
		*/
		public function getAllAuthorsAction(DataBaseOperations $databaseOperations, JsonSuccessResponseModel $successRes, JsonErrorResponseModel $errRes) {
			$response = new JsonResponse();
			try {
				$resData = $databaseOperations->getAllAuthors();
			}
			catch(\Exception $e) {
    			$response->setData($errRes->createResponse($e->getMessage()));
			}
			$response->setData($successRes->createResponse('authors', $resData));
			return $response;
		}

		/**
		*@Route("/api/new", name="createAuthor", options={"expose" = true})
		*Method({"GET", "POST"})
		*/
		public function createAuthorAction(DataBaseOperations $databaseOperations, Request $request) {
			$response = new JsonResponse();
			$response->setData($databaseOperations->createNewAuthor($request));
			return $response;
		}

		/**
		*@Route("/api/author/{idA}/new", name="createBook", options={"expose" = true})
		*Method({"GET", "POST"})
		*/
		public function createBookaction(DataBaseOperations $databaseOperations, Request $request, $idA) {
			$response = new JsonResponse();
			$response->setData($databaseOperations->createNewBook($request, $idA));
			return $response;
		}

		/**
     	* @Route("/api/edit/{idA}", name="editAuthor", options={"expose" = true})
     	* Method({"GET", "POST"})
     	*/
    	public function editAuthorAction(DataBaseOperations $databaseOperations, JsonSuccessResponseModel $successRes, JsonErrorResponseModel $errRes, Request $request, $idA) {
    		$response = new JsonResponse();
    		try {
    			$databaseOperations->editAuthor($request, $idA);
    		}
    		catch(\Exception $e) {
    			$response->setData($errRes->createResponse($e->getMessage()));
			}
			$response->setData($successRes->createResponse());
			return $response;
    	}

    	/**
     	* @Route("/api/author/{idA}/edit/{idB}", name="editBook", options={"expose" = true})
     	* Method({"GET", "POST"})
     	*/
    	public function editBookAction(DataBaseOperations $databaseOperations, JsonSuccessResponseModel $successRes, JsonErrorResponseModel $errRes, Request $request, $idB) {
    		$response = new JsonResponse();
    		try {
    			$databaseOperations->editBook($request, $idB);
    		}
    		catch(\Exception $e) {
    			$response->setData($errRes->createResponse($e->getMessage()));
			}
			$response->setData($successRes->createResponse());
			return $response;
    	}


		/**
	    * @Route("/api/book/delete/{id}", name="deleteBook", options={"expose" = true})
	    * @Method({"DELETE"})
	    */
	    public function deleteBookAction(DataBaseOperations $databaseOperations, $id) {
			$response = new JsonResponse();
			try {
				$databaseOperations->deleteBook($id);
			}
			catch(\Exception $e) {
    			$response->setData($errRes->createResponse($e->getMessage()));
			}
			$response->setData($successRes->createResponse());
			return $response;
	    }

		/**
		*@Route("/api/book/{idB}/formdata", name="formdataBook", options={"expose" = true})
		*@Method({"GET"})
		*/
		public function getBookFormdataAction(DataBaseOperations $databaseOperations, JsonSuccessResponseModel $successRes, JsonErrorResponseModel $errRes, $idB) {
			$response = new JsonResponse();
			try {
				$resData = $databaseOperations->getFormDataBook($idB);
			}
			catch(\Exception $e) {
    			$response->setData($errRes->createResponse($e->getMessage()));
			}
			$response->setData($successRes->createResponse('book', $resData));
			return $response;
		}

		/**
		*@Route("/api/author/{idA}/formdata", name="formdataAuthor", options={"expose" = true})
		*@Method({"GET"})
		*/
		public function getAuthorFormdataAction(DataBaseOperations $databaseOperations, JsonSuccessResponseModel $successRes, JsonErrorResponseModel $errRes, $idA) {
			$response = new JsonResponse();
			try {
				$resData = $databaseOperations->getFormDataAuthor($idA);
			}
			catch(\Exception $e) {
    			$response->setData($errRes->createResponse($e->getMessage()));
			}
			$response->setData($successRes->createResponse('author', $resData));
			return $response;
		}

		/**
		*@Route("/api/author/{idA}", name="booksList", options={"expose" = true})
		*/
		public function getBooksByAuthorAction(DataBaseOperations $databaseOperations, JsonSuccessResponseModel $successRes, JsonErrorResponseModel $errRes, $idA) {
			$response = new JsonResponse();
			try {
				$resData = $databaseOperations->getBooks($idA);
			}
			catch(\Exception $e) {
    			$response->setData($errRes->createResponse($e->getMessage()));
			}
			$response->setData($successRes->createResponse('author', $resData));
			return $response;
		}
	}