<?php
header('Content-Type: application/rss+xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8" ?>';
require_once '../models/Article.php';
$articleModel = new Article();
$articles = $articleModel->fetchAllSorted();
?>
<rss version="2.0">
<channel>
    <title>Austro-Asian Times Articles</title>
    <link>http://www.example.com</link>
    <description>The latest articles from the Austro-Asian Times</description>
    <language>en-us</language>
    <?php foreach ($articles as $article): ?>
        <item>
            <title><?= htmlspecialchars($article['title']); ?></title>
            <description><?= htmlspecialchars($article['text_content']); ?></description>
            <link>http://www.example.com/articles/<?= $article['id']; ?></link>
            <guid>http://www.example.com/articles/<?= $article['id']; ?></guid>
            <pubDate><?= date(DATE_RSS, strtotime($article['creation_date'])); ?></pubDate>
        </item>
    <?php endforeach; ?>
</channel>
</rss>
