# lumen-status
Lumen status doens't have an official name, but it is just a landing page for your server. You can see an example of the page [on my server](http://cosmos.team-radiant.com/)! The landing page includes the following:
* Server Name
* Server Description
* Server Background
* Disk Usage
* Memory
* Swap
* CPU
* ... and more

## Why Lumen?
I wanted to explore Lumen! Lumen was released just a few days before I started to make this app - and I will continue updating this app to keep it in good condtions.

#### Configuration
You can configure the server name (`LS__SERVER_NAME`), server description (`LS__SERVER_DESCRIPTION`), text color (`LS__TEXT_COLOR`), and server background (`LS__SERVER_BACKGROUND`) environmental variables by editing the .env file. This allows you to specify these values. If you don't specify these values, your page will look pretty plain. That's about it.

#### Requirements
In order to use lumen-status, you must `sysstat`. You can do this by running `sudo apt-get install sysstat`.

#### Contributing
Do you want to contribute to this amazing project? If so, make your changes and make a pull request.