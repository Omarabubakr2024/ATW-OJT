# LAMP Stack Setup on AWS EC2 Instance

## Steps

### **1. Create an Ubuntu EC2 Instance**
1. Log in to the AWS Management Console.
2. Create a new EC2 instance:
   - **AMI:** Ubuntu Server
   - **Instance Name:** `lamp`
   - **Public IP Address:** Automatically assigned (e.g., `98.84.133.213`).
3. Configure the necessary security groups to allow inbound HTTP traffic on port 80:
   - **Type:** HTTP
   - **Protocol:** TCP
   - **Port Range:** 80
   - **Source:** `0.0.0.0/0` (for global access).

### **2. Connect to the EC2 Instance via SSH**
1. Use the following command to connect:
   ```bash
   ssh -i "omar1.pem" ubuntu@ec2-98-84-133-213.compute-1.amazonaws.com
   ```
![alt text](<Screenshot from 2024-12-15 20-26-57.png>)

### **3. Update the Package Manager**
1. Update the system packages:
   ```bash
   sudo apt update
   ```

### **4. Install Apache**
1. Install Apache:
   ```bash
   sudo apt install apache2 -y
   ```
2. Ensure Apache is configured to serve websites from the `/var/www/html/` directory.
3. Create a test file to verify:
   ```bash
   echo "<h1>Welcome to ATW.ltd LAMP Project</h1>" | sudo tee /var/www/html/index.html
   ```
4. Test the setup by visiting:
   ```
   http://98.84.133.213/
   ```
![alt text](<Screenshot from 2024-12-15 20-09-45.png>)

### **5. Install MySQL**
1. Install MySQL:
   ```bash
   sudo apt install mysql-server -y
   ```
2. Secure the MySQL installation:
   ```bash
   sudo mysql_secure_installation
   ```
   Follow the prompts to set up a root password and secure the database.
3. Log in to MySQL:
   ```bash
   sudo mysql -u root -p
   ```
4. Create a database and user:
   ```sql
   CREATE DATABASE web_db;
   CREATE USER 'web_user'@'localhost' IDENTIFIED BY 'StrongPassword123';
   GRANT ALL PRIVILEGES ON web_db.* TO 'web_user'@'localhost';
   FLUSH PRIVILEGES;
   ```

### **6. Install PHP**
1. Install PHP and required modules:
   ```bash
   sudo apt install php libapache2-mod-php php-mysql -y
   ```
2. Replace the `index.html` file with a PHP file:
   ```bash
   echo "<?php echo 'Hello World!'; ?>" | sudo tee /var/www/html/index.php
   ```
3. Test the PHP setup by visiting:
   ```
   http://98.84.133.213/
   ```
![alt text](<Screenshot from 2024-12-15 20-24-11.png>)

### **7. Modify the Website to Use the Database**
1. Update `index.php` to connect to MySQL and display the visitor's IP address and current time:
   ```php
   <?php
   $servername = "localhost";
   $username = "web_user";
   $password = "StrongPassword123";
   $dbname = "web_db";

   // Create connection
   $conn = new mysqli($servername, $username, $password, $dbname);

   // Check connection
   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   }

   // Get the visitor's IP address
   $visitor_ip = $_SERVER['REMOTE_ADDR'];

   // Get the current time
   $current_time = date('Y-m-d H:i:s');

   echo "<h1>Hello, World!</h1>";
   echo "<p>Your IP address is: $visitor_ip</p>";
   echo "<p>Current server time is: $current_time</p>";
   ?>
   ```
2. Test the website locally and ensure it displays the visitor's IP address and the current time.

### **8. Confirm Public Accessibility**
1. Configure firewall rules and security groups:
   - Open the **AWS Management Console** and navigate to the EC2 Dashboard.
   - Select the Security Group associated with your EC2 instance.
   - Add an inbound rule:
     - **Type:** HTTP
     - **Protocol:** TCP
     - **Port Range:** 80
     - **Source:** `0.0.0.0/0` (for global access) or a specific IP range.
2. Retrieve the Public IP:
   - Find your instance’s **Public IPv4 Address** in the AWS EC2 Dashboard.
3. Test the website by visiting:
   ```
   http://98.84.133.213/
   ```
4. Confirm accessibility via the public hostname:
   ```
   http://ec2-98-84-133-213.compute-1.amazonaws.com/
   ```
![alt text](<Screenshot from 2024-12-16 06-40-34.png>)


