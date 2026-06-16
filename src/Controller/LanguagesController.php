<?php

namespace App\Controller;

use App\Repository\LanguagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Dto\CreateLanguageDto;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Security\Http\Attribute\IsGranted;



final class LanguagesController extends AbstractController
{
    private LanguagesRepository $languagesRepository;

    public function __construct(LanguagesRepository $languagesRepository)
    {
        $this->languagesRepository = $languagesRepository;
    }

    #[Route('/api/languages', name: 'app_languages')]
    public function index(): Response
    {
        $languages = $this->languagesRepository->findAll();

        return $this->json($languages, 200, [], [
            'groups' => ['language:read']
        ]);
    }

    #[Route('api/admin/languages', name:'admin_create_language', methods:['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function create(#[MapRequestPayload] CreateLanguageDto $dto): Response
    {
        $languages = $this->languagesRepository->create($dto);
        return $this->json($languages, Response::HTTP_CREATED, [], [
            'groups' => ['language:read']
        ]);
    }
}
