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


    #[Route('/api/post_api/{producent_number}', name: 'post_api', methods:"POST")]
    public function post_api(ManagerRegistry $doctrine, Request $req, $producent_number): Response
    {
        $medicament = new Lekarstwo();
        $param = json_decode($req->getContent(), true);

        $allowed_producent = array(
            0 => 'Vet-nam',
            1 => 'Vet-wam',
            2 => 'Vet-dam',
            3 => 'Vet-mam',
        );
        
        $medicament->setNazwaLeku($param['nazwa_leku']);
        $medicament->setProducent($allowed_producent[$producent_number]);
        $date = new DateTime($param['data_utworzenia']);
        $medicament->setDataUtworzenia($date);
        $date = new DateTime($param['data_modyfikacji']);
        $medicament->setDataModyfikacji($date);

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
        $date = new DateTime($param['data_utworzenia']);
        $data->setDataUtworzenia($date);
        $date = new DateTime($param['data_modyfikacji']);
        $data->setDataModyfikacji($date);

        $em = $doctrine->getManager();
        $em->persist($data);
        $em->flush();

        return $this->json([
            "Updated succesfully!"
        ]);
    }


    #[Route('/api/delete_api/{id}', name: 'delete_api', methods:"DELETE")]
    public function delete_api(ManagerRegistry $doctrine, $id): Response
    {
        $data = $doctrine->getRepository(Lekarstwo::class)->find($id);

        $em = $doctrine->getManager();
        $em->remove($data);
        $em->flush();

        return $this->json([
            "Deleted succesfully!"
        ]);
    }


    #[Route('/api/get_api/{OrderBy}', name: 'get_api', methods:"GET")]
    public function get_api(ManagerRegistry $doctrine, $OrderBy): Response
    {
        $data = $doctrine->getRepository(Lekarstwo::class)->findBy(array(), array($OrderBy => 'ASC'));

        foreach($data as $d){
            $res [] = [
                'id' => $d->getId(),
                'nazwa_leku' => $d->getNazwaLeku(),
                'producent' => $d->getProducent(),
                'data_utworzenia' => $d->getdataUtworzenia(),
                'data_modyfikacji' => $d->getDataModyfikacji()
            ];
        }
        return $this->json([
            $res
        ]);
    }
}
