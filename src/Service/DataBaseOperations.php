<?php

	namespace App\Service;

	use App\Entity;
	use Doctrine\ORM\EntityManagerInterface;
	use Doctrine\Common\Persistence\ObjectManager;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\Validator\Validator\ValidatorInterface;
	use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
	use App\DTO;
	use App\ExceptionHandler\CustomAppException;	

	class DataBaseOperations {
		
		private $objectManager;
		private $validator;

		/**
		 * @param ObjectManager $objectManager
		 * @param ValidatorInterface $validator
		 */
		public function __construct(ObjectManager $objectManager, ValidatorInterface $validator) {
        	$this->objectManager = $objectManager;
        	$this->validator = $validator;
        }

		/**
		 * @param string $firstname
		 * @param string $secondname
		 * @return bool
		 */
        public function checkIfAuthorAlreadyExists(string $firstname, string $secondname) {
        	$authorRepository = $this->objectManager->getRepository(Entity\Author::class);
			$author = $authorRepository->findOneBy([
    			'firstname' => $firstname,
    			'secondname' => $secondname]);
			return ($author instanceof Entity\Author);
        }


		/**
		 * @return AuthorDTO[]
		 */
		public function getAllAuthors() {
			$authorRepository = $this->objectManager->getRepository(Entity\Author::class);
			$allAuthors = $authorRepository->findAll();
			$authors = array();
			foreach ($allAuthors as $author) {
				$authors[] = new DTO\AuthorDTO($author);
			}
			return $authors;
		}

		/**
		 * @param string $id
		 * @return AuthorDTO
		 * @throws CustomAppException
		 */
		public function getBooksByAuthor(string $id) {
			$authorRepository = $this->objectManager->getRepository(Entity\Author::class);
			$author = $authorRepository->find($id);
			if($author) {
				return new DTO\AuthorDTO($author);
			}
			else {
				throw new CustomAppException('author not found');
			}

		}

		/**
		 * @param Request $request
		 * @throws CustomAppException
		 */
		public function createNewAuthor(Request $request) {
			$newAuthorDTO = DTO\AuthorDTO::create($request);
			$errors = $this->validator->validate($newAuthorDTO);
			if(count($errors) === 0) {
				if($this->checkIfAuthorAlreadyExists($newAuthorDTO->firstname, $newAuthorDTO->secondname)) {
					throw new CustomAppException('author already exists');
				}
				else {
					$author = new Entity\Author();
					$author->setFirstname($newAuthorDTO->firstname);
					$author->setSecondname($newAuthorDTO->secondname);
					$this->objectManager->persist($author);
	        		$this->objectManager->flush();
	        		return;
	        	}
        	}
        	else {
        		throw new CustomAppException((string)$errors);
        	}
		}

		/**
		 * @param Request $request
		 * @param string $id
		 * @throws CustomAppException
		 */
		public function createNewBook(Request $request, string $id) {
			$newBookDTO = DTO\BookDTO::create($request);
			$errors = $this->validator->validate($newBookDTO);
			if(count($errors) === 0) {
				$authorRepository = $this->objectManager->getRepository(Entity\Author::class);
				$author = $authorRepository->find($id);
				if($author) {
					$book = new Entity\Book();
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

		/**
		 * @param string $id
		 * @return AuthorDTO
		 * @throws CustomAppException
		 */
		public function getAuthorFormData(string $id) {
			$authorRepository = $this->objectManager->getRepository(Entity\Author::class);
			$author = $authorRepository->find($id);
			if($author) {
				return new DTO\AuthorDTO($author);
			}
			else {
				throw new CustomAppException('author not found');
			}
		}

		/**
		 * @param string $id
		 * @return BookDTO
		 * @throws CustomAppException
		 */
		public function getBookFormData(string $id) {
			$bookRepository = $this->objectManager->getRepository(Entity\Book::class);
			$book = $bookRepository->find($id);
			if($book) {
				return new DTO\BookDTO($book);
			}
			else {
				throw new CustomAppException('book not found');
			}
		}

		/**
		 * @param Request $request
		 * @param string $id
		 * @throws CustomAppException
		 */
		public function editAuthor(Request $request, string $id) {
			$infoAuthorDTO = DTO\AuthorDTO::create($request);
			$errors = $this->validator->validate($infoAuthorDTO);
			if(count($errors) === 0) {
				$authorRepository = $this->objectManager->getRepository(Entity\Author::class);
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
		
		/**
		 * @param Request $request
		 * @param string $id
		 * @throws CustomAppException
		 */
		public function editBook(Request $request, string $id) {
			$infoBookDTO = DTO\BookDTO::create($request);
			$errors = $this->validator->validate($infoBookDTO);
			if(count($errors) === 0) {
				$bookRepository = $this->objectManager->getRepository(Entity\Book::class);
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

		/**
		 * @param string $id
		 * @throws CustomAppException
		 */
		public function deleteBook(string $id) {
			$bookRepository = $this->objectManager->getRepository(Entity\Book::class);
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

		/**
		 * @param Request $request
		 * @throws CustomAppException
		 */
		public function searchByAuthorName(Request $request) {
			$searchParams = $request->query->get('secondname');
			$authorRepository = $this->objectManager->getRepository(Entity\Author::class);
			$author = $authorRepository->findOneBy([
    			'secondname' => $searchParams]);
			if($author) {
				return new DTO\AuthorDTO($author);
			}
			else {
				throw new CustomAppException('nothing found');
			}
		}
	}