<?php

namespace App\Tests\All;

use App\Entity\Author;
use App\Entity\Book;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthorBookTest extends TestCase
{
    public function testNameA() {
       $author = new Author();

       $author->setFirstname('Tst');
       $this->assertEquals($author->getFirstname(), 'Tst');
    }

    public function testNameB() {
       $book = new Book();

       $book->setName('Tst');
       $this->assertEquals($book->getName(), 'Tst');
    }
}

class RouterTest extends WebTestCase
{
	/**
	* @dataProvider provideUrls
	*/
	public function testRoutes($url) {
	    $client = self::createClient();
	    $client->request('GET', $url);

	    $this->assertTrue($client->getResponse()->isSuccessful());
	}

	public function provideUrls() {
	    return array(
	        array('/new'),
	        array('/author/1/new')
	    );
	}
}