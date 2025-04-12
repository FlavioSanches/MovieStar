<?php

    require_once("models/Movie.php");
    require_once("models/Message.php");

    //Review DAO

    class MovieDAO implements MovieDAOInterface{

        private $conn;
        private $url;
        private $message;

        public function __construct(PDO $conn, $url){
            $this->conn = $conn;
            $this->url = $url;
            //$this->message = $message;
            $this->message = new Message($url);

            

        }

        public function buildMovie($data){
            
            $movie = new Movie();

            $movie->id = $data["fil_cod"];
            $movie->title = $data["fil_titulo"];
            $movie->description = $data["fil_descricao"];
            $movie->image = $data["fil_imagem"];
            $movie->trailer= $data["fil_trailer"];
            $movie->category = $data["fil_categoria"];
            $movie->user_id = $data["usuario_usu_cod"];

            return $movie;

        }

        public function findAll(){

        }

        public function getLatesMovies(){

        }

        public function getMoviesByCategory($category){

        }

        public function getMoviesByUserId($id){

        }

        public function findById($id){

        }

        public function findByTitle($title){

        }

        public function create(Movie $movie){

            $stmt = $this->conn->prepare("INSERT INTO filme (
            fil_titulo,fil_descricao,fil_imagem,fil_trailer,fil_categoria, usuario_usu_cod
            ) VALUES (
                :title, :description, :image, :trailer, :category, :users_id
            )");

            $stmt->bindParam(":title", $movie->title);
            $stmt->bindParam(":description", $movie->description);
            $stmt->bindParam(":image", $movie->image);
            $stmt->bindParam(":trailer", $movie->trailer);
            $stmt->bindParam(":category", $movie->category);
            $stmt->bindParam(":users_id", $movie->user_id);

            $stmt->execute();

            //Mensagem de sucesso por adicionar filme
            $this->message->setMessage("Filme adcionado com sucesso!", "success", "index.php");

        }

        public function update(Movie $movie){

        }

        public function destroy($id){

        }

        

    }
