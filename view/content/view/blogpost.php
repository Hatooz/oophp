<?php

use Hami\MyTextFilter\MyTextFilter;

$filter = explode(',', $content->filter);
$txtFilter = new MyTextFilter();

$filteredData = $txtFilter->parse($content->data, $filter);
?>

<article>
    <header>
        <h1><?= $content->title ?></h1>
        <p><i>Published: <time datetime="<?= $content->published_iso8601 ?>" pubdate><?= $content->published ?></time></i></p>
    </header>
    <?= $filteredData ?>
</article>
