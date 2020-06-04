<?php
// Get essentials
// require "src/autoload.php";
// require "src/config.php";
// require "src/function.php";

// Get incoming

use Hami\Content\Content;

$contentManager = new Content();

$route = $contentManager->getGet("route", "");

// General variabels (available to the views)
$titleExtended = " | My Content Database";
$view = [];
// $db = new Database();
$app->db->connect();
$sql = null;
$resultset = null;

// Simple router
switch ($route) {
    case "":
        $title = "Show all content";
        $view[] = "view/show-all.php";
        $sql = "SELECT * FROM content;";
        $resultset = $app->db->executeFetchAll($sql);
        break;

    case "reset":
        $title = "Resetting the database";
        $view[] = "view/reset.php";
        break;

    case "admin":
        $title = "Admin content";
        $view[] = "view/admin.php";
        $sql = "SELECT * FROM content;";
        $resultset = $app->db->executeFetchAll($sql);
        break;

    case "edit":
        $title = "Edit content";
        $view[] = "view/edit.php";
        $contentId = $contentManager->getPost("contentId") ?: $contentManager->getGet("id");
        if (!is_numeric($contentId)) {
            die("Not valid for content id.");
        }

        if ($contentManager->hasKeyPost("doDelete")) {
            header("Location: ?route=delete&id=$contentId");
            exit;
        } elseif ($contentManager->hasKeyPost("doSave")) {
            $params = $contentManager->getPost([
                "contentTitle",
                "contentPath",
                "contentSlug",
                "contentData",
                "contentType",
                "contentFilter",
                "contentPublish",
                "contentId"
            ]);

            if (!$params["contentSlug"]) {
                $params["contentSlug"] = $contentManager->slugify($params["contentTitle"]);
            }

            if (!$params["contentPath"]) {
                $params["contentPath"] = null;
            }
            $myslugsql = "SELECT slug FROM content WHERE slug = ?";
            $myslug = $app->db->executeFetch($myslugsql, [$params['contentSlug']]);

            if ($myslug != null) {
                $params['contentSlug'] = $params['contentSlug'] . '-2';
            }

            $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
            $app->db->execute($sql, array_values($params));
            header("Location: ?route=edit&id=$contentId");
            exit;
        }

        $sql = "SELECT * FROM content WHERE id = ?;";
        $content = $app->db->executeFetch($sql, [$contentId]);
        break;

    case "create":
        $title = "Create content";
        $view[] = "view/create.php";

        if ($contentManager->hasKeyPost("doCreate")) {
            $title = $contentManager->getPost("contentTitle");

            $sql = "INSERT INTO content (title) VALUES (?);";
            $app->db->execute($sql, [$title]);
            $id = $app->db->lastInsertId();
            header("Location: ?route=edit&id=$id");
            exit;
        }
        break;

    case "delete":
        $title = "Delete content";
        $view[] = "view/delete.php";
        $contentId = $contentManager->getPost("contentId") ?: $contentManager->getGet("id");
        if (!is_numeric($contentId)) {
            die("Not valid for content id.");
        }

        if ($contentManager->hasKeyPost("doDelete")) {
            $contentId = $contentManager->getPost("contentId");
            $sql = "UPDATE content SET deleted=NOW() WHERE id=?;";
            $app->db->execute($sql, [$contentId]);
            header("Location: ?route=admin");
            exit;
        }

        $sql = "SELECT id, title FROM content WHERE id = ?;";
        $content = $app->db->executeFetch($sql, [$contentId]);
        break;

    case "pages":
        $title = "View pages";
        $view[] = "view/pages.php";

        $sql = <<<EOD
SELECT
    *,
    CASE 
        WHEN (deleted <= NOW()) THEN "isDeleted"
        WHEN (published <= NOW()) THEN "isPublished"
        ELSE "notPublished"
    END AS status
FROM content
WHERE type=?
;
EOD;
        $resultset = $app->db->executeFetchAll($sql, ["page"]);
        break;

    case "blog":
        $title = "View blog";
        $view[] = "view/blog.php";

        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM content
WHERE type=?
ORDER BY published DESC
;
EOD;
        $resultset = $app->db->executeFetchAll($sql, ["post"]);
        break;

    default:
        if (substr($route, 0, 5) === "blog/") {
            //  Matches blog/slug, display content by slug and type post
            $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM content
WHERE 
    slug = ?
    AND type = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
ORDER BY published DESC
;
EOD;
            $slug = substr($route, 5);
            $content = $app->db->executeFetch($sql, [$slug, "post"]);
            if (!$content) {
                header("HTTP/1.0 404 Not Found");
                $title = "404";
                $view[] = "view/404.php";
                break;
            }
            $title = $content->title;
            $view[] = "view/blogpost.php";
        } else {
            // Try matching content for type page and its path
            $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS modified_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS modified
FROM content
WHERE
    path = ?
    AND type = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
;
EOD;
            $content = $app->db->executeFetch($sql, [$route, "page"]);
            if (!$content) {
                header("HTTP/1.0 404 Not Found");
                $title = "404";
                $view[] = "view/404.php";
                break;
            }
            $title = $content->title;
            $view[] = "view/page.php";
        }
};

// Render the page
require "view/header.php";
foreach ($view as $value) {
    require $value;
}
require "view/footer.php";
