<?php

namespace App\Controller;

use App\ExceptionHandler\CustomAppException;
use App\Manager\UserManager;
use App\Utils\JsonSuccessResponseModel;
use App\Utils\JsonErrorResponseModel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

//use App\Model\UserRegistrationModel;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Service\RegistrationManager;

/**
 * Class SecurityController
 */
class SecurityController extends Controller
{
		/**
		 * @Route("/signup", name="signUp", options={"expose" = true})
		 * @Method({"POST"})
		 * @param RegistrationManager $registrationManager
		 * @param Request $request
		 * @return Response
		 */
		public function signUpAction(RegistrationManager $registrationManager, Request $request) {
			try {
				$payload = $registrationManager->createNewUser($request);
				$data = new JsonSuccessResponseModel($payload);
			}
			catch(CustomAppException $e) {
    			$data = new JsonErrorResponseModel([], $e->getMessage());
			}
			return $this->json($data);
		}

		/**
		 * @Route("/logout", name="logOut", options={"expose" = true})
		 * @Method({"GET"})
		 */
		public function logOutAction() {
			return $this->json('data');
		}

		/**
		 * @Route("/login", name="logIn", options={"expose" = true})
		 * @Method({"POST"})
		 * @param RegistrationManager $registrationManager
		 * @param Request $request
		 * @return Response
		 */
		public function logInAction(RegistrationManager $registrationManager, Request $request) {
			try {
				$payload = $registrationManager->getCurrentUser();
				$data = new JsonSuccessResponseModel($payload);
			}
			catch(CustomAppException $e) {
    			$data = new JsonErrorResponseModel([], $e->getMessage());
			}
			return $this->json($data);
		}

		/**
		 * @Route("/checkauth", name="getCurrentUser", options={"expose" = true})
		 * @Method({"GET"})
		 * @param RegistrationManager $registrationManager
		 * @return Response
	 	 */
		public function checkAuthAction(RegistrationManager $registrationManager) {
			try {
				$payload = $registrationManager->getCurrentUser();
				$data = new JsonSuccessResponseModel($payload);
			}
			catch(CustomAppException $e) {
    			$data = new JsonErrorResponseModel([], $e->getMessage());
			}
			return $this->json($data);
		}
}