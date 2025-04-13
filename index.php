    <?php
        require_once("templates/header.php");

        require_once("dao/MovieDAO.php");

        $movieDao = new MovieDAO($conn, $BASE_URL);

        $latestMovies = $movieDao->getLatestMovies();

        $actionMovies = $movieDao->getMoviesByCategory("Ação");

        $comedyMovies = $movieDao->getMoviesByCategory("Comédia");

    ?>
    <div id="main-container" class="container-fluid">
        <h2 class="section-title">Filmes Novos</h2>
        <p class="section-description">Veja as críticas dos últimos filmes adcionados no MovieStar</p>
        <div class="movies-container">
            <?php foreach($latestMovies as $movie): ?>
                <?php
                    if(empty($movie->image)){
                        $movie->image = "movie_cover.jpg";
                    }
                ?>

                <div class="card movie-card">
                    <div class="card-img-top" style="background-image: url('<?= $BASE_URL?>img/movies/<?= $movie->image ?>')"></div>
                    <div class="card-body">
                        <p class="card-rating">
                            <i class="fas fa-star"></i>
                            <span class="rating">9</span>
                        </p>
                        <h5 class="card-title">
                            <a href="<?= $BASE_URL?>movie.php?id=<?= $movie->id ?>"><?= $movie->title ?></a>
                        </h5>
                        <a href="<?= $BASE_URL?>movie.php?id=<?= $movie->id ?>"" class="btn btn-primary rate-btn">Avaliar</a>
                        <a href="<?= $BASE_URL?>movie.php?id=<?= $movie->id ?>"" class="btn btn-primary card-btn">Conhecer</a>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if(count($latestMovies) === 0): ?>
                <p class="empty-list">Ainda não há filmes cadastrados!</p>
            <?php endif; ?>

        </div>
        <h2 class="section-title">Ação</h2>
        <p class="section-description">Veja os melhores filmes de ação</p>
        <div class="movies-container">
        <?php foreach($actionMovies as $movie): ?>
                <?php
                    if(empty($movie->image)){
                        $movie->image = "movie_cover.jpg";
                    }
                ?>

                <div class="card movie-card">
                    <div class="card-img-top" style="background-image: url('<?= $BASE_URL?>img/movies/<?= $movie->image ?>')"></div>
                    <div class="card-body">
                        <p class="card-rating">
                            <i class="fas fa-star"></i>
                            <span class="rating">9</span>
                        </p>
                        <h5 class="card-title">
                            <a href="<?= $BASE_URL?>movie.php?id=<?= $movie->id ?>"><?= $movie->title ?></a>
                        </h5>
                        <a href="<?= $BASE_URL?>movie.php?id=<?= $movie->id ?>"" class="btn btn-primary rate-btn">Avaliar</a>
                        <a href="<?= $BASE_URL?>movie.php?id=<?= $movie->id ?>"" class="btn btn-primary card-btn">Conhecer</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php if(count($actionMovies) === 0): ?>
            <p class="empty-list">Ainda não há filmes de ação cadastrados!</p>
        <?php endif; ?>

        </div>
        <h2 class="section-title">Comédia</h2>
        <p class="section-description">Veja os melhores filmes de comédia</p>
        <div class="movies-container">
        <?php foreach($comedyMovies as $movie): ?>
                <?php
                    if(empty($movie->image)){
                        $movie->image = "movie_cover.jpg";
                    }
                ?>

                <div class="card movie-card">
                    <div class="card-img-top" style="background-image: url('<?= $BASE_URL?>img/movies/<?= $movie->image ?>')"></div>
                    <div class="card-body">
                        <p class="card-rating">
                            <i class="fas fa-star"></i>
                            <span class="rating">9</span>
                        </p>
                        <h5 class="card-title">
                            <a href="<?= $BASE_URL?>movie.php?id=<?= $movie->id ?>"><?= $movie->title ?></a>
                        </h5>
                        <a href="<?= $BASE_URL?>movie.php?id=<?= $movie->id ?>"" class="btn btn-primary rate-btn">Avaliar</a>
                        <a href="<?= $BASE_URL?>movie.php?id=<?= $movie->id ?>"" class="btn btn-primary card-btn">Conhecer</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php if(count($comedyMovies) === 0): ?>
            <p class="empty-list">Ainda não há filmes de comédia cadastrados!</p>
        <?php endif; ?>
            


        </div>
    </div>

    <?php
        require_once("templates/footer.php");
    ?>



    

