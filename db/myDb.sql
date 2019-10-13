-- Mark Tobler
-- CS313
-- Br. Lyon
-- CS313 GOp Project PostgreSQL DB Creation Script

CREATE SEQUENCE user_id_seq;
CREATE TABLE users (
    user_id INTEGER NOT NULL DEFAULT nextval('user_id_seq'),
    first_name varchar(255)
);
