<?php
    testConnexion();
    function testConnexion(){
        if(isset($_POST['login']) AND isset($_POST['mdp']) 
        AND !empty($_POST['login']) AND !empty($_POST['mdp']))
        {            
            $login = htmlspecialchars($_POST['login']);
            $mdp = $_POST['mdp'];
            $nom = "";
            $prenom="";       
            //création d'un nouvel objet utilisateur  
            $util = new Utilisateur($nom, $prenom,$login, $mdp);
            //fonction encodage mot de passe et suppression injection sql
            $mdp = $util->cryptMdp($mdp);
            //enregistrement du mot de passe
            $util->setMdp($mdp);                        
            //récupération du mdp utilisateur
            $mdp = $util->getMdp();
            try
            {   
                //connexion à la base de données
                include('utils/connectBdd.php');
                //requete pour stocker le contenu de toute la table
                $reponse = $bdd->query('SELECT * FROM utilisateur WHERE login_user = "'.$login.'"');
                //boucle pour parcourir et afficher le contenu de chaque ligne de la table
                while ($donnees = $reponse->fetch())
                {   
                    //test si le login existe
                    if($login == $donnees['login_user'])
                    {   //création de la variable $loginok si le login existe
                        $loginok=1;                           
                    }                               
                }
                //test si le login n'existe pas
                if(!isset($loginok))
                {
                    header("Location: index.php?cpterror");
                }
                //test si le login existe vérification du mot de passe
                if(isset($loginok))
                {   
                    //connexion à la base de données
                    include('utils/connectBdd.php');
                    //requete pour stocker le contenu de toute la table
                    $reponse = $bdd->query('SELECT * FROM utilisateur WHERE login_user = "'.$login.'" AND mdp_user="'.$mdp.'"');
                    //boucle pour parcourir et afficher le contenu de chaque ligne de la table
                    while ($donnees = $reponse->fetch())
                    {   
                        //test si le login et le mot de passe sont valide si ok affichage du login et du password
                        if($login == $donnees['login_user'] AND $mdp == $donnees['mdp_user'])
                        {   
                            $nomUser = $donnees['nom_user'];
                            $prenom= $donnees['prenom_user'];
                            $logreq = $donnees['login_user'];
                            $mdpreq = $donnees['mdp_user'];                                
                            //stockage de l'id utilisateur
                            $idutilsat = $donnees['id_user'];
                            session_start();
                            $_SESSION['login'] = $logreq;
                            $_SESSION['mdp'] = $mdpreq;
                            $_SESSION['nom'] = $nomUser;
                            $_SESSION['id'] = $idutilsat;
                            $_SESSION['connected'] = true;
                            $connect=1;
                            //redirection si connecté
                            header("Location: index.php?connect");                                                       
                        }                                                                             
                    }
                }
                //test si le login existe et le mot de passe est incorrect
                if(isset($loginok) AND !isset($connect))
                {
                    header("Location: index.php?mdperror");
                }                                  
            }
            catch(Exception $e)
            {   //affichage d'une exception
                die('Erreur : '.$e->getMessage());
            } 
        }
        //test si le champ login est vide
        if(isset($_POST['login']) AND empty($_POST['login']))
        {
            header("Location: index.php?logerror");
        }
        //test si le champ mot de passe est vide
        if(isset($_POST['mdp']) AND empty($_POST['mdp']))
        {
            header("Location: index.php?nomdperror");
        }
    }
?>