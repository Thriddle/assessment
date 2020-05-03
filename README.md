

# Assessment
In this file I want to explain the scope of the assignment and elaborate the decisionsI made.
This application illustrates a few functionalities and it's not suitable for a live website.

## The assignment

This assessment shows skills in HTML, PHP, CSS and a bit of SQL.
The assignment was as follows:
  * Create a webform with the following inputs:
    * A title (sir/madam), (in Dutch: Aanhef (heer/mevrouw))
    * First name (in Dutch: Voornaam)
    * Middle name (Dutch: Tussenvoegsel)
    * Last name (Dutch: Achternaam)
    * email address
    * A multiple choice for countries (Landenkiezer)
  * The form data must be saved in a MySQL database.
  * The data from the database can be collected as datastream in JSON format. (like in a REST API)
  * Handing in the assignment in GIT is apreciated.

## Decisions

At first I wanted to create a HTML form and upload the data by AJAX. This is an elegant solution to avoid extra pageloads. But if a browser doesn't support javascript you need a fallback, so a traditional form handler is still required. Because there wasn't much time I decided to skip the AJAX functionallity. After creating the form I wrote a script for handling the formdata. The script was procedural written and after creating the validation and save functionality the script began to grow to an confusing amount of lines of code.

So I decided to rewrite the code in an object oriented way.
I created a class for a form and added properties and methods to retrieve the form fields, validate the fields and save them into the database. It is still a lot of code, but now it's better documented and more clear what functions are about.
So, there was the HTML form, with a bit of styling and the handler to validate and save the data.
Next step was to create a script to serve the data in JSON format. This script would dig into the database to collect data and encode to JSON. But now I had 2 files working with tha database. That doesn't make sense.
So I split up the form class to a class just to handle the form and a class for executing database queries.
Now I could just create a DB object and call it's methods to save or collect data.

The scripts are tested in a docker container. I used the the php:7.3.4-apache image and added extentions for connecting with a database (pdo pdo_mysqli and msqli). In the docker-compose.yml I created environment variables for the database settings. To show how I use docker to developed this application I appended the dockerfile and the docker-compose.yml file.

## Next steps (if there was time)

As mentioned before, the application is not suitable for a life website. For a life website I would add at least the following improvements:
  * Database settings would be stored in credentials and secrets.
  * The database class would be extended with all CRUD functions. I would add functions to collect multiple records at the same time. The database connection itself would be stored in a property and methods would be added to open, execute and close the connection.
  * The form class would be improved to dynamically validate and save the form fields.
  * A class would be added for serving data in JSON format. This class would be able to serve different endpoints and allow different variables to find the requested data.
  * There is a lot to be improved to follow the guidelines of privacy legislation.
