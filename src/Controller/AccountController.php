<?php

namespace App\Controller;

use App\Repository\AccountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/accounts')]
class AccountController extends AbstractController
{
    private AccountRepository $accountRepository;

    /**
     * @param AccountRepository $accountRepository;
     */
    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    #[Route('/', name: 'account_index')]
    public function index(): Response
    {
        return $this->render('account/index.html.twig', [
            'allAccount' => $this->accountRepository->findAllAccountsWithRelations(),
        ]);
    }

    #[Route('/{id}', name: 'display_index')]
    public function display(int $id): Response
    {
        return $this->render('account/display-account.html.twig', [
            'account' => $id,
        ]);
    }
}