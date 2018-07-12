<p align="center"><img src="http://poweredbycole.co.uk/Cole/Brand/coleTransparent.png" width="40%"></p>
<p align="center"><a href="https://travis-ci.org/genericmilk/Cole" target="_blank"><img src="https://travis-ci.org/genericmilk/Cole.svg?branch=master" /></a></p>

Cole is a CMS Developed by Senior LAMP Developer, Peter Day.

Cole builds its modules based on the data that it receives. Because of this if you decide on adding a feature down the line, You just add it. Cole does the rest.

Each Cole module also comes with a set of permissions so if you work in a large organisation, you can be assured that the right people have the right access.

## How to install

The quickest way of setting up Cole is via Git on your Unix based server. You may choose to use a build that is located within the releases section if you'd prefer, however the best practice is to use the main repository.

You can get started by cloning the main repository to your server by preforming the following command.

```
git clone https://github.com/genericmilk/Cole cole
```

This will download the Cole repository to a folder called "cole" in your current directory on the server.

You will need to setup a web server record via Apache, NGINX etc to point to the folder you would like Cole to run from.

Cole is working if you experience a "Vendor" error or see the "install.sh" screen.

To get Cole activated, navigate to the folder Cole will run from and preform the command

```
sh install.sh
```

This will download the required .env file, install composer packages and assign an Application Key which is what is required to get Cole in a position where it can be assigned to your SQL Server and setup a user account.

Visiting Cole in your web browser will now display the install wizard. Simply fill out the required fields on the page to get Cole installed.

## Updating Cole

Because Cole is installed and maintained from GitHub, Updating to the latest version is very easy to do. Simply navigate to the folder Cole is located and run the command
```
sh update.sh
```

This command discards any local changes to Cole's core system and updates them to the new version from GitHub. This command will leave Custom modules you have installed intact because they are ignored on Git.

Once you have preformed the update command, You will be able to refresh Cole and check that your version number has altered.

### Setting up Auto-Update

Managing updates for Cole can be taxing especially if you are running multiple instances on the same server. To combat this, You can setup a Cron-job to run the update script.

The instructions below are for a Linux server, your milage may vary on other platforms.

To get started, run the following command:

```
crontab –e
```

You can paste the line below, changing `/path/to/cole` to the directory where the `update.sh` script is located for the Cole installation you want to autoupgrade.

```
0 0 * * * sh /path/to/cole/update.sh -quiet >/dev/null 2>&1
```

Cole will now be autoupdated to the latest version every day at midnight.

## ColeTools

To allow Cole to modify your existing website, You will need to impliment ColeTools, the frontend package for Cole. This engine allows you to edit the contents of the page via inline editing. [Get started with Coletools here](https://github.com/genericmilk/coletools)

## Documentation

Cole has a documentation folder located in the repository which is useful if you want to understand how the system is built so that you may construct your own Custom modules or Fork cole and improve it. You can read  Cole's documentation [here](https://github.com/genericmilk/Cole/wiki)

## Troubleshooting

Cole has a built in exception handler built off the Laravel Whoops engine. If you encounter an exception, Please report it to us via the Issues section on GitHub. Filename, exception and line details helps for a speedy fix.

### -bash: dialog: command not found

This error may occur if you are running `sh install.sh` on macOS. Cole uses the Dialog package for its update and install scripts. To fix this, You can install dialog by using a package manager such as Homebrew by typing `brew install dialog`

### /install returns 404 not found

You need to ensure that `mod_rewrite` is enabled in your Apache configuration file and that `AllowOveride All` is set instead of `AllowOveride None`

### sh update.sh does not work or loops error messages

It's possible you are running an old version of sh update.sh - to remedy this you can update the repository by running `git pull && sh update.sh` This will update the files and then run a larger scale update