<?php

class Setting {

    public const URL = "https://news.ycombinator.com/";

    public const COUNT = 100;

    public const PAGE_PARAM = "news?p=";

    public const XPATH_DATA_BASE = '//table[contains(@class,"itemlist")]/tr';

    public const XPATH_DATA_BASE_TABLE_CLASS = '[contains(@class,"athing")]'; 

    public const XPATH_DATA_ITEM_TIMESTAMP = '[%d]/td[2]/span/span[2]';

    public const XPATH_DATA_ITEM_INNER_LINK = '[%d]/td[2]/span/span[2]/a';

    public static function getFeedList(int $count = self::COUNT) {

    }
}