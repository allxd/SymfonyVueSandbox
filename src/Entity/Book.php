<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
 */
class Book
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

   /**
     * @ORM\Column(type="integer")
     */
    private $authorid;


    /**
     * @ORM\Column(type="text")
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $year;

    public function getId() {
        return $this->id;
    }

    public function getAuthorid() {
        return $this->authorid;
    }

     public function getName() {
        return $this->name;
    }

    public function setAuthorid($authorid) {
        $this->authorid = $authorid;
    }

    public function setName($name) {
        $this->name = $name;
    }

     public function setYear($year) {
        $this->year = $year;
    }

     public function getYear() {
        return $this->year;
    }

    public function toArr() {
        $res = array(
            'id' => $this->getId(),
            'authorid' => $this->getAuthorid(),
            'name' => $this->getName(),
            'year' => $this->getYear()
        );
        return $res;
    }
}
