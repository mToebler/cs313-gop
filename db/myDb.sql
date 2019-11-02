-- Mark Tobler
-- CS313
-- Br. Lyon
-- CS313 GOp Project PostgreSQL DB Creation Script

CREATE SEQUENCE user_id_seq;
CREATE TABLE users (
    id INTEGER PRIMARY KEY NOT NULL DEFAULT nextval('user_id_seq'),
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    city VARCHAR(255),
    state_id INTEGER, --[FK references:states.id, ]
    address VARCHAR(255),
    dob DATE,
    email VARCHAR(255),
    password TEXT NOT NULL --this is meant to be salted, hashed when inserted
);

CREATE SEQUENCE item_id_seq;
CREATE TABLE items (
   id INTEGER NOT NULL PRIMARY KEY DEFAULT nextval('item_id_seq'),
   name VARCHAR(255) NOT NULL,
   value NUMERIC(6,2),
   image BYTEA,
   location_id INTEGER -- [FK ref to locations.id]
);

CREATE SEQUENCE possesion_id_seq;
CREATE TABLE possesions (
   id INTEGER PRIMARY KEY DEFAULT nextval('possesion_id_seq'),
   name VARCHAR(255) NOT NULL UNIQUE,
   description VARCHAR(2047),
   deleted BOOLEAN
);

CREATE TABLE item_possesion (
   user_id INTEGER NOT NULL REFERENCES users(id),
   item_id INTEGER NOT NULL REFERENCES items(id),
   possession_id INTEGER NOT NULL REFERENCES possesions(id),
   notes VARCHAR(1023),
   start_date DATE NOT NULL DEFAULT CURRENT_DATE,
   end_date DATE NOT NULL, -- DEFAULT  CURRENT_DATE + INTERVAL '72h',
   PRIMARY KEY(user_id, item_id, possession_id)
);

CREATE SEQUENCE location_id_seq;
CREATE TABLE locations (
   id INTEGER PRIMARY KEY DEFAULT nextval('location_id_seq'),
   name VARCHAR(255) NOT NULL,
   description VARCHAR(1023) NOT NULL,
   image BYTEA
);

CREATE SEQUENCE meta_id_seq;
CREATE TABLE metas (
   id INTEGER PRIMARY KEY DEFAULT nextval('meta_id_seq'),
   parent_id INTEGER REFERENCES metas(id),
   name VARCHAR(255),
   desciption VARCHAR(2047)
);

CREATE TABLE meta_item (
   item_id INTEGER NOT NULL REFERENCES items(id),
   meta_id INTEGER NOT NULL REFERENCES metas(id),
   value VARCHAR(255) NOT NULL,
   PRIMARY KEY (item_id, meta_id)
);

CREATE TABLE states (
   id INTEGER PRIMARY KEY, -- these will be populated
   name VARCHAR(255) NOT NULL
);

-- Tie up loose ends, add the missing FKs
ALTER TABLE users
   ADD CONSTRAINT fk_users_state_id
   FOREIGN KEY (state_id) REFERENCES states(id);

ALTER TABLE items
   ADD CONSTRAINT fk_items_location_id --[FK ref to locations.id]
   FOREIGN KEY (location_id) REFERENCES locations(id);

ALTER TABLE items
	ADD COLUMN description VARCHAR(2047);

-- setting email in users to not null. It's how peopel will login. (synced with live and production dbs)
 ALTER TABLE users ALTER COLUMN email SET NOT NULL;

 --change item_possesions to item_possessions (spelling error)
 ALTER TABLE item_possesion RENAME TO item_possession;