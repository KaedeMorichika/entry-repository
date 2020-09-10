<?php
try {
    $url = 'https://www.nikkansports.com/baseball/professional/atom.xml';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $xml = simplexml_load_string($response);
    curl_close($ch);

    $articles = [];

    foreach ($xml->entry as $article) {
        $contents = [];
        $contents['title'] = $article->title;
        $contents['url'] = $article->id;
        $contents['summary'] = $article->summary;
        $contents['author'] = $article->author;

        $articles[] = $contents;
    }

    sleep(3);

    header('Content-Type: text/json; charset=utf-8');
    echo(json_encode($articles));

} catch (Exception $e) {
    $status = 'FAILED';
}
