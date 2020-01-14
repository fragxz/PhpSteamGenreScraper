<?php

/*
 * === Example Usage ===
 * $arrayWithGames = ['The Witcher 3: Wild Hunt - Blood and Wine'];
 * $scraper = new SteamGenreScraper;
 * echo $scraper->getGenreByGameName('The Witcher 3: Wild Hunt - Blood and Wine');
 */


// PHP 7+
// Searches for the Game via the Steam Search Page first
// Then it grabs the first result and gets its Store Page
// and there it scrapes its genres

class SteamGenreScraper
{
    /*
     * searches for a steam game
     *
     * you only input the games name and the function searches for the game with the steam store search.
     * it will return the url of the FIRST result
     *
     */
    function searchSteamGame($gameName)
    {
        $gameNameEncoded = rawurlencode($gameName);
        $gameUrl = 'https://store.steampowered.com/search/?term=' . $gameNameEncoded ; // URL to search for the game

        // Steam Store Search Page
        list($curl, $result) = $this->getSteamSearchPage($gameUrl);
        $appId_firstSearchPageResult = $this->getGameAppId($result);

        // GET URL => https://store.steampowered.com/app/ + appId    =>  https://store.steampowered.com/app/378648/
        $gameAppUrl = 'https://store.steampowered.com/app/' . $appId_firstSearchPageResult ;

        return $gameAppUrl;
    }

    /*
     * getGenres
     *
     * gets the Genres for the game-url you entered as the parameter
     * returns its genres
     *
     */
    function getGenres($gameAppUrl)
    {
        $gameAppPageResult = $this->getGameStorePage($gameAppUrl);

// get Content from DIV ID "glance_tags popular_tags"

        $gameGenreDivContent_exploded = explode('<div class="glance_tags popular_tags"', $gameAppPageResult);
        $gameGenreDivContent = explode('<div class="app_tag add_button"', $gameGenreDivContent_exploded[1]);

        $dom = new domDocument('1.0', 'utf-8');
        $dom->loadHTML( $gameGenreDivContent[0] ); // load the html into the object
        $dom->preserveWhiteSpace = false; //discard white space
        $gameGenres_TagA = $dom->getElementsByTagName('a'); // content of "a" Tag
        $gameGenreOne = trim($gameGenres_TagA->item(0)->nodeValue);
        $gameGenreTwo = trim($gameGenres_TagA->item(1)->nodeValue);
        $gameGenreThree = trim($gameGenres_TagA->item(2)->nodeValue);
        $gameGenreFour = trim($gameGenres_TagA->item(3)->nodeValue);

        // todo: support all genres (even hidden ones)

        $gameGenres = $gameGenreOne . ', ' . $gameGenreTwo . ', ' . $gameGenreThree . ', ' . $gameGenreFour;
        return $gameGenres;
    }

    function getGenreByGameName($gameName)
    {
        $gameAppUrl = $this->searchSteamGame($gameName);
        $gameGenres = $this->getGenres($gameAppUrl);
        return $gameGenres;
    }


    function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    /**
     * @param string $gameUrl
     * @return array
     */
    function getSteamSearchPage(string $gameUrl): array
    {
        $curl = curl_init($gameUrl);
        curl_setopt($curl, CURLOPT_FAILONERROR, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($curl);
        return array($curl, $result);
    }

    /**
     * @param $result
     * @return bool|string
     */
    function getGameAppId($result)
    {
        $steamSearchPage = explode('<div id="search_resultsRows">', $result);
        $laengeContent_erstesShopResult = strpos($steamSearchPage[1], 'data-ds-appid');
        $erstesShopResultHtml = str_split($steamSearchPage[1], $laengeContent_erstesShopResult);
        $erstesShopResult_AppId = $this->get_string_between($erstesShopResultHtml[1], 'data-ds-appid="', '"');
        return $erstesShopResult_AppId;
    }

    /**
     * @param string $gameAppUrl
     * @return bool|string
     */
    function getGameStorePage(string $gameAppUrl)
    {
        $curl = curl_init($gameAppUrl);
        curl_setopt($curl, CURLOPT_FAILONERROR, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $gameAppPageResult = curl_exec($curl);
        return $gameAppPageResult;
    }
}


?>
