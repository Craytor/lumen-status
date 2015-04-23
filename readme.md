## lumen-status
Lumen status doens't have an official name, but it is just a landing page for your server. The landing page includes the following:
* Server Name
* Server Description
* Server Background
* Disk Usage
* Memory
* Swap
* CPU
* ... and more

#### Configuration
You can configure the server name (`server_name`), server description (`server_description`), text color (`text_color`), and server background (`server_background`) environmental variables by editing the .env file. This allows you to specify these values. If you don't specify these values, your page will look pretty plain. That's about it.

#### Requirements
In order to use lumen-status, you must `sysstat`. You can do this by running `sudo apt-get install sysstat`.

#### Contributing
Do you want to contribute to this amazing project? If so, make your changes and make a pull request.