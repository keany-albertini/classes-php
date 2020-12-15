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
		// conecte toi a la base de donnee
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
  						// définir le nouvel attribut
  						$this->login=$login;
  						$this->password=$crypted_password;
  						$this->email=$email;
  						$this->firstname=$firstname;
  						$this->lastname=$lastname;
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
        // on verifier si le login et le password qui  existe est juste
        $ok = mysqli_query($conn, "SELECT * FROM utilisateurs WHERE login='$login' && password='$password'");
        $info   = mysqli_fetch_assoc($ok);
        if (isset($info)) 
        {

            $this->id        = $info["id"];
            $this->login     = $info["login"];
        	$this->password  = $info["password"];
            $this->email     = $info["email"];
            $this->firstname = $info["firstname"];
            $this->lastname  = $info["lastname"];
        }
    return([$this->id, $this->login, $this->password, $this->email, $this->firstname, $this->lastname]);
    }

         // Déconnecte l’utilisateur.
    public function disconnect()
    {
        $this->login        = null;
        $this->password     = null;
        $this->email        = null;
        $this->firstname    = null;
        $this->lastname     = null;
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
   
