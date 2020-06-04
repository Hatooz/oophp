<?php

use Hami\MyTextFilter\MyTextFilter;

$filter = explode(',', $content->filter);
$txtFilter = new MyTextFilter();

$filteredData = $txtFilter->parse($content->data, $filter);
?>
<article>
    <header>
        <h1><?= $content->title ?></h1>
        <p><i>Latest update: <time datetime="<?= $content->modified_iso8601 ?>" pubdate><?= $content->modified ?></time></i></p>
    </header>
    <?= $filteredData ?>
</article>
