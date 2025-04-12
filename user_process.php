<?php

  require_once("globals.php");
  require_once("db.php");
  require_once("models/User.php");
  require_once("models/Message.php");
  require_once("dao/UserDAO.php");

  $message = new Message($BASE_URL);

  $userDao = new UserDAO($conn, $BASE_URL);

  // Resgata o tipo de formulário
  $type = filter_input(INPUT_POST, "type");

  //Atualizae usuário
  if($type === "update"){

    // Resgata dados do usuário
    $userData = $userDao->verifyToken();

    // Resgata dados do post
    $name = filter_input(INPUT_POST, "name");
    $email = filter_input(INPUT_POST, "email");
    $bio = filter_input(INPUT_POST, "bio");
    
    //Criar um novo objeto de usuário
    $user = new User();

    $userData->name = $name;
    $userData->email = $email;
    $userData->bio = $bio;

    //Upload de imagem
    if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"]))
    {
        $image = $_FILES["image"];
        $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
        $jpgArray = ["image/jpeg", "image/jpg"];

        //checagem de tipo de imagem
        if(in_array($image["type"], $imageTypes)){

            //checar se jpg
            if(in_array($image,$jpgArray)){

                $imageFile = imagecreatefromjpeg($image["tmp_name"]);
            //Imagem é png
            }else{
                $imageFile = imagecreatefrompng($image["tmp_name"]);
            }

            $imageName = $user->imageGenerateName();

            imagejpeg($imageFile, "./img/user/" . $imageName, 100);

            $userData->image = $imageName;

        }
        else{
            $message->setMessage("Tipo inválido de imagem, insira png ou jpg!", "error", "back" );
        }
    }

    $userDao->update($userData);




  // Atualizar saneha de usuário
  } else if($type === "changepassword"){

      //Receber dados do post
      $password = filter_input(INPUT_POST, "password");
      $confirmpassword = filter_input(INPUT_POST, "confirmpassword");
      $userData = $userDao->verifyToken();

      $id = $userData->id;

      if($password == $confirmpassword){

       //Criar um novo objeto de usuário
       $user = new User();

       $finalPassword = $user->generatePassword($password);

       $user->password = $finalPassword;
       $user->id = $id;

       $userDao->changePassoword($user);


       }else{

          $message->setMessage("As senhas não são iguais!", "error", "back" );

       }

    }else{

       $message->setMessage("Informações inválidas!", "error", "index.php" );

    }