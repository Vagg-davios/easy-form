# 📝 easy-form
A simple form made with mostly PHP. Has an admin panel with a search feature for the form results.

![image](https://user-images.githubusercontent.com/101106849/167217537-1527a627-2246-4297-a7e1-94362a0a955d.png)

 
 
 
 Contents | 
------------ | 
[Step 1: Installation of XAMPP](#-step-1-installation-of-xampp-%EF%B8%8F)   | 
[Step 2: Filling out the form](#-step-2-filling-out-the-form-)   | 
[Step 3: Visualizing the data](#-step-3-visualizing-the-data-)   | 
[Step 4: Editing the data](#-step-4-editing-the-data-%EF%B8%8F)   | 
[Step 5: Enjoy](#-step-5-enjoy-)   | 




 
 ***
## > Step 1: Installation of XAMPP ⚙️
- Download the latest version of [XAMPP](https://www.apachefriends.org/download.html).
- Fire up the control panel.
- Start up the Apache and MySQL modules.  

![image](https://user-images.githubusercontent.com/101106849/167217849-2433b1e9-6055-4c08-b857-2e476c5901df.png)
- Clone the code into your htdocs directory (Make a folder at C:\xampp\htdocs and paste the files)


## > Step 2: Filling out the form ✍ 
- Head over to http://localhost/ **{folder-name-from-above}** /login.php
- Sign up, log in, fill out the form and hit submit.


## > Step 3: Visualizing the data 📊
- Log out of the previous account and log into any of the generated admin accounts:
  - > webadmin1 : webadmin1
  - > webadmin2 : webadmin2
 
- Bunch of options:
  - **Create DB**: Create the database to store the form info. If someone enters the form.php page the database is created automatically so this button just checks.
  - **Show DB**: Show all the submitted form data.
  - **Search DB**: Search the database for input. Filter either by the name of the participant and / or their email provider. 
  - **Reset your password** and **Log out**.


## > Step 4: Editing the data ✏️
- Head over to http://localhost/phpmyadmin/index.php
- On the left of the page is a column with the available databases. Hitting the plus (+) will reveal the tables of each database

![image](https://user-images.githubusercontent.com/101106849/167294589-8cc22c63-470b-4d3b-9005-f7dbc0b22ed0.png)

- **Database A**: The database where all the participants are stored. Has a table called "formparticipants" which includes their name, emails etc. All the fields are filtered for any weird characters and malicious code before they are stored in the database.
- **Database B**: The database where all the accounts are stored. Has a table called users which includes their username, password hash, user type and date of creation.

![image](https://user-images.githubusercontent.com/101106849/167294700-aa7709df-b3bd-42ca-b0a8-736b24f72649.png)

- Editing the data can be done by clicking the **Edit** button in any of the table rows. Editing will be made available through the admin page so one doesn't have to go into phpMyAdmin to do so.

## > Step 5: Enjoy! 🎉
- Congratulations for reading through this, you deserve a cookie 🍪.
