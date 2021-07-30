<?php
    class util{
        /*-----------------------------------------------------
                            attributs :
        -----------------------------------------------------*/
        protected $id_util;
        protected $name_util;
        protected $first_name_util;
        protected $login_util;
        protected $mdp_util;

        /*-----------------------------------------------------
                            constucteur :
        -----------------------------------------------------*/        
        public function __construct($name_util, $first_name_util, $login_util, $mdp_util)
        {   $this->name_util = $name_util;
            $this->first_name_util = $first_name_util;
            $this->login_util = $login_util;
            $this->mdp_util = $mdp_util;
        }

        /*-----------------------------------------------------
                        Getter and Setter :
        -----------------------------------------------------*/
        //Getter id_util
        public function getIdUtil()
        {
            return $this->id_util;
        }
        //Setter id_util
        public function setIdUser($new_id_util)
        {
            $this->id_util = $new_id_util;
        }
        //Getter name_util
        public function getNameUtil()
        {
            return $this->$name_util;
        }
        //Setter name_util
        public function setNameUtil($new_name_util)
        {
            $this->name_util = $new_name_util;
        }
        //Getter first_name_util
        public function getFirstNameUtil()
        {
            return $this->first_name_util;
        }
        //Setter first_name_util
        public function setFirstNameUtil($new_first_name_util)
        {
            $this->first_name_util = $new_first_name_util;
        }
        //Getter login_util
        public function getLoginUtil()
        {
            return $this->$login_util;
        }
        //Setter login_util
        public function setLoginUtil($new_login_util)
        {
            $this->login_util = $new_login_util;
        }
        //Getter mdp_util
        public function getMdpUtil()
        {
            return $this->mdp_util;
        }
        //Setter mdp_util
        public function setMdpUtil($new_mdp_util)
        {
            $this->mdp_util = $new_mdp_util;
        }

        /*-----------------------------------------------------
                            Fonctions :
        -----------------------------------------------------*/
        //fonction encodage mot de passe en md5
        public function cryptMdp($mdp_util){
            //suppression injection sql en js
            $mdp_util = htmlspecialchars($mdp_util);
            //retour encodage en md5
            return md5($mdp_util);
        }
        //fonction affichage des informations
        public function showUser($name_util, $first_name_util, $login_util, $mdp_util){
            $mess= "Utilisateur ajouté à la BDD : <br>Nom : '.$name_util.' Prenom : '.$first_name_util.' 
            Login : '.$login_util.' Mot De Passe : '.$mdp_util.'";
            echo "$mess";
        }
        //fonction insertion d'un utilisateur en BDD
        public function createUtil($name_util, $first_name_util, $login_util, $mdp_util, $bdd){                                 
            //préparation de la requête SQL
            $req = $bdd->prepare('INSERT INTO utilisateur(nom_util, first_name_util, login_util, mdp_util) 
            VALUES (:name_util, :first_name_util, :login_util, :mdp_util)');
            //éxécution de la requête SQL
            $req->execute(array(
            'name_util' => iconv("UTF-8", "ISO-8859-1//TRANSLIT", $name_util),
            'first_name_util' => iconv("UTF-8", "ISO-8859-1//TRANSLIT", $first_name_util),
            'login_util' => iconv("UTF-8", "ISO-8859-1//TRANSLIT", $login_util),
            'mdp_util' => iconv("UTF-8", "ISO-8859-1//TRANSLIT", $mdp_util),                                                                 
            ));
            $mess = 'le compte : '.$name_util.' '.$first_name_util.' à était ajouté !!!';
            echo '<div class="alert  alert-warning" role="alert"></div>
                    </div>';
            echo '<script>
                console.log("message erreur")
                let divToast = document.querySelector(".alert")            
                divToast.innerHTML = "'.$mess.'"
            </script>';
            //fermeture de la connexion à la bdd
            $req->closeCursor();                          
        }           
    }



ion

?>