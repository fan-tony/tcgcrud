This Repostitory contains a CRUD funcional web app using the LAMP stack (Linux, Apache, MySQL, PHP)
LAMP Stack CRUD Setup
Creating a virtual machine to run Linux 
You can skip this step if you’re already running a Linux based operating system.
1.	Install virtualbox and make a linux virtual machine (Using Ubuntu 20.04)

a.	Click the link below to download and install virtualbox. Select the platform corresponding to the platform you’re using (e.g Windows) https://www.virtualbox.org/wiki/Downloads


b.	After installing virtual box, create a new virtual machine by clicking the ‘New’ icon
![image](https://user-images.githubusercontent.com/35779414/150242327-2636c1b5-b70b-40c4-b2b9-1e3f42965781.png) <br>

 

Select the following options, and change the machine folder directory according to your needs
 ![image](https://user-images.githubusercontent.com/35779414/150242296-e0de2158-57ff-4e20-a7ab-aa35c74efd39.png)

c.	Depending on your system build, allocate RAM and cores for your VM. For this project, 2GB of RAM and 2 cores is enough. Select a virtual hard disk for the storage, and dynamically allocated size.
![image](https://user-images.githubusercontent.com/35779414/150242308-34dd436f-feef-4f47-b50d-39295617afcb.png)

Example window for selecting RAM amount

d.	Download Ubuntu 20.04 operating system here: https://ubuntu.com/download/desktop

e.	Start the virtual machine, and provide the prompt the path to your downloaded file <br>
 ![image](https://user-images.githubusercontent.com/35779414/150242345-78657957-76f0-4866-98de-cdf1519ec324.png) <br>
Example of selecting the ISO file for the Ubuntu operating system

f.	Select your preferred language, and ‘Install Ubuntu’, and your keyboard layout. Leave the rest of the configurations as their default selected setting.

g.	For the final install page, provide your name, a name for the virtual machine, and a username for the machine.
![image](https://user-images.githubusercontent.com/35779414/150242359-acf43664-a724-4f32-bd70-0c247d8fd2a7.png) <br>
Example name, computer name, and username for this setup step.



h.	Back in the Oracle VM Virtualbox Manager, select your VM machine and head to Settings>General>Advanced. Set shared clipboard and Drag’n’Drop to bidirectional.
 ![image](https://user-images.githubusercontent.com/35779414/150242373-2e3f3850-c9ee-4612-9d34-c941f9bc0a9a.png)<br>


i.	Create a shared folder to share files between your host and virtual machine. Select your desired directory. Remember the name of this shared folder for downloading the files from git later. In this example we will name it ‘shared’.
 ![image](https://user-images.githubusercontent.com/35779414/150242399-9c0b041c-9659-49a1-9468-dd8a5f73a6d6.png)<br>

 
Install LAMP stack (Linux, Apache, MySQL, PHP)
Search for, and open the terminal app in the bottom left corner.
2.	Install Apache 
a.	Next step is to install Apache as the web server. For security, enable your firewall, and then deny incoming connections with the following commands:

sudo ufw enable
sudo ufw default deny

b.	Update all packages, install Apache, and then allow Apache through the firewall

sudo apt update && sudo apt install apache2 && sudo ufw allow in “Apache”
	       Double check the firewall status using: sudo ufw status
 ![image](https://user-images.githubusercontent.com/35779414/150242478-f50daecb-844d-4125-bea8-2d582fc96e63.png)<br>
Using ‘sudo ufw status’ to display that apache is allowed through the firewall

3.	Install MySQL
a.	Install MySQL packages using
sudo apt install mysql-server

b.	Test if you’re able to log into the mySQL database using:
  sudo mysql 

Create the database and a user:

	CREATE DATABASE tcg;

Then create a mysql user with proper with the below command. Replace ‘sql_user’ and ‘password’ with your own preferred credentials. Remember these for the config file later
	
CREATE USER ‘sql_user'@'%' IDENTIFIED WITH mysql_native_password BY ‘sqlpass’;
		GRANT ALL ON tcg.* TO 'sql_user'@'%';
	

c.	Exit the mysql shell with ‘exit’, and login to your created user:
mysql -u sql_user -p

d.	Next make a table to store data. Use ‘edit’ and then paste the following:

  CREATE TABLE tcg.yugioh (
          ID INT AUTO_INCREMENT NOT NULL,
          Amount INT NOT NULL,
          Name VARCHAR(100) NOT NULL,
          Type VARCHAR (10) NOT NULL,
          Edition VARCHAR (20) NOT NULL,
          PRIMARY KEY (ID)
  );
	Save the query with escape and then ‘:wq’. Run the query by submitting ‘;’ on the next line.


4.	Install PHP
a.	Install PHP and then verify the version to ensure it installed properly:
sudo apt install php libapache2-mod-php php-mysql
php -v
 ![image](https://user-images.githubusercontent.com/35779414/150242546-9eb305d4-5f02-442f-992a-b01c20c45b4e.png)<br>
Here we see the version number 7.4.3, indicating that php was successfully installed.


Launch the Virtual Host
Install gvim for a user friendly editor, if you’re familiar with any other, feel free to use it:
	sudo apt install vim-gtk3

Make a new directory for this web app. Its domain will be tcgcrud:
	sudo mkdir /var/www/tcgcrud
	sudo chown -R $USER:$USER /var/www/tcgcrud
	sudo gvim /etc/apache2/sites-available/tcgcrud.conf

Paste the following text into the opened file. Save and quit by pressing escape, and typing “:wq”
<VirtualHost *:80>
    ServerName tcgcrud
    ServerAlias www.tcgcrud
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/tcgcrud
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>

Enable the host and disable default with the command:
	sudo a2ensite tcgcrud
	sudo a2dissite 000-default

Importing GIT Files and Updating Config
Go back to your windows host, and download all the files under the repository tcgcrud at https://github.com/fan-tony/tcgcrud. Place the files into the previously created shared folder. 
Go into your virtual machine and use the command below to make a new directory to link to the shared folder
	mkdir Documents/guest_share

Use the following command, where ‘shared’ is the name of your shared folder created in 1i).
sudo mount -t vboxsf shared GUEST_SHARE
	cp -a Documents/guest_share/. /var/www/tcgcrud/

Next open the config file and change the $user and $password variables to your own mysql user
	gvim /var/www/tcgcrud/config.php
	 ![image](https://user-images.githubusercontent.com/35779414/150242707-85b32cb6-7bc6-4853-b649-b21b7f6d6101.png)<br>


Using The Webapp
The main landing page will display the database information, and allow for functions to create, update, and delete cards. You can also filter cards by selecting the filter option check boxes and clicking on ‘Apply Filter’.
Cards are also listed in alphabetical order. Later revisions can be added to sort by other specifications (group by type, or reverse alphabetical).
 
![image](https://user-images.githubusercontent.com/35779414/150242735-e3406d52-f27e-4d5a-9a7f-5c926d96c484.png)<br>

There are filters at the top which when selected, will display cards meeting those attributes. Each attribute is mutually exclusive from other attributes of the same category (a card cannot be 1st edition and limited edition at the same time) so multiple selections will show all cards meeting any of those conditions (OR operative). However for a different attribute (Type) it will be another condition that the card must fulfill (AND operation). 
![image](https://user-images.githubusercontent.com/35779414/150242828-728ab78e-163e-4a8f-bd74-b1a50548c7c1.png)<br>

Create a card record will not allow for empty fields, or negative/non-integer numbers for amount. Duplicates (a card with the same name, type, and edition) will also be rejected.
 ![image](https://user-images.githubusercontent.com/35779414/150242838-683d3bbd-2e3d-4302-ad3f-afa9fdb62761.png)<br>

Updating cards will reject empty fields, negative/non-integer numbers, or duplicate entries (same conditions as create a card).
 ![image](https://user-images.githubusercontent.com/35779414/150242844-f16bbb2f-fd14-4957-ac94-4d44abd780dd.png)<br>

Deleting cards will prompt this screen to verify that the user wants to remove the selected card.
 ![image](https://user-images.githubusercontent.com/35779414/150242850-91fd1a5b-68e8-4f34-9d24-bfe11fa78e5c.png)<br>

