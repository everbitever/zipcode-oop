<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Town;
use App\Form\TownFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use App\Component\ValidateTown;
use App\Repository\ZipcodeRepository;

class TownController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/town", name="town")
     */
    public function town(PaginatorInterface $paginatorInterface, Request $request)
    {
        $query = $this->entityManager->getRepository(Town::class)->findBy([], ['name' => 'ASC']);

        $town_tbl = $paginatorInterface->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('town.html.twig', [
            'town_tbl' => $town_tbl
        ]);
    }

    /**
     * @Route("/town/delete/{id}", name="town_delete")
     */
    public function town_delete(int $id, Town $town, ZipcodeRepository $zipcodeRepository)
    {
        $zipcodeRepository->deleteAllCodeWithTown($id);

        $this->entityManager->remove($town);
        $this->entityManager->flush();

        $this->addFlash('success', 'Usunięte');

        return $this->redirectToRoute('town');
    }

    /**
     * @Route("/town/add", name="town_add")
     */
    public function town_add(Request $request, ValidateTown $validateTown)
    {
        $town = new Town();
        $form = $this->createForm(TownFormType::class, $town);
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            if ($form->isValid() && !$validateTown->validateDuplication($form->get('name')->getData()))
            {
                $this->entityManager->persist($town);
                $this->entityManager->flush();

                $this->addFlash('success', 'Dodano');

                return $this->redirectToRoute('town');
            }
            else
            {
                $this->addFlash('error', 'Niepoprawne dane');
            }
        }

        return $this->render('town_add.html.twig', [
            'TownForm' => $form->createView()
        ]);
    }
}