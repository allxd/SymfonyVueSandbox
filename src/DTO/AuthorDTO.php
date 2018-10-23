<?php
	namespace App\DTO;

	use App\Entity\Author;
	use Symfony\Component\HttpFoundation\Request;

	class AuthorDTO {
		
		public $id;
		public $firstname;
		public $secondname;
		//public $books;

		public function __construct(Author $author=NULL) {
			if($author) {
	        	$this->id = $author->getId();
	        	$this->firstname = $author->getFirstname();
	        	$this->secondname = $author->getSecondname();
	        	//$this->books = [];
	        	/*foreach ($author->getBooks() as $book) {
	        		$this->books[] = ['id' => $book->getId(), 'name' => $book->getName(), 'year' => $book->getYear()];
	        	}*/
	        }
	        else {
	        	$this->id = '';
	        	$this->firstname = '';
	        	$this->secondname = '';
	        	//$this->books = [];
	        }
        }

        public function getID() {
        	return $this->id;
        }

        public function getfirstname() {
        	return $this->firstname;
        }

        public function getSecondname() {
        	return $this->secondname;
        }

        public function setfirstname(string $firstname) {
        	$this->firstname = $firstname;
        	//return $this;
        }

        public function setSecondname(string $secondname) {
        	$this->secondname = $secondname;
        }

	}