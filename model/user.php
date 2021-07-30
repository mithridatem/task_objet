<?php
    class User{
        private $id_user;
        private $name_user;
        private $first_name_user;
        private $login_user;
        private $mdp_user;
        /*-----------------------------------------------------
                            constucteur :
        -----------------------------------------------------*/        
        public function __construct($name_user, $first_name_user, $login_user, $mdp_user)
        {   $this->name_user = $name_user;
            $this->first_name_user = $first_name_user;
            $this->login_user = $login_user;
            $this->mdp_user = $mdp_user;
        }

        /*-----------------------------------------------------
                        Getter and Setter :
        -----------------------------------------------------*/
        public function getIdUser(){
            return $this->id_user;
        }
        public function setIdUser($newIdUser){
            $this->id_user = $newIdUser;
        }
        /*-----------------------------------------------------
                            Fonctions :
        -----------------------------------------------------*/
        public function createUser($bdd){
            //récuparation des paramètres
            $name_user = $this->name_user;
            $first_name_user = $this->first_name_user;
            $login_user = $this->login_user;
            $mdp_user = $this->mdp_user;
            
            try
            {
                $req = $bdd->prepare('INSERT INTO user(name_user, first_name_user, login_user, mdp_user) 
                VALUES (:name_user, :first_name_user, :login_user, :mdp_user)');
                //éxécution de la requête SQL
                $req->execute(array(
                'name_user' => $name_user,
                'first_name_user' => $first_name_user,
                'login_user' => $login_user,
                'mdp_user' => $mdp_user,                                                                 
            ));
            }
            catch(Exception $e)
            {
            //affichage d'une exception en cas d’erreur
            die('Erreur : '.$e->getMessage());
            }
        
        }
}

?>