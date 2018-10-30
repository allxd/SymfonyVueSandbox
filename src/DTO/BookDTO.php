<?php
	namespace App\DTO;

	use App\Entity\Book;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\Validator\Constraints as Assert;

	class BookDTO {

		/**
     	 * @var string
		 */
		public $id;

		/**
     	 * @Assert\NotBlank()
     	 * @var string
      	 */
		public $name;
		
		/**
     	 * @Assert\NotBlank()
     	 * @var int
     	 */
		public $year;

		/**
		 * @param Book|null $book
		 */
		public function __construct(Book $book=null) {
			if($book) {
	        	$this->id = $book->getId();
	        	$this->name = $book->getName();
	        	$this->year = $book->getYear();
	        }
	        else {
	        	$this->id = null;
	        	$this->name = null;
	        	$this->year = null;
	        }
        }

		/**
		 * @param Request $request
		 * @param string $key
		 * @return BookDTO
		 */
        public static function create(Request $request, string $key = "payload") {
        	$content = $request->getContent();
        	$params = json_decode($content, true);
        	$model = new self();
        	$model->name = $params['payload']['book']['name'];
        	$model->year = $params['payload']['book']['year'];

        	return $model;
        }

	}