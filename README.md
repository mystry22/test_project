
## Test_projects

The project is a test project which displays basic CRUD feature, it is for demonstration purposes only but
also support latest trend in user authetication and validation (JWT)

## Note

1. User input validation was not covered in this test project 
2. project is for demonstration purposes only
3. Base language is PHP (Laravel)

## DB
- Mysql
- User should create database, user and password and configure the .env file

## Logic
- The software helps manage a company's data records and can have more than one administrators(user's), these user's create an account and a token is assigned to each user and has access to create, read, update and delete records from the database.

- Each user can view all records and can modify all record's irrespective of who created the records

- The system also records the unique id (user_id) of who created which entry and can be spooled to get records(though not implemented here)

- The 'list_all_sysytems' endpoint from the name return all the records in the Database but supports pagination 

- At the end of each day the system empties the records as it only maintains hourly records







