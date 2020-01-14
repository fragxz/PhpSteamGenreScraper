# PhpSteamGenreScraper
A PHP based script to scrape Genres for a specific Steam Game

If you want to thank me with a coffee or show me that there is interest in this project, I would be very thankful for any support: [![paypal](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://www.paypal.me/fredericreinhardt)


## Requirements:
PHP 7.0+

## Usage:
```
 $arrayWithGames = ['The Witcher 3: Wild Hunt - Blood and Wine'];
 $scraper = new SteamGenreScraper;
 echo $scraper->getGenreByGameName('The Witcher 3: Wild Hunt - Blood and Wine');
```

Result:
```
RPG, Open World, Story Rich, Atmospheric
```


## Explanation:

You have an Array with Games and you want to know the genre for these Games. Steam doesn't have an API for it, so use this scraper!

Let's say we want to know the Genres for the game "The Witcher 3: Wild Hunt - Blood and Wine". We have the following Array 
```
$arrayWithGames = ['The Witcher 3: Wild Hunt - Blood and Wine'];
```

If you use the class for example, you'll get the following genres:
```
RPG, Open World, Story Rich, Atmospheric
```

It scrapes the genres from the Store Page. So the genres you get back may change, depending how many users voted for a certain genre.

## Known Issues

The scraper can't get genres for games that needs an age verification (18+). Workarounds are possible, but not directly supported by this script.
