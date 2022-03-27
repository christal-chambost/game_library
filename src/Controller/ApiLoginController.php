<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ApiLoginController extends AbstractController
{
    /**
     * @Route("/api/login", name="app_api_login")
     */
    public function index(CurrentUser $CurrentUser, ?User $user): Response
    {
        if (null === $user) {
                return $this->json([
                  'message' => 'identifiant ou mot de passe incorrect',
                ], Response::HTTP_UNAUTHORIZED);
        }
            
        $token; // somehow create an API token for $user

        return $this->json([
            'user'  => $user->getUserIdentifier(),
            'token' => $token,
        ]);
    }
}
