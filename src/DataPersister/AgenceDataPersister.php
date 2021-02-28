<?php
namespace App\DataPersister;

use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Agence;

final class AgenceDataPersister implements ContextAwareDataPersisterInterface
{
    private $manager;
    public function __construct(EntityManagerInterface $manager)
    {
      $this->manager=$manager;
    }
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Agence;
    }

    public function persist($data, array $context = [])
    {
      // call your persistence layer to save $data
      $this->manager->persist($data);
      $this->manager->flush();
      return $data;
    }

    public function remove($data, array $context = [])
    {
      $data->setStatut(!$data->getStatut()); 
      $data->getCompte()->setStatut(!$data->getCompte()->getStatut());
      $users = $data->getUsers();
      foreach ($users as $value) {
          $value->setStatut(!$value->getStatut());
      }
      $this->manager->persist($data);
      $this->manager->flush();
      // call your persistence layer to delete $data
    }

}