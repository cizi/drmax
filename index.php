<?php
libxml_use_internal_errors(true); // because of the special chars on the web URL cannot be by default converted to HTML, this is just for sure to not display a warning
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
    $dataTableData = $finder->query(Setting::XPATH_DATA_BASE . Setting::XPATH_DATA_BASE_TABLE_CLASS);
    if (!is_null($dataTableData)) {
        for ($i = 0; $i < count($dataTableData); $i++) {
          $id = $dataTableData[$i]->getAttribute('id');
          $titleLinkData = $dataTableData[$i]->getElementsByTagName('a')->item(1);
          $publicLink = $titleLinkData->getAttribute('href');
          $title = $titleLinkData->nodeValue;
          $timestamp = $finder->query(Setting::XPATH_DATA_BASE . sprintf(Setting::XPATH_DATA_ITEM_TIMESTAMP, ($i * 3 + 2)));
          $a = $finder->query(Setting::XPATH_DATA_BASE . sprintf(Setting::XPATH_DATA_ITEM_INNER_LINK, ($i * 3 + 2)));
    
          if ($timestamp->count() === 0 || $a === null) {
            continue;   // skipping record if don't find inner link or timestamp
          }
          $timestampData = $timestamp->item(0)->getAttribute('title');
          $timestampDataAsObj = DateTime::createFromFormat('Y-m-d\TH:i:s', $timestampData);
    
          // prevent to add the some item again (iz can happened during pagination if someone add new item in the web page)
          if (!isset($feedItems[$id])) {
            $fe = new FeedItem(); 
            $fe->setId($id);
            $fe->setTimestamp(DateTime::getLastErrors()['error_count'] === 0 ? $timestampDataAsObj : null);
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
  <?php
    echo "Count of object: " . count($feedItems) . "<br>";
  ?>
<pre>
    <?php
        print_r($feedItems);
    ?>
</pre>
<html>


