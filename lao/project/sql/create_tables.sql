CREATE TABLE Articles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title varchar(255),
    text_content LONGTEXT,
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
    password_hash varchar(256),
    creation_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    last_login DATETIME
);

CREATE TABLE Comment (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    account_id INT UNSIGNED,
    creation_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    article_id INT UNSIGNED,
    text_contnet LONGTEXT,

    FOREIGN KEY (article_id) REFERENCES Articles(id),
    FOREIGN KEY (account_id) REFERENCES Account(id)
);



CREATE TABLE Account_type (
    type_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    type_name varchar(18)
);

CREATE TABLE Account_to_type (
    account_id INT UNSIGNED,
    type_id INT UNSIGNED,

    PRIMARY KEY (account_id, type_id),

    FOREIGN KEY (account_id) REFERENCES Account(id),
    FOREIGN KEY (type_id) REFERENCES Account_type(type_id)
);



CREATE TABLE Author (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    account_id INT UNSIGNED,
    full_name varchar(80),

    FOREIGN KEY (account_id) REFERENCES Account(id)
);

CREATE TABLE Article_to_author (
    article_id INT UNSIGNED,
    author_id INT UNSIGNED,

    PRIMARY KEY (article_id, author_id),

    FOREIGN KEY (article_id) REFERENCES Articles(id),
    FOREIGN KEY (author_id) REFERENCES Author(id)
);