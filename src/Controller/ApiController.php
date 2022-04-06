<?php

namespace App\Controller;

use DateTime;
use App\Entity\Lekarstwo;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/api', name: 'app_api')]
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiController.php',
        ]);
    }


    #[Route('/api/post_api', name: 'post_api', methods:"POST")]
    public function post_api(ManagerRegistry $doctrine, Request $req): Response
    {
        $medicament = new Lekarstwo();
        $param = json_decode($req->getContent(), true);

        
        $medicament->setNazwaLeku($param['nazwa_leku']);
        $medicament->setProducent($param['producent']);
        $time = new DateTime($param['data_utworzenia']);
        $medicament->setDataUtworzenia($time);
        $time = new DateTime($param['data_modyfikacji']);
        $medicament->setDataModyfikacji($time);

        $em = $doctrine->getManager();
        $em->persist($medicament);
        $em->flush();

        return $this->json([
            "Inserted succesfully!"
        ]);
    }


    #[Route('/api/update_api/{id}', name: 'update_api', methods:"PUT")]
    public function update_api(ManagerRegistry $doctrine, Request $req, $id): Response
    {
        $data = $doctrine->getRepository(Lekarstwo::class)->find($id);
        $param = json_decode($req->getContent(), true);


        $data->setNazwaLeku($param['nazwa_leku']);
        $data->setProducent($param['producent']);
        $time = new DateTime($param['data_utworzenia']);
        $data->setDataUtworzenia($time);
        $time = new DateTime($param['data_modyfikacji']);
        $data->setDataModyfikacji($time);

        $em = $doctrine->getManager();
        $em->persist($data);
        $em->flush();

        return $this->json([
            "Updated succesfully!"
        ]);
    }
}
