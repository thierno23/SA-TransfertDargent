<?php
namespace App\DataPersister;

use App\Entity\Compte;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class CompteDataPersister implements ContextAwareDataPersisterInterface
{
    private $manager;
    private $encode;
    public function __construct(EntityManagerInterface $manager, UserPasswordEncoderInterface $encode)
    {
      $this->manager=$manager;
      $this->encode = $encode;
    }
    public function supports($data, array $context = []): bool
    {
        //dd("oki");
        return $data instanceof Compte;
    }

    public function persist($data, array $context = [])
    {
      // call your persistence layer to save $data
      $users = $data->getAgence()->getUsers();
      foreach ($users as $value) {
          $value->setPassword($this->encode->encodePassword($value, $value->getPassword()));
      }
      $data->setNumeroCompte($this->genereNumeroCompte());
      $this->manager->persist($data);
      $this->manager->flush();
      return $data;
    }

    public function remove($data, array $context = [])
    {
      $data->setStatut(!$data->getStatut()); 
      $data->getAgence()->setStatut(!$data->getAgence()->getStatut());
      $users = $data->getAgence()->getUsers();
      foreach ($users as $value) {
          $value->setStatut(!$value->getStatut());
      }
      $this->manager->persist($data);
      $this->manager->flush();
      // call your persistence layer to delete $data
    }
    // pour generer aleatoirement les numero des comptes
    public function genereNumeroCompte($longueur=15) {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $longueurMax = strlen($caracteres);
        $chaineAleatoire = '';
        for ($i = 0; $i < $longueur; $i++)
        {
        $chaineAleatoire .= $caracteres[rand(0, $longueurMax - 1)];
        }
        return $chaineAleatoire;
    }

}
?>