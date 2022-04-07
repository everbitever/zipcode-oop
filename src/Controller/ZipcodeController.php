<?php

namespace App\Controller;

use App\Entity\Zipcode;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ZipcodeFormType;
use App\Form\SearchFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\ZipcodeRepository;
use App\Component\ValidateZipcode;

class ZipcodeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/zipcode", name="zipcode")
     */
    public function zipcode(PaginatorInterface $paginatorInterface,
                            Request $request,
                            ZipcodeRepository $zipcodeRepository,
                            ValidateZipcode $validateZipcode
                            )
    {
        $search = '';

        $form = $this->createForm(SearchFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $validateZipcode->validateCode($form->get('search')->getData()))
        {
            $search = $form->get('search')->getData();
        }

        $query = $zipcodeRepository->getTownWithCode($search);

        $zipcode_tbl = $paginatorInterface->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('zipcode.html.twig', [
            'zipcode_tbl' => $zipcode_tbl,
            'SearchForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/zipcode/delete/{id}", name="zipcode_delete")
     */
    public function zipcode_delete(Zipcode $zipcode)
    {
        $this->entityManager->remove($zipcode);
        $this->entityManager->flush();

        $this->addFlash('success', 'Usunięte');

        return $this->redirectToRoute('zipcode');
    }

    /**
     * @Route("/zipcode/add", name="zipcode_add")
     */
    public function zipcode_add(Request $request, ValidateZipcode $validateZipcode)
    {
        $zipcode = new Zipcode();
        $form = $this->createForm(ZipcodeFormType::class, $zipcode);
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            if ($form->isValid() &&
                $validateZipcode->validateCode($form->get('code')->getData()) &&
                !$validateZipcode->validateCodeTown($form->get('code')->getData(), $form->get('town')->getData()->getName())
            )
            {
                $this->entityManager->persist($zipcode);
                $this->entityManager->flush();

                $this->addFlash('success', 'Dodano');

                return $this->redirectToRoute('zipcode');
            }
            else
            {
                $this->addFlash('error', 'Niepoprawne dane');
            }
        }

        return $this->render('zipcode_add.html.twig', [
            'ZipcodeForm' => $form->createView()
        ]);
    }
}