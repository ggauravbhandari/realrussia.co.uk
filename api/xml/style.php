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

$xml = new SimpleXMLElement('<root/>');

foreach($dom->getElementsByTagName('link') as $element) {
    if ($element->getAttribute('href')!="#" and $element->getAttribute('rel') == 'stylesheet') {
        $child = $xml->addChild('link');
        $child->addAttribute('href', $element->getAttribute('href'));
    }
}

header('Content-Type: text/xml; charset=utf-8');
echo $xml->asXML();