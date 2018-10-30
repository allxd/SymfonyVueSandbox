<?php
	namespace App\DTO;

	use App\Entity\Author;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\Validator\Constraints as Assert;
	
	class AuthorDTO {
		
		/**
     	 * @var string
		 */
		public $id;
		
		/**
     	 * @Assert\NotBlank()
     	 * @Assert\Length(
     	 * 	min = 2,
     	 *  max = 20,
     	 *  minMessage = "first name must be at least {{ limit }} characters long",
     	 *  maxMessage = "first name cannot be longer than {{ limit }} characters"
     	 * )
     	 * @var string
     	 */
		public $firstname;

		/**
      	 * @Assert\NotBlank()
     	 * @Assert\Length(
     	 * 	min = 2,
     	 *  max = 20,
     	 *  minMessage = "second name must be at least {{ limit }} characters long",
     	 *  maxMessage = "second name cannot be longer than {{ limit }} characters"
     	 * )
     	 * @var string
     	 */
		public $secondname;

		/**
     	 * @var Books[]
		 */
		public $books;

		/**
		 * @param Author|null $author
		 */
		public function __construct(Author $author=null) {
			if($author) {
	        	$this->id = $author->getId();
	        	$this->firstname = $author->getFirstname();
	        	$this->secondname = $author->getSecondname();
	        	$this->books = [];
	        	foreach ($author->getBooks() as $book) {
	        		$this->books[] = new BookDTO($book);
	        	}
	        }
	        else {
	        	$this->id = null;
	        	$this->firstname = null;
	        	$this->secondname = null;
	        	$this->books = [];
	        }
        }

		/**
		 * @param Request $request
		 * @param string $key
		 * @return AuthorDTO
		 */
        public static function create(Request $request, string $key = "payload") {
        	$content = $request->getContent();
        	$params = json_decode($content, true);
        	$model = new self();
        	$model->firstname = $params['payload']['author']['firstname'];
        	$model->secondname = $params['payload']['author']['secondname'];

        	return $model;
        }

	}