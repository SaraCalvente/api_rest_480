<?php

namespace App\Entity;

use App\Repository\LibroRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=LibroRepository::class)
 */
class Libro
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="El título no puede estar vacío.")
     */
    private $titulo;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="El/la autor/a no puede estar vacío.")
     */
    private $autor;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\NotBlank(message="El genero no puede estar vacío.")
     */
    private $genero;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="El año de publicación no puede estar vacío.")
     */
    private $año_publicacion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getAutor(): ?string
    {
        return $this->autor;
    }

    public function setAutor(string $autor): self
    {
        $this->autor = $autor;

        return $this;
    }

    public function getGenero(): ?string
    {
        return $this->genero;
    }

    public function setGenero(?string $genero): self
    {
        $this->genero = $genero;

        return $this;
    }

    public function getAñoPublicacion(): ?int
    {
        return $this->año_publicacion;
    }

    public function setAñoPublicacion(int $año_publicacion): self
    {
        $this->año_publicacion = $año_publicacion;

        return $this;
    }
}
