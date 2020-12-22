<?php



// Création d'une classe
class user 
{
	// atribut de la classe 
	private $id;
	public $login;
	public $password;
	public $email;
	public $firstname;
	public $lastname;

	// création d'une fonction
	
	public	function  register($login, $password, $email, $firstname, $lastname)
	{
		// conecte toi a la base de donnee -> localhost utilisateur mdp nom de base de donnee
		$connexion = mysqli_connect("localhost", "root", "", "classes");

		// Sécurise les input
		$login = mysqli_escape_string($connexion, htmlspecialchars(trim($login)));
		$password = mysqli_escape_string($connexion, htmlspecialchars(trim($password)));
		$email = mysqli_escape_string($connexion, htmlspecialchars(trim($email)));
		$firstname = mysqli_escape_string($connexion, htmlspecialchars(trim($firstname)));
		$lastname = mysqli_escape_string($connexion, htmlspecialchars(trim($lastname)));

		// vide ou pas ?
		if (!empty($login) && !empty($password) && !empty($email) && !empty($firstname) && !empty($lastname)) 
		{
			// récupere la taille 
			$strlen_login = strlen($login);
			$strlen_password = strlen($password);
			$strlen_email = strlen($email);
			$strlen_firstname = strlen($firstname);
			$strlen_lastname = strlen($lastname);

			// verifier la longueur 
			if ($strlen_login<=255 &&  $strlen_password<=255 && $strlen_email<=255 && $strlen_firstname<=255 &&   $strlen_lastname<=255) 
			{
				// selectionne le login de la table utilisateur quand le login est egale au login rentré
				$requete = "SELECT login FROM utilisateurs WHERE login = '$login'";

				// execute la requete 
  				$query = mysqli_query($connexion,$requete);

  				// La mysqli_num_rows () renvoie le nombre de lignes dans un ensemble de résultats   en bouléen 
  				$resultat = mysqli_num_rows($query);

  				// si il n'existe pas
  				if (!$resultat) 
  				{
  					// crypter le mdp
  					$crypted_password = password_hash($password, PASSWORD_BCRYPT);

  					//  inserer les valeur
  					$insert = mysqli_query($connexion,"INSERT INTO utilisateurs(login, password, email, firstname, lastname) VALUES('$login', '$crypted_password', '$email', '$firstname', '$lastname') ");
  					if ($insert) 
  					{
  						// // définir le nouvel attribut
  						// $this->login=$login;
  						// $this->password=$crypted_password;
  						// $this->email=$email;
  						// $this->firstname=$firstname;
  						// $this->lastname=$lastname;


              $infouser = array('login' =>$login,
                                'password' => $crypted_password,
                                'email' => $email,
                                'firstname' => $firstname,
                                'lastname' => $lastname);
              return $infouser;

  					}
  				}
  				else{
  					echo "login déjà existant";
  				}
			}
		}
	}

	
    public function connect($login, $password)
    {
        // connexioin à la base de donnée
        $conn = mysqli_connect('localhost', 'root', '', 'classes');

        // Sécurise les input
        $login = mysqli_escape_string($conn, htmlspecialchars(trim($login)));
        $password = mysqli_escape_string($conn, htmlspecialchars(trim($password)));

        // vide ou pas ?
        if (!empty($login) && !empty($password)) 
        {
          // récupere la taille 
          $strlen_login = strlen($login);
          $strlen_password = strlen($password);

          if ($strlen_login<=255 &&  $strlen_password<=255) 
          {
            // on verifier si le login et le password qui  existe est juste
            $ok = mysqli_query($conn, "SELECT * FROM utilisateurs WHERE login='$login'");

            $info   = mysqli_fetch_assoc($ok);

            // DEBUG
            // print_r($info);

            if (password_verify($password, $info['password'])) 
            {
             
              $this->id        = $info["id"];
              $this->login     = $info["login"];
            	$this->password  = $info["password"];
              $this->email     = $info["email"];
              $this->firstname = $info["firstname"];
              $this->lastname  = $info["lastname"];
            }
            return($infouser = array('id'       =>$info["id"], 
                                     'login'    =>$info["login"],
                                     'password' =>$info["password"],
                                     'email'    =>$info["email"],
                                     'firstname'=>$info["firstname"],
                                     'lastname' =>$info["lastname"]));

              
          }   
        }
      }

         // Déconnecte l’utilisateur.
    public function disconnect()
    {
      if (!empty($this->login)) 
      {
        $this->id           = null;
        $this->login        = null;
        $this->password     = null;
        $this->email        = null;
        $this->firstname    = null;
        $this->lastname     = null;
        echo "tu es deco";
      }
      else{
        echo "tu n'etais pas co";
      }
    }


        public function delete()
        {
            // connexioin à la base de donnée
            $conn = mysqli_connect('localhost', 'root', '', 'classes');
            $login = $this->login;
            mysqli_query($conn, "DELETE FROM utilisateurs WHERE login = '$login'");
            echo "vous avez bien supprimer le user";
        }

                // Modifier les informations de l’utilisateur en base de données.
        public function update($login, $password, $email, $firstname,$lastname)
        {
            // connexion à la base de donnée
            $conn   = mysqli_connect('localhost', 'root', '', 'classes');
                $ancien_login  = $this->login;
                $this->login        = $login;
                $this->password     = $password;
                $this->email        = $email;
                $this->firstname    = $firstname;
                $this->lastname     = $lastname;
                mysqli_query($conn, "UPDATE utilisateurs SET 
                login='$login', password='$password', email='$email', firstname='$firstname', lastname='$lastname' WHERE login='$ancien_login'");
        }

         public function isConnected()
         {
            if (isset($this->login))
            {
                  $connected = true;
            }
            else $connected = false;

            return($connected);
        }

        public function getAllInfos()
        {
            return(['id' => $this->id, 
            'login' => $this->login, 
            'login' => $this->password, 
            'login' => $this->email, 
            'login' => $this->firstname, 
            'login' => $this->lastname]);
        }

        public function getEmail()
        {
            return($this->email);
        }

        public function getFirstname()
        {
            return($this->firstname);
        }

        public function getLastname()
        {
            return($this->lastname);
        }

}

?>
   
<?php  

$user1 = new user();

echo "<pre>";

// print_r($user1 -> register('pierre2' , '123', 'p@gmail.com', 'pierrot', 'toto'));

// print_r($user1 -> connect('pierre2','123'));

$user1 -> disconnect();



?>