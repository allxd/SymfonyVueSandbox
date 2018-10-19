<?php

	namespace App\Service;

	use App\Entity\Author;
	use Doctrine\ORM\EntityManagerInterface;


	class SearchFunctions
	{
		private $doctrine;

		public function __construct(DcoctrineInterface $doctrine) {
        	$this->doctrine = $doctrine;
    	}

		public function searchAuthor($searchParams) {
			//$repository = $this->getDoctrine()->getRepository(Author::class);
    		/*$author = $repository->findOneBy([
    			'secondname' => $searchParams[0]]);
			if($author) {
				$result = $author->getId();
				return(json_encode($result));
			}
			else {
				return('nothing found');
			}*/
			return '1';
		}
		
	}