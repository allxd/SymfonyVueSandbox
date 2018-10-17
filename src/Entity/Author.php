<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AuthorRepository")
 */
class Author
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $firstname;


    /**
     * @ORM\Column(type="text")
     */
    private $secondname;

    public function getId() {
        return $this->id;
    }

    public function getFirstname() {
        return $this->firstname;
    }

     public function getSecondname() {
        return $this->secondname;
    }

    public function setFirstname($firstname) {
        $this->firstname = $firstname;
    }

    public function setSecondname($secondname) {
        $this->secondname = $secondname;
    }

    public function toArr() {
        $res = array(
            'id' => $this->getId(),
            'firstname' => $this->getFirstname(),
            'secondname' => $this->getSecondname()
        );
        return $res;
    }
}
