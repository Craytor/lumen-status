lumen-status
============
Lumen Status was created by, and is maintained by [Tyler Youschak](http://tjyouschak.me). Lumen status doens't have an official name, but it is just a landing page for your server. You can see an example of the page [on my server](http://cosmos.team-radiant.com/)! The landing page includes the following:
* Server Name
* Server Description
* Server Background
* Disk Usage
* Memory
* Swap
* CPU
* ... and more

## Why Lumen?
I wanted to explore Lumen! Lumen was released just a few days before I started making this app - and I will continue updating this app to keep it in good conditions.

## Configuration
You can configure the following data in your .env file, also note that you may need to copy the .env.example to .env
```
LS__SERVER_NAME=
LS__SERVER_DESCRIPTION=
LS__TEXT_COLOR=
LS__SERVER_BACKGROUND=
```
 (`LS__SERVER_NAME`) is the server name, (`LS__SERVER_DESCRIPTION`) is the server description, (`LS__TEXT_COLOR`) is the text color, and (`LS__SERVER_BACKGROUND`) is the server background. I've decided to make it configurable by these means because you wont have to configure the app at all. It's "plug and play" - and it works on Forge too! Go to the environmental variable area on Forge, and you can add the keys above and the values you want. Also, make sure to press the box that says this application uses Laravel 4.2+ so that you can use these variables.

## Requirements
In order to use lumen-status, you must have `sysstat` installed on your system. You can get `sysstat` by running `sudo apt-get install sysstat`.

## Contributing
Do you want to contribute to this amazing project? If so, make your changes and make a pull request.
