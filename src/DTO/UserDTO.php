<?php
	namespace App\DTO;

	use App\Entity\User;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\Validator\Constraints as Assert;
	
	class UserDTO {
		
		/**
     	 * @var string
		 */
		public $id;

		/**
     	 * @Assert\NotBlank()
     	 * @Assert\Email(
     	 * 	message = "The email '{{ value }}' is not a valid email.",
     	 * )
     	 * @var string
      	 */
		public $email;
		
		/**
     	 * @Assert\NotBlank()
     	 * @var string
     	 */
		public $password;
		
		/**
     	 * @var array
		 */
		public $roles;

		/**
		 * @param User|null $user
		 */
		public function __construct(User $user=null) {
			if($user) {
	        	$this->id = $user->getId();
	        	$this->email = $user->getEmail();
	        	$this->password = $user->getPassword();
	        	$this->roles = [];
	        	foreach ($user->getRoles() as $role) {
	        		$this->roles[] = $role;
	        	}
	        }
	        else {
	        	$this->id = null;
	        	$this->email = null;
	        	$this->password = null;
	        	$this->roles = [];
	        }
        }

		/**
		 * @param Request $request
		 * @param string $key
		 * @return UserDTO
		 */
        public static function create(Request $request, string $key = "payload") {
        	$content = $request->getContent();
        	$params = json_decode($content, true);
        	$model = new self();
        	$model->email = $params['payload']['user']['email'];
        	$model->password = $params['payload']['user']['password'];

        	return $model;
        }

	}