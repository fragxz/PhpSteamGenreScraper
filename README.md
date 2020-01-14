# PhpSteamGenreScraper
A PHP based script to scrape Genres for a specific Steam Game

## Requirements:
PHP 7.0+


## Example:

You have an Array with Games and you want to know the genre for these Games. Steam doesn't have an API for it, so use this scraper!

Let's say we want to know the Genres for the game "The Witcher 3: Wild Hunt - Blood and Wine". We have the following Array 
```
$arrayWithGames = ['The Witcher 3: Wild Hunt - Blood and Wine'];
```

If you use the script for example, you'll get the following genres:
```
RPG, Open World, Story Rich, Atmospheric
```

It scrapes the genres from the Store Page. So the genres you get back may change, depending how many users voted for a certain genre.

## Known Issues

The scraper can't get genres for games that needs an age verification (18+). Workarounds are possible, but not directly supported by this script.
