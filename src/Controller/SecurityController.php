<?php
namespace App\Controller;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
class SecurityController extends AbstractController
{
    /**
     * @Route("/", name="login")
     */
    public function login(Request $request, AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $lastUserName = $utils->getLastUsername();
        return $this->render('security/index.html.twig', [
            'error' => $error,
            'last_username' => $lastUserName,
        ]);
    }
    /**
     * @Route("/add", name="add")
     */
    public function addToDataBase(UserPasswordEncoderInterface $encoder){
        $user = new User();
        $user->setUsername('two');
        $user->setPassword($encoder->encodePassword($user, '0000'));
        $user->setEmail('two2@mail.com');
        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();
        return new JsonResponse('Ok');
    }
    /**
     * @Route("/logout", name="logout")
     */
    public function logout(){
    }
}