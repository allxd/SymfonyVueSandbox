<?php

	namespace App\Service;

	use App\Entity\Author;
	use App\Entity\Book;
	use Doctrine\ORM\EntityManagerInterface;
	use Doctrine\Common\Persistence\ObjectManager;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\Validator\Validator\ValidatorInterface;
	use Symfony\Component\Config\Definition\Exception\Exception;
	use App\DTO\AuthorDTO;
	use App\DTO\BookDTO;

	class DataBaseOperations {
		
		private $objectManager;
		private $validator;

		public function __construct(ObjectManager $objectManager, ValidatorInterface $validator) {
        	$this->objectManager = $objectManager;
        	$this->validator = $validator;
        }

		public function getAllAuthors() {
			$authorRepository = $this->objectManager->getRepository(Author::class);
			$authors = $authorRepository->findAll();
			$authorsArr = array();
			foreach ($authors as $author) {
				$authorsArr[] = new AuthorDTO($author);
			}
			return $authorsArr;
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
				return $authorDTO;
			}
			else {
				throw new \Exception('author not found');
			}

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
				return $authorDTO;
			}
			else {
				throw new \Exception('author not found');
			}
		}

		public function getFormDataBook(string $id) {
			$bookRepository = $this->objectManager->getRepository(Book::class);
			$book = $bookRepository->find($id);
			if($book) {
				$bookDTO = new BookDTO($book);
				return $bookDTO;
			}
			else {
				throw new \Exception('book not found');
			}
		}

		public function editAuthor(Request $request, $id) {
			$authorDTO = new AuthorDTO;
			$infoAuthorDTO = $authorDTO->create($request);
			$errors = $this->validator->validate($infoAuthorDTO);
			if(count($errors) === 0) {
				$authorRepository = $this->objectManager->getRepository(Author::class);
				$author = $authorRepository->find($id);
				if($author) {
					$author->setFirstname($infoAuthorDTO->{'firstname'});
					$author->setSecondname($infoAuthorDTO->{'secondname'});
					$this->objectManager->flush();
					return;
				}
				else {
					throw new \Exception('author not found');
				}
			}
			else {
				throw new \Exception((string)$errors);
			}
		}
		
		public function editBook(Request $request, $id) {
			$bookDTO = new BookDTO;
			$infoBookDTO = $bookDTO->create($request);
			$errors = $this->validator->validate($infoBookDTO);
			if(count($errors) === 0) {
				$bookRepository = $this->objectManager->getRepository(Book::class);
				$book = $bookRepository->find($id);
				if($book) {
					$book->setName($infoBookDTO->{'name'});
					$book->setYear($infoBookDTO->{'year'});
					$this->objectManager->flush();
					return;
				}
				else {
					throw new \Exception('book not found');
				}
			}
			else {
				throw new \Exception((string)$errors);
			}
		}

		public function deleteBook($id) {
			$bookRepository = $this->objectManager->getRepository(Book::class);
			$book = $bookRepository->find($id);
			if($book) {
				$this->objectManager->remove($book);
				$this->objectManager->flush();
				return;
			}
			else {
				throw new \Exception('book not found');
			}
		}

		public function searchByAuthorName(Request $request) {
			$searchParams = $request->query->get('secondname');
			$authorRepository = $this->objectManager->getRepository(Author::class);
			$author = $authorRepository->findOneBy([
    			'secondname' => $searchParams]);
			if($author) {
				$authorDTO = new AuthorDTO($author);
				//return $this->createResponse('author', $authorDTO);
			}
			return $this->createResponse('', $searchParams, 1, 'author not found');
		}
	}