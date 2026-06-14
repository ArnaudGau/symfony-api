<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $data = json_decode($request->getContent(), true);
        $rawContent = $request->getContent();
        $data = json_decode($rawContent, true);

        $form->submit($data, false);
        if ($form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $data['plainPassword'] ?? null;


            if (!$plainPassword) {
                return $this->json(['error' => 'Le mot de passe est manquant dans la requête.'], 400);
            }

            // encode the plain password
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->json([
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'roles' => $user->getRoles(),
            ], Response::HTTP_CREATED);
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    private function isJsonRequest(Request $request): bool
    {
        if ($request->getContentTypeFormat() === 'json') {
            return true;
        }

        $content = trim($request->getContent());

        return $request->isMethod('POST') && str_starts_with($content, '{');
    }
}
