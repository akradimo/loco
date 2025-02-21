#!/bin/bash  

# Create project root directory  
mkdir -p project-root/{assets/{css,js,images},includes,pages}  

# Create necessary files  
touch project-root/assets/css/styles.css  
touch project-root/assets/js/scripts.js  
touch project-root/assets/images/logo.png  
touch project-root/includes/{header.php,footer.php,db.php,functions.php}  
touch project-root/pages/{home.php,login.php,register.php,dashboard.php,errors_list.php,add_error.php,manage_groups.php,profile.php,admin_panel.php}  
touch project-root/index.php  
touch project-root/.htaccess  

echo "Project structure created successfully!"



-- ایجاد جدول error_groups  
CREATE TABLE error_groups (  
    id INT AUTO_INCREMENT PRIMARY KEY,  
    group_name VARCHAR(100) NOT NULL  
);  

-- ایجاد پایگاه‌داده (در صورت نیاز)  
CREATE DATABASE IF NOT EXISTS your_database_name;  
USE your_database_name;  

-- (اختیاری) ایجاد جداول دیگر  
-- مثلاً برای ذخیره خطاها یا کاربران  
CREATE TABLE errors (  
    id INT AUTO_INCREMENT PRIMARY KEY,  
    error_message TEXT NOT NULL,  
    group_id INT,  
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  
    FOREIGN KEY (group_id) REFERENCES error_groups(id) ON DELETE CASCADE  
);  

CREATE TABLE users (  
    id INT AUTO_INCREMENT PRIMARY KEY,  
    username VARCHAR(50) NOT NULL,  
    password VARCHAR(255) NOT NULL,  
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  
);