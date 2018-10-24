<?php
	namespace App\DTO;

	use App\Entity\Author;
	use Symfony\Component\HttpFoundation\Request;

	class AuthorDTO {
		
		public $id;
		public $firstname;
		public $secondname;
		public $books;

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
	        	$this->id = '';
	        	$this->firstname = '';
	        	$this->secondname = '';
	        	$this->books = [];
	        }
        }

	}