<?php
	namespace App\DTO;

	use App\Entity\Book;

	class BookDTO {
		
		public $id;
		public $name;
		public $year;

		public function __construct(Book $book=NULL) {
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

        public function getID() {
        	return $this->id;
        }

        public function getName() {
        	return $this->name;
        }

        public function getYear() {
        	return $this->year;
        }

        public function setName(string $name) {
        	$this->name = $name;
        	//return $this;
        }

        public function SetYear(string $year) {
        	$this->year = $year;
        }

	}