CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    site_name VARCHAR(100) NOT NULL,
    site_description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO settings (site_name, site_description) VALUES ('سیستم مدیریت خطاها', 'این سیستم برای مدیریت خطاها طراحی شده است.');