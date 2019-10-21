-- location data needed!
INSERT INTO locations (name, description) VALUES ('A1', 'northeast corner');
INSERT INTO locations (name, description) VALUES ('A2', 'along north wall eastern side');
INSERT INTO locations (name, description) VALUES ('A3', 'along north wall middle');
INSERT INTO locations (name, description) VALUES ('A4', 'along north wall western side');
INSERT INTO locations (name, description) VALUES ('A5', 'northwest corner');
INSERT INTO locations (name, description) VALUES ('B1', 'door way');
INSERT INTO locations (name, description) VALUES ('B2', 'in front of door');
INSERT INTO locations (name, description) VALUES ('B3', 'near north wall middle');
INSERT INTO locations (name, description) VALUES ('B4', 'near north wall western side');
INSERT INTO locations (name, description) VALUES ('B5', 'near northwest corner at wall');
INSERT INTO locations (name, description) VALUES ('C1', 'middle at eastern wall');
INSERT INTO locations (name, description) VALUES ('C2', 'middle near eastern wall');
INSERT INTO locations (name, description) VALUES ('C3', 'middle of garage');
INSERT INTO locations (name, description) VALUES ('C4', 'middle near western side');
INSERT INTO locations (name, description) VALUES ('C5', 'middle at western wall');
INSERT INTO locations (name, description) VALUES ('D1', 'near southeast corner at wall');
INSERT INTO locations (name, description) VALUES ('D2', 'near south wall eastern side');
INSERT INTO locations (name, description) VALUES ('D3', 'near south wall middle');
INSERT INTO locations (name, description) VALUES ('D4', 'near south wall western side');
INSERT INTO locations (name, description) VALUES ('D5', 'near southwest corner at wall');
INSERT INTO locations (name, description) VALUES ('E1', 'southeast corner');
INSERT INTO locations (name, description) VALUES ('E2', 'along south wall eastern side');
INSERT INTO locations (name, description) VALUES ('E3', 'along south wall middle');
INSERT INTO locations (name, description) VALUES ('E4', 'along south wall western side');
INSERT INTO locations (name, description) VALUES ('E5', 'southwest corner');

--states
insert into states (name) VALUES ('AK');
insert into states (name) VALUES ('AL');
insert into states (name) VALUES ('AR');
insert into states (name) VALUES ('AZ');
insert into states (name) VALUES ('CA');
insert into states (name) VALUES ('CO');
insert into states (name) VALUES ('CT');
insert into states (name) VALUES ('DE');
insert into states (name) VALUES ('FL');
insert into states (name) VALUES ('GA');
insert into states (name) VALUES ('HI');
insert into states (name) VALUES ('IA');
insert into states (name) VALUES ('ID');
insert into states (name) VALUES ('IL');
insert into states (name) VALUES ('IN');
insert into states (name) VALUES ('KS');
insert into states (name) VALUES ('KY');
insert into states (name) VALUES ('LA');
insert into states (name) VALUES ('MA');
insert into states (name) VALUES ('MD');
insert into states (name) VALUES ('ME');
insert into states (name) VALUES ('MI');
insert into states (name) VALUES ('MN');
insert into states (name) VALUES ('MO');
insert into states (name) VALUES ('MS');
insert into states (name) VALUES ('MT');
insert into states (name) VALUES ('NC');
insert into states (name) VALUES ('ND');
insert into states (name) VALUES ('NE');
insert into states (name) VALUES ('NH');
insert into states (name) VALUES ('NJ');
insert into states (name) VALUES ('NM');
insert into states (name) VALUES ('NV');
insert into states (name) VALUES ('NY');
insert into states (name) VALUES ('OH');
insert into states (name) VALUES ('OK');
insert into states (name) VALUES ('OR');
insert into states (name) VALUES ('PA');
insert into states (name) VALUES ('RI');
insert into states (name) VALUES ('SC');
insert into states (name) VALUES ('SD');
insert into states (name) VALUES ('TN');
insert into states (name) VALUES ('TX');
insert into states (name) VALUES ('UT');
insert into states (name) VALUES ('VA');
insert into states (name) VALUES ('VT');
insert into states (name) VALUES ('WA');
insert into states (name) VALUES ('WI');
insert into states (name) VALUES ('WV');
insert into states (name) VALUES ('WY');

-- items
INSERT INTO items (name, value, location_id, description) VALUES ('hammer', 3.50, 5, 'Handy Hammer');
INSERT INTO items (name, value, location_id, description) VALUES ('standard screw driver', 2.75, 5, 'Large, chipped red handle. Good condition.');
INSERT INTO items (name, value, location_id, description) VALUES ('1/4 inch irrigation tubing', 15.00, 19, '50 feet, black, flexible');
INSERT INTO items (name, value, location_id, description) VALUES ('hand shovel', 2.75, 8, 'white, older, slightly bent');
INSERT INTO items (name, value, location_id, description) VALUES ('flat shovel', 16.50, 22, 'Taped up handle');
INSERT INTO items (name, value, location_id, description) VALUES ('Ryobi battery lawn mover', 120.00, 20, 'Blade slightly bent-Beckett');
INSERT INTO items (name, value, location_id, description) VALUES ('white spray paint', 8.50, 4, 'from Trent''s old collection. Unopened');
INSERT INTO items (name, value, location_id, description) VALUES ('sand paper:heavy duty', 4.25, 3, 'unopened. 3M, 15 sheets');

