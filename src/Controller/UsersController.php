<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\AgenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersController extends AbstractController
{
    /**
     * @Route(
     *     "api/users",
     *     name="adding",
     *     methods={"POST"}
     *     )
     */
    public function addUser(Request $request, SerializerInterface $serializerInterface, EntityManagerInterface $manager, UserPasswordEncoderInterface $encode)
    {
       $data = json_decode($request->getContent(), true);
       $users = $serializerInterface->denormalize($data, "App\Entity\User");
       $users->setPassword($encode->encodePassword($users, $users->getPassword()));
       $manager->persist($users);
       $manager->flush();
       return $this->json([
        'message' => 'Succes',
    ]);
    }

    /**
     *  @Route(
     *     "api/agence/{id}/users",
     *     name="listMyUser",
     *     methods={"GET"}
     *     )
     */
    public function listMyUser($id, AgenceRepository $agenceRepository) {
        $agence = $agenceRepository->find($id);
        //dd($agence);
        $user = $this->getUser();
        //dd($user->getProfil()->getLibelle());
        if ($this->isGranted('ROLE_AdminSystem') || (($user->getAgence()->getId() == $agence->getId()) && ($user->getProfil()->getLibelle() == "AdminAgence") )) {
            foreach ($agence->getUsers() as $value) {
                $data[] = $value;
            }
            return $this->json($data, Response::HTTP_OK);
        }else {
            return $this->json("vous vous etes trompes d'agence!!");
        }
    }
}
