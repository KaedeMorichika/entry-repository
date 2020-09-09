<?php
try {
    $url = 'https://www.nikkansports.com/baseball/professional/atom.xml';

    header('Access-Control-Allow-Origin: https://www.nikkansports.com/baseball/professional/atom.xml');
    header('Access-Control-Allow-Headers: "X-Requested-With, Origin, X-Csrftoken, Content-Type, Accept"');

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);

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

    header('Content-Type: text/json; charset=utf-8');
    echo(json_encode($articles));

} catch (Exception $e) {
    $status = 'FAILED';
}