-- users
INSERT INTO users (first_name, last_name, city, state_id, address, dob, email, password) VALUES ('Mark', 'Tobler', 'Las Vegas', 33, '5525 Sentinel Bridge', '1971-12-04'::DATE, 'marktobler@gmail.com', 'openpw');
INSERT INTO users (first_name, last_name, city, state_id, address, dob, email, password) VALUES ('Ryan', 'Tobler', 'San Diego', 5, '3324 Santamargarita St', '1973-02-12'::DATE, 'ryantobler@gmail.com', 'openpw');
INSERT INTO users (first_name, last_name, city, state_id, address, dob, email, password) VALUES ('Ashlee', 'Phillips', 'St. George', 44, '538 Canyon View', '1976-12-15'::DATE, 'ashleephillips@gmail.com', 'openpw');
INSERT INTO users (first_name, last_name, city, state_id, address, dob, email, password) VALUES ('Trent', 'Tobler', 'Denver', 6, '7832 Shadow Peak Ln', '1978-12-24'::DATE, 'drtrenttobler@gmail.com', 'openpw');
INSERT INTO users (first_name, last_name, city, state_id, address, dob, email, password) VALUES ('Judy', 'Tobler', 'Las Vegas', 33, '7251 Del Rey', '1949-05-28'::DATE, 'judytobler@gmail.com', 'openpw');
INSERT INTO users (first_name, last_name, city, state_id, address, dob, email, password) VALUES ('Ron', 'Tobler', 'Las Vegas', 33, '7251 Del Rey', '1944-06-11'::DATE, 'ronetobler@gmail.com', 'openpw');
INSERT INTO users (first_name, last_name, city, state_id, address, dob, email, password) VALUES ('James', 'Tobler', 'San Diego', 5, '3324 Santamargarita St', '2004-08-21'::DATE, 'jamesnotjimmy@gmail.com', 'openpw');

--metas
INSERT INTO metas (name, description) values ('tools', 'all tools');
INSERT INTO metas (name, description) VALUES ('irrigation', 'irrigation equipement');
INSERT INTO metas (name, description) VALUES ('power machines', 'larger than power tools, smaller than tractors');
INSERT INTO metas (name, description) VALUES ('paints & art supplies', 'artist or journeymen ware for changing the appearance of stuff');

INSERT INTO metas (parent_id, name, description) VALUES ((select id from metas where name = 'tools'),'hand tools', 'single handed tools');
INSERT INTO metas (parent_id, name, description) VALUES ((select id from metas where name = 'tools'),'power tools', 'electric driven tools');
INSERT INTO metas (parent_id, name, description) VALUES ((select id from metas where name = 'tools'),'large tools', 'two handed tools, not stored in toolbox');
INSERT INTO metas (parent_id, name, description) VALUES ((select id from metas where name = 'paints & art supplies'),'spray paint', 'not for tagging');

-- meta_items
insert into meta_item (item_id, meta_id) values ((select id from items where name = 'hammer'), (select id from metas where name = 'hand tools'));
insert into meta_item (item_id, meta_id) values ((select id from items where name = 'standard screw driver'), (select id from metas where name = 'hand tools'));
insert into meta_item (item_id, meta_id) values ((select id from items where name = '1/4 inch irrigation tubing'), (select id from metas where name = 'irrigation'));
insert into meta_item (item_id, meta_id) values ((select id from items where name = 'hand shovel'), (select id from metas where name = 'hand tools'));
insert into meta_item (item_id, meta_id) values ((select id from items where name = 'flat shovel'), (select id from metas where name = 'large tools'));
insert into meta_item (item_id, meta_id) values ((select id from items where name = 'Ryobi battery lawn mover'), (select id from metas where name = 'power machines'));
insert into meta_item (item_id, meta_id) values ((select id from items where name = 'white spray paint'), (select id from metas where name = 'spray paint'));
insert into meta_item (item_id, meta_id) values ((select id from items where name = 'sand paper:heavy duty'), (select id from metas where name = 'paints & art supplies'));

-- scratch
-- select i.name, i.description, m.name, l.description
--    from items i join meta_item mi  
--       on i.id = mi.item_id 
--       join metas m
--       on mi.meta_id = m.id
--       join locations l 
--       on i.location_id = l.id
-- ;

-- meta tag scratch:
-- select m.id, m.name as name, m.description as descr, m2.name as parent, m2.id as pid from metas m left join metas m2 on m.parent_id = m2.id;

-- users scratch
select u.id, first_name, last_name, city, s.name as sa, address, email from users u join states s on u.state_id = s.id order by first_name; 