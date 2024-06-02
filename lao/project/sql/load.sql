USE project;

DELETE FROM Tags;
INSERT INTO Tags (tag_name) VALUES ('tag1'), ('tag2'), ('tag3'), ('tag4');

INSERT INTO Account_type (type_id, type_name) VALUES (1, 'admin'), (2, 'editor'), (3, 'journalist'), (4, 'user');

INSERT INTO articles (title, text_content) VALUES
 	("First Title", "Sample content for first title"),
    ("Second Title", "Sample content for second title");
