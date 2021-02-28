<?php

namespace App\DataProvider ;

use App\Repository\UserRepository;
use App\Repository\ProfilRepository;
use Doctrine\Persistence\ManagerRegistry;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGenerator;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\PaginationExtension;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryResultCollectionExtensionInterface;

class UserProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $managerRegistry;
    private $pagi;
    private $context;
    private $repo;
    private $repo_profil;

    public function __construct(ManagerRegistry $managerRegistry, PaginationExtension $pagi, iterable $itemExtensions, ProfilRepository $repo_profil , UserRepository $repo)
    {
      $this->managerRegistry = $managerRegistry;
      $this->pagi = $pagi;
      $this->repo = $repo;
      $this->repo_profil = $repo_profil;

    }
    
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        if ($operationName == "get_caissier") {
            return true;
        }
        return false;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        $queryBuilder = $this->managerRegistry->getManagerForClass($resourceClass)
            ->getRepository($resourceClass)
            ->createQueryBuilder("o")->join("o.profil", "p")
            ->addSelect("p")
            ->andWhere('p.libelle = :val2')
            ->setParameter('val2', "Caissier");
            //$this->pagi->applyToCollection($queryBuilder, new QueryNameGenerator(), $resourceClass, $operationName, $this->context);
        
        // if ($this->pagi instanceof QueryResultCollectionExtensionInterface && $this->pagi->supportsResult($resourceClass, $operationName, $this->context)) {
            
        //     return $this->pagi->getResult($queryBuilder, $resourceClass, $operationName, $this->context);
        // }

        return $queryBuilder->getQuery()->getResult();
    }
}