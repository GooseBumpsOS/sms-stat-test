<?php
namespace App\Controller;
use App\Entity\User;
use App\Form\RegistrationFormType;
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
     * @Route("/Regist", name="add")
     */
    public function addToDataBase(UserPasswordEncoderInterface $encoder){

        $user = new User();

        $form = $this->createForm(RegistrationFormType::class, $user, [
        ]);

        return $this->render('security/regist.html.twig', [
            'post_form' => $form->createView()
        ]);



    }
    /**
     * @Route("/logout", name="logout")
     */
    public function logout(){
    }
}