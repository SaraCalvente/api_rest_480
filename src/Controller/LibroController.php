<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Libro; 
use App\Repository\LibroRepository;

#[Route('/libro', name: 'libro')]

class LibroController extends AbstractController
{   
    
    #[Route('/get', name: 'libro_get')]
    public function libroGet(LibroRepository $librorep): Response{

        $libros = $librorep -> findAll();
        $libroJson = array();

        foreach($libros as $libro){
            $libroJson[] = [
                "id"=> $libro ->getId(),
                "titulo" => $libro->getTitulo(),
                "autor" => $libro->getAutor(),
                "genero" => $libro->getGenero(),
                "año_publicacion" => $libro->getAñoPublicacion(),
            ];
        }
        return $this -> json($libroJson);
    }

    #[Route('/post', name: 'libro_post')]
    public function libroRegistrar(EntityManagerInterface $entitymanager, Request $request): Response
    {
        $body = $request->getContent();
        $data = json_decode($body, true);
    
        $libro = new Libro();
        $libro->setTitulo($data["titulo"]);
        $libro->setAutor($data["autor"]);
        $libro->setGenero($data["genero"]);

        if (isset($data["año_publicacion"])) {
            $libro->setAñoPublicacion($data["año_publicacion"]);
        } else {
            return $this->json("El campo 'año_publicacion' es obligatorio", Response::HTTP_BAD_REQUEST);
        }

        $entitymanager->persist($libro);
        $entitymanager->flush();
    
        return $this->json("Libro Creado Correctamente", Response::HTTP_CREATED);
    }


    #[Route('/put/{id}', name: 'libro_put')]
    public function libroActualizar($id, Request $request, EntityManagerInterface $entityManager, 
    LibroRepository $librorep): Response
    {
        if (!$user) {
            return $this->json(['message' => 'No autenticado'], Response::HTTP_UNAUTHORIZED);
        }

        if (!$this->isGranted('ROLE_USER')) {
            return $this->json(['message' => 'Acceso denegado'], Response::HTTP_FORBIDDEN);
        }

        $libro = $librorep->find($id);

        if (!$libro) {
            return $this->json("Libro no encontrado", Response::HTTP_NOT_FOUND);
        }

        $body = $request->getContent();
        $data = json_decode($body, true);

        if (isset($data["titulo"])) {
            $libro->setTitulo($data["titulo"]);
        }

        if (isset($data["autor"])) {
            $libro->setAutor($data["autor"]);
        }

        if (isset($data["genero"])) {
            $libro->setGenero($data["genero"]);
        }

        if (isset($data["año_publicacion"])) {
            $libro->setAñoPublicacion($data["año_publicacion"]);
        }

        $entityManager->persist($libro);
        $entityManager->flush();

        return $this->json("Libro actualizado correctamente", Response::HTTP_OK);
    }

    #[Route('/delete/{id}', name: 'libro_delete')]
    public function libroDeleteId($id, LibroRepository $librorep, EntityManagerInterface $entitymanager): Response
    {
        
        $user = $this->getUser();
        
        if (!$user) {
            return $this->json(['message' => 'No autenticado'], Response::HTTP_UNAUTHORIZED);
        }

        if (!$this->isGranted('ROLE_USER')) {
            return $this->json(['message' => 'Acceso denegado'], Response::HTTP_FORBIDDEN);
        }

        $libro = $librorep->find($id);
        
        if (!$libro) {
            return $this->json(['message' => 'Libro no encontrado'], Response::HTTP_NOT_FOUND);
        }
        
        $entitymanager->remove($libro);
        $entitymanager->flush();
        
        return $this->json(['message' => 'Libro borrado exitosamente'], Response::HTTP_OK);
    }



}
