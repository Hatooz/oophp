<?php

/**
 * Show all movies.
 */
// $app->router->get("movie", function () use ($app) {
// $title = "Movie database | oophp";

// $app->db->connect();
// $sql = "SELECT * FROM movie;";
// $res = $app->db->executeFetchAll($sql);

// $app->page->add("movie/index", [
// "resultset" => $res,
// ]);

// return $app->page->render([
// "title" => $title,
// ]);
// });


// $app->router->get("movie/movie-edit", function () use ($app) {
// $title = "Movie database | oophp";


// $app->db->connect();
// $sql = "SELECT * FROM movie;";
// $res = $app->db->executeFetchAll($sql);

// $app->page->add("movie/index", [
// "resultset" => $res,
// ]);

// return $app->page->render([
// "title" => $title,
// ]);
// });

// $app->router->get("movie/search-title", function () use ($app) {
// $title = "Movie database | oophp";
// $searchTitle = $this->app->session->get("searchTitle");

// $app->db->connect();
// $sql = "SELECT * FROM movie WHERE title LIKE ?;";
// $res = $app->db->executeFetchAll($sql, [$searchTitle]);

// $app->page->add("movie/search-title.php", [
// "resultset" => $res,
// ]);

// return $app->page->render([
// "title" => $title,
// ]);
// });
