<?php

namespace App\Controller;

use App\Dto\CreateLanguageDto;
use App\Entity\Languages;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class LanguagesController extends BaseCrudController
{
    protected function entityClass(): string
    {
        return Languages::class;
    }

    protected function getDtoCreate(): string
    {
        return CreateLanguageDto::class;
    }

    protected function getReadGroups(): array
    {
        return ['language:read'];
    }

    #[Route('/api/languages', name: 'app_languages', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return parent::index();
    }

    #[Route('/api/admin/languages', name: 'admin_create_language', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function create(Request $request): JsonResponse
    {
        return parent::create($request);
    }
}
