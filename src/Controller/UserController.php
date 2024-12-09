<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;

use App\Repository\UserRepository;

#[Route('/user', name: 'user')]

class UserController extends AbstractController
{
    
    #[Route('/get', name: 'user_get')]
    public function userGet(UserRepository $userrep): Response{

        $users = $userrep -> findAll();
        $userJson = array();

        foreach($users as $user){
            $userJson[] = [
                "id" => $user->getId(),
                "email" => $user->getEmail(),
                "nombre" => $user->getNombre(),
                "edad" => $user->getEdad(),
                
            ];
        }
        return $this -> json($userJson);
    }

    #[Route('/post', name: 'user_post')]
    public function userRegistrar(EntityManagerInterface $entitymanager, Request $request, UserPasswordHasherInterface $passwordHasher, ValidatorInterface $validator): Response
    {
        $body = $request->getContent();
        $data = json_decode($body, true);
    
        $user = new User();
        $user->setEmail($data["email"]);
        $user->setNombre($data["nombre"]);
        $user->setEdad($data["edad"]);
    
        $errors = $validator->validate($user);
    
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();  
            }
            return $this->json(["errors" => $errorMessages], Response::HTTP_BAD_REQUEST);  
        }
    
        $hashedPassword = $passwordHasher->hashPassword($user, $data["password"]);
        $user->setPassword($hashedPassword);

        $entitymanager->persist($user);
        $entitymanager->flush();
    
        return $this->json("Usuario Creado Correctamente", Response::HTTP_CREATED);
    }

    #[Route('/delete/{id}', name: 'user_delete_id')]
    public function userDeleteId($id, UserRepository $userrep, EntityManagerInterface $entitymanager): Response{
        dump($id);
        $user = $userrep -> find($id);

        if(!$user)
            return $this->json("Usuario no encontrado", Response::HTTP_NOT_FOUND);


        $entitymanager -> remove($user);
        $entitymanager -> flush();
        
        return $this -> json("Usuario Borrado", Response::HTTP_OK);
    }

}