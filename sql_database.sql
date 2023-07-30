CREATE TABLE users (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
);

CREATE TABLE shortened_urls (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  long_url TEXT NOT NULL,
  slug VARCHAR(100) NOT NULL UNIQUE,
  visit_count INT(11) DEFAULT 0,
  user_id INT(11) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id)
);
