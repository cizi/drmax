<?php

require_once "./Setting.php";
require_once "./FeedItem.php";

$paginator = 1;
$feedItems = [];
do {
    $linkToDownload = Setting::URL . Setting::PAGE_PARAM . $paginator;

    $html = file_get_contents($linkToDownload);
    if ($html === false) {
        die("Wrong URL");
    }

    $dom = new DOMDocument();
    $dom->loadHTML($html);
    $finder = new DOMXPath($dom);
    $dataTableData = $finder->query('//table[contains(@class,"itemlist")]/tr[contains(@class,"athing")]');
    if (!is_null($dataTableData)) {
        for ($i = 0; $i < count($dataTableData); $i++) {
          $id = $dataTableData[$i]->getAttribute('id');
          $titleLinkData = $dataTableData[$i]->getElementsByTagName('a')->item(1);
          $publicLink = $titleLinkData->getAttribute('href');
          $title = $titleLinkData->nodeValue;
          $timestamp = $finder->query('//table[contains(@class,"itemlist")]/tr[' . ($i * 3 + 2) . ']/td[2]/span/span[2]');
          $a = $finder->query('//table[contains(@class,"itemlist")]/tr[' . ($i * 3 + 2) . ']/td[2]/span/span[2]/a');
    
          if ($timestamp->count() === 0 || $a === null) {
            continue;
          }
          // 2022-11-02T08:28:21
          $timestampData = $timestamp->item(0)->getAttribute('title');
          $timestampDataAsObj = DateTime::createFromFormat('Y-m-d\TH:i:s', $timestampData);
    
          // prevent to add the some item again (iz can happened during pagination if someone add new item in the web page)
          if (!isset($feedItems[$id])) {
            $fe = new FeedItem(); 
            $fe->setId($id);
            $fe->setTimestamp($timestampDataAsObj);
            $fe->setInnerLink(Setting::URL . $a->item(0)->getAttribute('href'));
            $fe->setPublicLink($publicLink);
            $fe->setTitle($title);
    
            $feedItems[$id] = $fe;  
          }
        }
        $paginator++;
    } else {
        break;
    }
} while (count($feedItems) < Setting::COUNT);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<pre>
    <?php
        echo "Count of object: " . count($feedItems) . "<br>";
        print_r($feedItems);
    ?>
</pre>
<html>


