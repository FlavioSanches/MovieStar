<?php

require_once("globals.php");
require_once("db.php");
require_once("models/User.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");

$message = new Message($BASE_URL);

$userDao = new UserDAO($conn, $BASE_URL);

//Verifica o tipo de formulario

$type = filter_input(INPUT_POST, "type");

//ferificar o tipo de formulario
if($type === "register"){
    $name = filter_input(INPUT_POST, "name");
    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");
    $confirmpassword = filter_input(INPUT_POST, "confirmpassword");

    //verificação de dados mínimos

    if($name && $email && $password){
        if($password === $confirmpassword){

            //Verificar se o e-mail já esta cadastrado no sistema
            if($userDao->findByEmail($email) === false){
                $user = new User();

                //criação de token e senha
                $userToken = $user->generateToken();
                $finalPassword = $user->generatePassword($password);
                
                $user->name = $name;
                $user->email = $email;
                $user->password = $finalPassword;
                $user->token = $userToken;

                $auth = true;

                $userDao->create($user, $auth);

            }else{
                //Enviar uma msn de erro, usuario já existe
               $message->setMessage("Usuário já cadastrato tente outro e-mail.", "error", "back" );

            }

        }else{
            

            //Enviar uma msn de erro, de senhas não batem
            $message->setMessage("As senhas não são iguais.", "error", "back" );
        }
    }
    else{
        //Enviar uma msn de erro, de dados faltantes
        $message->setMessage("Por favor, preencha todos os campos.", "error", "back" );

    }
}
else if($type === "login"){
    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");

    //Tenta autenticar usúario
    if($userDao->authenticateUser($email, $password)){

        $message->setMessage("Seja bem-vindo", "success", "editprofile.php" );
    
        //Redireciona usuário caso não consiga autenticar    
    }else{
        $message->setMessage("Usuário e/ou senha incorretos.", "error", "back" );
    } 

}else {
    $message->setMessage("Informações inválidas!", "error", "index.php" );
}

