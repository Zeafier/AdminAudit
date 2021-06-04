# AdminAudit
University dissertation project

# Hot to run application in your environment:
- Open up your local host (recommended: XAMPP);
- Run Apache and MySQL on the XAMPP control panel 
- Go to phpMyAdmin  by typing in the web browser localhost
- Create audit_admin database
- Import audit_admin.sql to the database
- Place folder with AuditAdmin to the following path: C:\xampp\htdocs and create or deploy AdminAudit folder
- Run in your web browser following address: http://localhost/AdminAudit
- The website should be up and running now.

# Login details:
U: administrator
P: SuperPass5

# Explanation:
- Database: folder containing details for database connection
- Decommission: folder containing pages for all of the pages related to the decommission
- Devices: folder containing pages for all of the pages related to the Device management
- dist: folder containing JavaScript, CSS, and images
- functions: include all of the PHP functions for application to run such as:
    - cryp_decrypt: cryptography function to encrypt and decrypt most important data in database;
    - decom_function: include all of the decommission functions for adding, removing and updating decommission devices;
    - device_function: include all of the audit device functions for adding, removing and updating devices;
    - orders_function: include all of the order functions for adding, removing and updating current and past orders;
    - Staff_function: include all of the staff functions for adding, removing and updating staff members details;
    - User_functions: include all of the log users function for adding, removing and updating users details;
    - XSS: cleaning functions which strips HTML tags to prevent cross-site scripting.
- logcheck: folder containing checkers for:
    - logged users - redirect the to the home page
    - logout - redirect them to the login page
- orders: folder containing pages for all of the pages related to the orders
- Users: folder containing pages for all of the pages related to the user management
- audit_admin.sql - sample database for the application
- Contact - contact page
- index - home page of the application
- LICENSE - license for the template
- login.php - main page of the application - login page
- passmust - page for changing user password forced by administrator
- user-pass - page for user password change