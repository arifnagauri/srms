# Student Management System (SMS)

- This is a PHP/MySQL web app project for managing students and there results.

- Have two portals namely admin portal for administration staff and result portal for public(students).

- This SMS is basically for schools (upto 12th standard), however if you want to modify it for colleges/higher education SMSs, just do small changes in DB model and queries in php files accordingly.

**Note: ** *I have used some code snippets from some of the online forums with slight modifications, I acknowledge them whosoever's work is being used in this source code and also thanking them to help novice learner like me:)*
--------------------------------------
- Steps to start with project:

->Download XAMPP or MAMP or WAMP (whichever suitable) and learn how to use it (link: https://youtu.be/X0_pthMQPMM) if never used before. (suggestion: install XAMPP)

->Create a database with name whichever you want. (mine is with name: srms)

->To develop DB model and create tables, execute sql commands provided in the sql file.
	(or you can start from scratch and develop your own database model, then you have to modify all PDO sql queries, wherever written in php files, according to your database model)[hint: refer dbmodel image in 'assests' folder]

->Go to pdo.php file in both :public and :admin/app directories and change 'dbname' in parameters of pdo object constructor to your database name.

->Copy this project folder in :c/xampp/htdocs directory and run 'localhost/srms' url in browser.

->Modify/extend the project the way you like.
