<?php

    require_once("Models/User.php");
    require_once("Models/Message.php");

    class UserDAO implements UserDAOInterface {

        private $conn;
        private $url;
        private $message;

        public function __construct(PDO $conn, $url ){
            $this->conn = $conn;
            $this->url = $url;
            $this->message = new Message($url);
        }

        public function buildUser($data){
            $user = new User();

            $user->id = $data["usu_cod"];
            $user->name = $data["usu_nome"];
            $user->email = $data["usu_email"];
            $user->password = $data["usu_senha"];
            $user->image = $data["usu_imagem"];
            $user->bio = $data["usu_bio"];
            $user->token = $data["usu_token"];

            return $user;

        }
        public function create(User $user, $authUser = false){
            $stmt = $this->conn->prepare("INSERT INTO usuario(
                usu_nome, usu_email, usu_senha, usu_token
                ) VALUES (
                    :name, :email,:password,:token
                
                )");
            
            $stmt->bindParam(":name", $user->name);
            $stmt->bindParam(":email", $user->email);
            $stmt->bindParam(":password", $user->password);
            $stmt->bindParam(":token", $user->token);

            $stmt->execute();

            // Autenticar the user if authUser is true
            if($authUser){
                $this->setTokenToSession($user->token);
            }
        }

        public function update(User $user, $redirect = true){
            $stmt = $this->conn->prepare("UPDATE usuario SET
                usu_nome = :name,
                usu_email = :email,
                usu_imagem = :image,
                usu_bio = :bio,
                usu_token = :token
                WHERE usu_cod = :id
            ");

            $stmt->bindParam(":name", $user->name);
            $stmt->bindParam(":email", $user->email);
            $stmt->bindParam(":image", $user->image);
            $stmt->bindParam(":bio", $user->bio);
            $stmt->bindParam(":token", $user->token);
            $stmt->bindParam(":id", $user->id);

            $stmt->execute();

            if($redirect){
                
                //Redirect to the user's profile
                $this->message->setMessage("Dados atualizados com sucesso!", "success", "editprofile.php");
            }
        
        }
        public function verifyToken($protected = false){
            if(isset($_SESSION["token"])){
                //Pega o token da session
                $token = $_SESSION["token"];

                $user = $this->findByToken($token);

                if($user){
                    return $user;
                }else if($protected){
                    //Redireciona usuario não autenticado
                    $this->message->setMessage("Faca a autenticação para acessar essa página!", "error", "index.php");                    
                }

            }else if($protected){
                //Redireciona usuario não autenticado
                $this->message->setMessage("Faca a autenticação para acessar essa página!", "error", "index.php");                    
            }
        }
        public function setTokenToSession($token, $redirect = true){
            //Salvar token na session
            $_SESSION["token"] = $token;

            if($redirect){
            //Redireciona para o perfil do usuario
            $this->message->setMessage("Seja bem vindo!", "success", "editprofile.php");
            }
        }
        public function authenticateUser($email, $password){
            $user = $this->findByEmail($email);
            if($user){
                //Checar se as senhas batem
                if(password_verify($password, $user->password)){
                    //Gerar um token e inserir na session
                    $token = $user->generateToken();

                    $this->setTokenToSession($token,false);

                    //Atualizar token no usuário
                    $user->token = $token;

                    $this->update($user, false);

                    return true;  


                    
                }else{
                    return false;
                }
            }else{
                return false;
            }

        }
        public function findByEmail($email){

            if($email != ""){
                $stmt = $this->conn->prepare("SELECT * FROM usuario where usu_email = :email");

                $stmt->bindParam(":email", $email);

                $stmt->execute();

                if($stmt->rowCount() > 0){
                    $data = $stmt->fetch();
                    $user = $this->buildUser($data);

                    return $user;

                }else{
                    return false;
                }
            }else{
                return false;
            }

        }
        public function findById($id){
            
        }
        public function findByToken($token){

            if($token != ""){
                $stmt = $this->conn->prepare("SELECT * FROM usuario where usu_token = :token");

                $stmt->bindParam(":token", $token);

                $stmt->execute();

                if($stmt->rowCount() > 0){
                    $data = $stmt->fetch();
                    $user = $this->buildUser($data);

                    return $user;

                }else{
                    return false;
                }
            }else{
                return false;
            }

        }
        
        public function destroyToken(){
            $_SESSION["token"] = "";

            //Redirecionar e apresentar a mensagem com sucesso
            $this->message->setMessage("Você fez o logout com sucesso!", "success", "index.php");


        }
        
        public function changePassoword(User $user){
            $stmt = $this->conn->prepare("UPDATE usuario SET 
            usu_senha = :password
            WHERE usu_cod = :id");

            $stmt->bindParam(":password", $user->password);
            $stmt->bindParam(":id", $user->id);

            $stmt->execute();

            //Redirecionar e apresentar a mensagem com sucesso
            $this->message->setMessage("Senha alterada com sucesso!", "success", "editprofile.php");
        }
    }

