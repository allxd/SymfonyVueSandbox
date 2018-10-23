<?php

	namespace App\Service;

	use App\Entity\Author;
	use App\Entity\Book;
	use Doctrine\ORM\EntityManagerInterface;
	use Doctrine\Common\Persistence\ObjectManager;
	use Symfony\Component\HttpFoundation\Request;
	use App\DTO\AuthorDTO;
	use App\DTO\BookDTO;

	class DataBaseOperations {
		
		private $objectManager;

		public function __construct(ObjectManager $objectManager) {
        	$this->objectManager = $objectManager;
        }

		public function createResponse(string $name='', $data=[], int $status=0, string $err='') {
			if($name != ''){
	        	$response = (object) [ 
	        		'status'=> $status,
	        		'error'=> $err,
	        		'payload'=> [$name=> $data]];
	        }
	        else {
	        	$response = (object) [
        			'status'=>$status,
        			'error'=>$err, 
        			'payload'=> $data];
	        }
	        return $response;
    	}

		public function getAllAuthors() {
			$authorRepository = $this->objectManager->getRepository(Author::class);
			$authors = $authorRepository->findAll();
			$authorsArr = array();
			foreach ($authors as $author) {
				$authorsArr[] = new AuthorDTO($author);
			}
			return $this->createResponse('authors', $authorsArr);
		}

		public function getBooks(string $id) {
			$authorRepository = $this->objectManager->getRepository(Author::class);
			$author = $authorRepository->find($id);
			if($author) {
				$authorDTO = new AuthorDTO($author);
				$booksDTO = [];
				foreach ($author->getBooks() as $book) {
	        		$booksDTO[] = new BookDTO($book);
	        	}
	        	$response = (object) [
	        		'author'=> $authorDTO,
	        		'books'=> $booksDTO ];
	        	
				return $this->createResponse('', $response);
			}
			return $tihs->createResponse('', [], 1, 'author not found');

		}

		public function createNewAuthor(Request $request) {
			$newAuthorData = json_decode($request->getContent(), true);
			/*$newAuthorDTO = new AuthorDTO();
			$newAuthorDTO->setFirstname($newAuthorData['payload']['author']['firstname']);
			$newAuthorDTO->setSecondname($newAuthorData['payload']['author']['secondname']);*/
			$author = new Author();
			$author->setFirstname($newAuthorData['payload']['author']['firstname']);
			$author->setSecondname($newAuthorData['payload']['author']['secondname']);
			$this->objectManager->persist($author);
        	$this->objectManager->flush();

        	return $this->createResponse();
		}

		public function createNewBook(Request $request, string $id) {
			$newBookData = json_decode($request->getContent(), true);
			$authorRepository = $this->objectManager->getRepository(Author::class);
			$author = $authorRepository->find($id);
			/*$newBookDTO = new BookDTO();
			$newBookDTO->setName($newBookData['payload']['book']['name']);
			$newBookDTO->setYear($newBookData['payload']['book']['year']);*/
			$book = new Book();
			$book->setName($newBookData['payload']['book']['name']);
			$book->setYear($newBookData['payload']['book']['year']);
			$book->setAuthor($author);
			$this->objectManager->persist($book);
        	$this->objectManager->flush();
        	
        	return $this->createResponse();
		}

		public function getFormDataAuthor(string $id) {
			$authorRepository = $this->objectManager->getRepository(Author::class);
			$author = $authorRepository->find($id);
			if($author) {
				$authorDTO = new AuthorDTO($author);
				return $this->createResponse('author', $authorDTO);
			}
			return $this->createResponse('', [], 1, 'author not found');
		}

		public function getFormDataBook(string $id) {
			$bookRepository = $this->objectManager->getRepository(Book::class);
			$book = $bookRepository->find($id);
			if($book) {
				$bookDTO = new BookDTO($book);
				return $this->createResponse('book', $bookDTO);
			}
			return $this->createResponse('', [], 1, 'book not found');
		}

		public function editAuthor(Request $request, $id) {
			$editAuthorData = json_decode($request->getContent(), true);
			$authorRepository = $this->objectManager->getRepository(Author::class);
			$author = $authorRepository->find($id);
			$author->setFirstname($editAuthorData['payload']['author']['firstname']);
			$author->setSecondname($editAuthorData['payload']['author']['secondname']);
			$this->objectManager->flush();
        	
        	return $this->createResponse();
		}
		
		public function editBook(Request $request, $id) {
			$editBookData = json_decode($request->getContent(), true);
			$bookRepository = $this->objectManager->getRepository(Book::class);
			$book = $bookRepository->find($id);
			$book->setName($editBookData['payload']['book']['name']);
			$book->setYear($editBookData['payload']['book']['year']);
			$this->objectManager->flush();
        	
        	return $this->createResponse();
		}

		public function deleteBook($id) {
			$bookRepository = $this->objectManager->getRepository(Book::class);
			$book = $bookRepository->find($id);
			if($book) {
				$this->objectManager->remove($book);
				$this->objectManager->flush();
			}
			return $this->createResponse();
		}

		public function searchByAuthorName(Request $request) {
			$searchParams = json_decode($request->getContent(), true);
			$authorRepository = $this->objectManager->getRepository(Author::class);
			$author = $authorRepository->findOneBy([
    			'secondname' => $searchParams['payload']['secondname']]);
			if($author) {
				$authorDTO = new AuthorDTO($author);
				return $this->createResponse('author', $authorDTO);
			}
			return $this->createResponse('', $searchParams, 1, 'author not found');
		}
	}