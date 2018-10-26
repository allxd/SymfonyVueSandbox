<?php

	namespace App\Service;

	use App\Entity\Author;
	use App\Entity\Book;
	use App\Entity\User;
	use Doctrine\ORM\EntityManagerInterface;
	use Doctrine\Common\Persistence\ObjectManager;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\Validator\Validator\ValidatorInterface;
	use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
	use Symfony\Component\Config\Definition\Exception\Exception;
	use App\DTO\AuthorDTO;
	use App\DTO\BookDTO;
	use App\ExceptionHandler\CustomAppException;	

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

		public function getBooksByAuthor(string $id) {
			$authorRepository = $this->objectManager->getRepository(Author::class);
			$author = $authorRepository->find($id);
			if($author) {
				return new AuthorDTO($author);
			}
			else {
				throw new CustomAppException('author not found');
			}

		}

		public function createNewAuthor(Request $request) {
			$newAuthorDTO = AuthorDTO::create($request);
			$errors = $this->validator->validate($newAuthorDTO);
			if(count($errors) === 0) {
				$author = new Author();
				$author->setFirstname($newAuthorDTO->firstname);
				$author->setSecondname($newAuthorDTO->secondname);
				$this->objectManager->persist($author);
        		$this->objectManager->flush();
        		return;
        	}
        	else {
        		throw new CustomAppException((string)$errors);
        	}
		}

		public function createNewBook(Request $request, string $id) {
			$newBookDTO = BookDTO::create($request);
			$errors = $this->validator->validate($newBookDTO);
			if(count($errors) === 0) {
				$authorRepository = $this->objectManager->getRepository(Author::class);
				$author = $authorRepository->find($id);
				if($author) {
					$book = new Book();
					$book->setName($newBookDTO->name);
					$book->setYear($newBookDTO->year);
					$book->setAuthor($author);
					$this->objectManager->persist($book);
        			$this->objectManager->flush();
        			return;
				}
				else {
					throw new CustomAppException('author not found');
				}
			}
			else {
				throw new CustomAppException((string)$errors);
			}
		}

		public function getAuthorFormData(string $id) {
			$authorRepository = $this->objectManager->getRepository(Author::class);
			$author = $authorRepository->find($id);
			if($author) {
				return new AuthorDTO($author);
			}
			else {
				throw new CustomAppException('author not found');
			}
		}

		public function getBookFormData(string $id) {
			$bookRepository = $this->objectManager->getRepository(Book::class);
			$book = $bookRepository->find($id);
			if($book) {
				return new BookDTO($book);
			}
			else {
				throw new CustomAppException('book not found');
			}
		}

		public function editAuthor(Request $request, $id) {
			$infoAuthorDTO = AuthorDTO::create($request);
			$errors = $this->validator->validate($infoAuthorDTO);
			if(count($errors) === 0) {
				$authorRepository = $this->objectManager->getRepository(Author::class);
				$author = $authorRepository->find($id);
				if($author) {
					$author->setFirstname($infoAuthorDTO->firstname);
					$author->setSecondname($infoAuthorDTO->secondname);
					$this->objectManager->flush();
					return;
				}
				else {
					throw new CustomAppException('author not found');
				}
			}
			else {
				throw new CustomAppException((string)$errors);
			}
		}
		
		public function editBook(Request $request, $id) {
			$infoBookDTO = BookDTO::create($request);
			$errors = $this->validator->validate($infoBookDTO);
			if(count($errors) === 0) {
				$bookRepository = $this->objectManager->getRepository(Book::class);
				$book = $bookRepository->find($id);
				if($book) {
					$book->setName($infoBookDTO->name);
					$book->setYear($infoBookDTO->year);
					$this->objectManager->flush();
					return;
				}
				else {
					throw new CustomAppException('book not found');
				}
			}
			else {
				throw new CustomAppException((string)$errors);
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
				throw new CustomAppException('book not found');
			}
		}

		public function searchByAuthorName(Request $request) {
			$searchParams = $request->query->get('secondname');
			$authorRepository = $this->objectManager->getRepository(Author::class);
			$author = $authorRepository->findOneBy([
    			'secondname' => $searchParams]);
			if($author) {
				return new AuthorDTO($author);
			}
			else {
				throw new CustomAppException('nothing found');
			}
		}
	}