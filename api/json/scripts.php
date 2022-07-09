<?php
$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);

$html = file_get_contents('https://new.realrussia.co.uk/layout-template', false, stream_context_create($arrContextOptions));
$dom = new DOMDocument;
@$dom->loadHTML($html);

$jsonData = [];

foreach($dom->getElementsByTagName('script') as $script)
{
    if (! empty($script->getAttribute('src'))) {
        $jsonData['scripts'][] = $script->getAttribute('src') ;
    }
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($jsonData);