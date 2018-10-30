<?php
namespace App\Controller;

	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\Routing\Annotation\Route;
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;


	use App\Service\DataBaseOperations;
	use App\ExceptionHandler\CustomAppException;
	use App\Utils\JsonSuccessResponseModel;
	use App\Utils\JsonErrorResponseModel;

	/**
 	 * Class SecurityController
 	 */
	class AllController extends Controller {

		/**
		 * @Route("/", name="home")
		 * @Method({"GET"})
		 * @return Response
		 */
		public function index() {
			return $this->render('base.html.twig');
		}

		/**
		 * @Route("/search", name="search", options={"expose" = true})
		 * @Method({"GET"})
		 * @param DataBaseOperations $databaseOperations
		 * @param Request $request
		 * @return Response
		 */
		public function searchByAuthorNameAction(DataBaseOperations $databaseOperations, Request $request) {
			try {
				$payload = $databaseOperations->searchByAuthorName($request);
				$data = new JsonSuccessResponseModel($payload);
			}
			catch(CustomAppException $e) {
    			$data = new JsonErrorResponseModel([], $e->getMessage());
			}
			return $this->json($data);
		}

		/**
		 * @Route("/api/authorslist", name="getAllAuthors", options={"expose" = true})
		 * @Method({"GET"})
		 * @param DataBaseOperations $databaseOperations
		 * @return Response
		 */
		public function getAllAuthorsAction(DataBaseOperations $databaseOperations) {
			try {
				$payload = $databaseOperations->getAllAuthors();
				$data = new JsonSuccessResponseModel($payload);
			}
			catch(CustomAppException $e) {
    			$data = new JsonErrorResponseModel([], $e->getMessage());
			}
			return $this->json($data);
		}

		/**
		 * @Route("/api/addauthor", name="createAuthor", options={"expose" = true})
		 * @Method({"POST"})
		 * @param DataBaseOperations $databaseOperations
		 * @param Request $request
		 * @return Response
		 */
		public function createAuthorAction(DataBaseOperations $databaseOperations, Request $request) {
			try {
				$payload = $databaseOperations->createNewAuthor($request);
				$data = new JsonSuccessResponseModel($payload);
			}
			catch(CustomAppException $e) {
    			$data = new JsonErrorResponseModel([], $e->getMessage());
			}
			return $this->json($data);
		}

		/**
		 * @Route("/api/author/{id}/addbook", name="createBook", options={"expose" = true})
		 * @Method({"POST"})
		 * @param DataBaseOperations $databaseOperations
		 * @param Request $request
		 * @param string $id
		 * @return Response
		 */
		public function createBookaction(DataBaseOperations $databaseOperations, Request $request, $id) {
			try {
				$payload = $databaseOperations->createNewBook($request, $id);
				$data = new JsonSuccessResponseModel($payload);
			}
			catch(CustomAppException $e) {
    			$data = new JsonErrorResponseModel([], $e->getMessage());
			}
			return $this->json($data);
		}

		/**
     	 * @Route("/api/author/edit/{id}", name="editAuthor", options={"expose" = true})
     	 * @Method({"POST"})
		 * @param DataBaseOperations $databaseOperations
		 * @param Request $request
		 * @param string $id
		 * @return Response
     	 */
    	public function editAuthorAction(DataBaseOperations $databaseOperations, Request $request, $id) {
			try {
				$payload = $databaseOperations->editAuthor($request, $id);
				$data = new JsonSuccessResponseModel($payload);
			}
			catch(CustomAppException $e) {
    			$data = new JsonErrorResponseModel([], $e->getMessage());
			}
			return $this->json($data);
    	}

    	/**
     	 * @Route("/api/book/edit/{id}", name="editBook", options={"expose" = true})
     	 * @Method({"POST"})
     	 * @param DataBaseOperations $databaseOperations
		 * @param Request $request
		 * @param string $id
		 * @return Response
     	 */
    	public function editBookAction(DataBaseOperations $databaseOperations, Request $request, $id) {
			try {
				$payload = $databaseOperations->editBook($request, $id);
				$data = new JsonSuccessResponseModel($payload);
			}
			catch(CustomAppException $e) {
    			$data = new JsonErrorResponseModel([], $e->getMessage());
			}
			return $this->json($data);
    	}


		/**
	     * @Route("/api/book/delete/{id}", name="deleteBook", options={"expose" = true})
	     * @Method({"DELETE"})
	     * @param DataBaseOperations $databaseOperations
		 * @param string $id
		 * @return Request
	     */
	    public function deleteBookAction(DataBaseOperations $databaseOperations, $id) {
			try {
				$payload = $databaseOperations->deleteBook($id);
				$data = new JsonSuccessResponseModel($payload);
			}
			catch(CustomAppException $e) {
    			$data = new JsonErrorResponseModel([], $e->getMessage());
			}
			return $this->json($data);
	    }

		/**
		 * @Route("/api/book/formdata/{id}", name="formdataBook", options={"expose" = true})
		 * @Method({"GET"})
		 * @param DataBaseOperations $databaseOperations
		 * @param string $id
		 * @return Request
		 */
		public function getBookFormdataAction(DataBaseOperations $databaseOperations, $id) {
			try {
				$payload = $databaseOperations->getBookFormData($id);
				$data = new JsonSuccessResponseModel($payload);
			}
			catch(CustomAppException $e) {
    			$data = new JsonErrorResponseModel([], $e->getMessage());
			}
			return $this->json($data);
		}

		/**
		 * @Route("/api/author/formdata/{id}", name="formdataAuthor", options={"expose" = true})
		 * @Method({"GET"})
		 * @param DataBaseOperations $databaseOperations
		 * @param string $id
		 * @return Request
		 */
		public function getAuthorFormdataAction(DataBaseOperations $databaseOperations, $id) {
			try {
				$payload = $databaseOperations->getAuthorFormData($id);
				$data = new JsonSuccessResponseModel($payload);
			}
			catch(CustomAppException $e) {
    			$data = new JsonErrorResponseModel([], $e->getMessage());
			}
			return $this->json($data);
		}

		/**
		 * @Route("/api/author/{id}/books", name="booksList", options={"expose" = true})
		 * @Method({"GET"})
		 * @param DataBaseOperations $databaseOperations
		 * @param string $id
		 * @return Request
		 */
		public function getBooksByAuthorAction(DataBaseOperations $databaseOperations, $id) {
			try {
				$payload = $databaseOperations->getBooksByAuthor($id);
				$data = new JsonSuccessResponseModel($payload);
			}
			catch(CustomAppException $e) {
    			$data = new JsonErrorResponseModel([], $e->getMessage());
			}
			return $this->json($data);
		}
	}