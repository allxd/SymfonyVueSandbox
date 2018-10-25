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
	use App\DTO\UserDTO;

	class DataBaseOperations {
		
		private $objectManager;
		private $validator;
		private $passwordEncoder;

		public function __construct(ObjectManager $objectManager, ValidatorInterface $validator, UserPasswordEncoderInterface $passwordEncoder) {
        	$this->objectManager = $objectManager;
        	$this->validator = $validator;
        	$this->passwordEncoder = $passwordEncoder;
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
			$authorDTO = new AuthorDTO;
			$newAuthorDTO = $authorDTO->create($request);
			$errors = $this->validator->validate($newAuthorDTO);
			if(count($errors) === 0) {
				$author = new Author();
				$author->setFirstname($newAuthorDTO->{'firstname'});
				$author->setSecondname($newAuthorDTO->{'secondname'});
				$this->objectManager->persist($author);
        		$this->objectManager->flush();
        		return;
        	}
        	else {
        		throw new \Exception((string)$errors);
        	}
		}

		public function createNewBook(Request $request, string $id) {
			$bookDTO = new BookDTO;
			$newBookDTO = $bookDTO->create($request);
			$errors = $this->validator->validate($newBookDTO);
			if(count($errors) === 0) {
				$authorRepository = $this->objectManager->getRepository(Author::class);
				$author = $authorRepository->find($id);
				if($author) {
					$book = new Book();
					$book->setName($newBookDTO->{'name'});
					$book->setYear($newBookDTO->{'year'});
					$book->setAuthor($author);
					$this->objectManager->persist($book);
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
				return $authorDTO;
			}
			else {
				throw new \Exception('nothing found');
			}
		}

		/*public function createNewUser(Request $request) {
			$userDTO = new UserDTO;
			$newUserDTO = $userDTO->create($request);
			$errors = $this->validator->validate($newUserDTO);
			if(count($errors) === 0) {
				$user = new User();
				$user->setEmail($newUserDTO->{'email'});
				$password = $this->passwordEncoder->encodePassword($user, $newUserDTO->{'password'});
				$user->setPassword($password);
				$this->objectManager->persist($user);
        		$this->objectManager->flush();
        		return;
        	}
        	else {
        		throw new \Exception((string)$errors);
        	}
		}*/
	}