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
      else
      {
        echo "tu n'etais pas co";
      }
    }


        public function delete()
        {
          if (!empty($this->login)) 
          {
            
            // connexioin à la base de donnée
            $conn = mysqli_connect('localhost', 'root', '', 'classes');

            $id = $this->id;

            mysqli_query($conn, "DELETE FROM utilisateurs WHERE id = '$id'");
            echo "vous avez bien supprimé le user";
          }
          else
          {
           echo "tu n'etais pas co";
          }
        }





                // Modifier les informations de l’utilisateur en base de données.
        public function update($login, $password, $email, $firstname,$lastname)
        {
          if (!empty($this->login))
          {
                // connexioin à la base de donnée
            $conn = mysqli_connect('localhost', 'root', '', 'classes');

                  // Sécurise les input
            $login = mysqli_escape_string($conn, htmlspecialchars(trim($login)));
            $password = mysqli_escape_string($conn, htmlspecialchars(trim($password)));
            $email = mysqli_escape_string($conn, htmlspecialchars(trim($email)));
            $firstname = mysqli_escape_string($conn, htmlspecialchars(trim($firstname)));
            $lastname = mysqli_escape_string($conn, htmlspecialchars(trim($lastname)));

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
                $crypted_password = password_hash($password, PASSWORD_BCRYPT);
                $id = $this->id;

                  mysqli_query($conn, "UPDATE utilisateurs SET 
                  login='$login', password='$crypted_password', email='$email', firstname='$firstname', lastname='$lastname' WHERE id=$id");
              
              }
            }
          }
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
          if (isset($this->login))
            {
              return(['id'    => $this->id, 
                      'login' => $this->login, 
                      'password' => $this->password, 
                      'email' => $this->email, 
                      'firstname' => $this->firstname, 
                      'lastname' => $this->lastname]);
            }
             else echo "connecte toi d'abord";

            
        }

        public function getEmail()
        {
          if (isset($this->login))
          {
                return($this->email);
          }
          else echo "connecte toi d'abord";            
        }

        public function getFirstname()
        {
          if (isset($this->login))
          {
            return($this->firstname);
          }
          else echo "connecte toi d'abord";
        }

        public function getLastname()
        {
          if (isset($this->login))
          {
            return($this->lastname);
          }
          else echo "connecte toi d'abord";
        }
// rafraichier

        public function refresh()
        {
          if (!empty($this->login)) 
          {
            // conecte toi a la base de donnee -> localhost utilisateur mdp nom de base de donnee
            $connexion = mysqli_connect("localhost", "root", "", "classes");
            // fais une requete
            $query = "SELECT * FROM utilisateurs WHERE id='$this->id'";

            $ok = mysqli_query($connexion, $query);

            $info   = mysqli_fetch_assoc($ok);

            echo "in refresh <br>";

            print_r($info);

          }
          else echo "connecte toi d'abord";

        }

}

?>
   
<?php  

$user1 = new user();

echo "<pre>";
echo "register <br>";
// print_r($user1 -> register('pierre' , '123', 'p@gmail.com', 'pierrot', 'toto'));
echo "connecter <br>"; 
print_r($user1 -> connect('pierre','123'));

// $user1 -> disconnect();

// $user1 -> update('pietru' , '123', 'p@gmail.com', 'pierrot', 'nono');




// $user1-> refresh();

$user1 -> delete();




?>