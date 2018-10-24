<?php
	namespace App\DTO;

	use App\Entity\Book;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\Validator\Constraints as Assert;

	class BookDTO {
		public $id;
		/**
     	* @Assert\NotBlank()
     	*/
		public $name;
		/**
     	* @Assert\NotBlank()
     	* @Assert\Type(
     	* 	type="integer",
     	*   message="The value {{ value }} is not a valid {{ type }}."
     	* )
     	*/
		public $year;

		public function __construct(Book $book=null) {
			if($book) {
	        	$this->id = $book->getId();
	        	$this->name = $book->getName();
	        	$this->year = $book->getYear();
	        }
	        else {
	        	$this->id = '';
	        	$this->name = '';
	        	$this->year = '';
	        }
        }

        public static function create(Request $request, string $key = "payload") {
        	$content = $request->getContent();
        	$params = json_decode($content, true);
        	$model = new self();
        	$model->name = $params['payload']['book']['name'];
        	$model->year = $params['payload']['book']['year'];

        	return $model;
        }

	}