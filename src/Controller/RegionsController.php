<?php

namespace App\Controller;

use App\entity\Regions;
use App\Repository\RegionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class RegionsController extends AbstractController
{
    #[Route('/regions/{id}', name: 'app_regions')]
    public function indexSingle(RegionsRepository $RegionsRep , int $id): Response
    {
        $id = intval($id);
        
        $Regions = $RegionsRep->findOneBy([
            'id'=> intval($id)
        ]);
        if (!$Regions){
            throw $this->createNotFoundException('page non trouvé');
        }
        return $this->render('Regions/index.html.twig', [
            'controller_name' => 'RegionsController',
            'Regions' => $Regions,
        ]);
    }
}

