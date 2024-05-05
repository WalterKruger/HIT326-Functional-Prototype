CREATE TABLE Articles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title varchar(255),
    text_contnet LONGTEXT,
    image_path varchar(255),
    creation_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    modification_date DATETIME ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE Tags (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tag_name varchar(255)
);

CREATE TABLE Article_to_tag (
    article_id INT UNSIGNED,
    tag_id INT UNSIGNED,
    weight FLOAT,

    PRIMARY KEY (article_id, tag_id),

    FOREIGN KEY (article_id) REFERENCES Articles(id),
    FOREIGN KEY (tag_id) REFERENCES Tags(id)
);

CREATE TABLE Account (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_name varchar(18),
    email varchar(80),
    password_hash BINARY(32),
    creation_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    last_login DATETIME
)