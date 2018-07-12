#!/bin/bash
clear
dialog --title "Welcome to Cole" \
--backtitle "Cole" \
--yesno "Welcome to Cole CMS: The CMS for the rest of us.\n\nAre you ready to install Cole?" 7 60

# Get exit status
# 0 means user hit [yes] button.
# 1 means user hit [no] button.
# 255 means user hit [Esc] key.
response=$?
case $response in
   0) 
		file=".env"
		if [ -f "$file" ]
		then
			clear
			dialog --title "Cole" --msgbox "Cole appears to be already installed. Please visit Cole in your web browser to finalise the setup.\n\nIf you would like to reinstall Cole, Please delete the .env file located in the root of the installation." 13 50
			exit
		fi


		(
		c=10
		while [ $c -ne 110 ]
		do
			echo $c
			echo "###"
			echo "$c %"
			echo "###"
			c=$(( $c+10 ))
			if [ "$c" = "10" ]
			then
				chmod -R 777 "${0%/*}"
			fi
			if [ "$c" = "20" ]
			then
				chmod -R 777 storage/
			fi
			if [ "$c" = "30" ]
			then
				chmod -R 777 public/
			fi
			if [ "$c" = "40" ]
			then
				composer install --quiet
			fi
			if [ "$c" = "50" ]
			then
				curl -s -S -O 'https://raw.githubusercontent.com/laravel/laravel/master/.env.example' > /dev/null
			fi
			if [ "$c" = "60" ]
			then
				wget -q 'https://raw.githubusercontent.com/laravel/laravel/master/.env.example' > /dev/null
			fi
			if [ "$c" = "70" ]
			then
				mv .env.example .env
			fi
			if [ "$c" = "80" ]
			then
				chmod 777 .env
			fi
			if [ "$c" = "90" ]
			then
				php artisan key:generate > /dev/null
				rm .env.example.1
			fi
		done
		) |
		dialog --title "Cole" --gauge "Installing Cole..." 10 60 0
		
		sh update.sh -quiet

		dialog --title "Cole" --msgbox "Cole has been installed. Visit Cole in your web browser to configure it." 6 50
   ;;
   1)
	dialog --title "Cole" --msgbox "Cole was not installed. You will need to run sh.install.sh to activate Cole on your host." 6 50
   ;;
   255)
	dialog --title "Cole" --msgbox "Cole was not installed. You will need to run sh.install.sh to activate Cole on your host." 6 50
   ;;
esac
clear