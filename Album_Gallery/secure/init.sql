-- TODO: Put ALL SQL in between `BEGIN TRANSACTION` and `COMMIT`
BEGIN TRANSACTION;

-- TODO: create tables

-- CREATE TABLE `examples` (
-- 	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
-- 	`name`	TEXT NOT NULL
-- );

CREATE TABLE albums (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  file_name TEXT NOT NULL,
  file_ext TEXT NOT NULL,
  album_title TEXT,
  artist TEXT,
  source TEXT
);

CREATE TABLE tags (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  tag TEXT UNIQUE NOT NULL
);

CREATE TABLE album_tags (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  album_id INTEGER,
  tag_id INTEGER
);


-- TODO: initial seed data

-- INSERT INTO `examples` (id,name) VALUES (1, 'example-1');
-- INSERT INTO `examples` (id,name) VALUES (2, 'example-2');

-- albums table seed data:
-- Image source: https://en.wikipedia.org/wiki/Pure_Heroine --
INSERT INTO albums (id, file_name, file_ext, album_title, artist, source) VALUES (1, "1.png", "png", "Pure Heroin", "Lorde", "https://en.wikipedia.org/wiki/Pure_Heroine");
-- Image source: https://en.wikipedia.org/wiki/Melodrama_(Lorde_album) --
INSERT INTO albums (id, file_name, file_ext, album_title, artist, source) VALUES (2, "2.png", "png", "Melodrama", "Lorde", "https://en.wikipedia.org/wiki/Melodrama_(Lorde_album)");
-- Image source: https://en.wikipedia.org/wiki/Heard_It_in_a_Past_Life --
INSERT INTO albums (id, file_name, file_ext, album_title, artist, source) VALUES (3, "3.png", "png", "Heard it in a Past Life", "Maggie Rogers", "https://en.wikipedia.org/wiki/Heard_It_in_a_Past_Life");
-- Image source: https://en.wikipedia.org/wiki/When_We_All_Fall_Asleep,_Where_Do_We_Go%3F --
INSERT INTO albums (id, file_name, file_ext, album_title, artist, source) VALUES (4, "4.png", "png", "WHEN WE ALL FALL ASLEEP, WHERE DO WE GO", "Billie Eilish", "https://en.wikipedia.org/wiki/When_We_All_Fall_Asleep,_Where_Do_We_Go%3F");
-- Image source: https://en.wikipedia.org/wiki/Lover_(album) --
INSERT INTO albums (id, file_name, file_ext, album_title, artist, source) VALUES (5, "5.png", "png", "Lover", "Taylor Swift", "https://en.wikipedia.org/wiki/Lover_(album)");
-- Image source: https://www.amazon.com/Seven-Mary-RAINBOW-KITTEN-SURPRISE/dp/B07ZW9PYC1 --
INSERT INTO albums (id, file_name, file_ext, album_title, artist, source) VALUES (6, "6.png", "png", "Seven and Mary", "Rainbow Kitten Surprise", "https://www.amazon.com/Seven-Mary-RAINBOW-KITTEN-SURPRISE/dp/B07ZW9PYC1");
-- Image source: https://www.amazon.com/RKS-Rainbow-Kitten-Surprise/dp/B00WOW18T4 --
INSERT INTO albums (id, file_name, file_ext, album_title, artist, source) VALUES (7, "7.png", "png", "RKS", "Rainbow Kitten Surprise", "https://www.amazon.com/RKS-Rainbow-Kitten-Surprise/dp/B00WOW18T4");
-- Image source: https://en.wikipedia.org/https://www.amazon.com/How-Freefall-Explicit-Digital-Download/dp/B079257S9X --
INSERT INTO albums (id, file_name, file_ext, album_title, artist, source) VALUES (8, "8.png", "png", "How To: Friend, Love, Freefall", "Rainbow Kitten Surprise", "https://www.amazon.com/How-Freefall-Explicit-Digital-Download/dp/B079257S9X");
-- Image source: https://www.amazon.com/Mountains-Beaches-Cities-Moon-Taxi/dp/B00DGGIXL8 --
INSERT INTO albums (id, file_name, file_ext, album_title, artist, source) VALUES (9, "9.png", "png", "Mountains, Beaches, Cities", "Moon Taxi", "https://www.amazon.com/Mountains-Beaches-Cities-Moon-Taxi/dp/B00DGGIXL8");
-- Image source: https://thelumineers.com/music/ --
INSERT INTO albums (id, file_name, file_ext, album_title, artist, source) VALUES (10, "10.png", "png", "Gloria Sparks", "The Lumineers", "https://thelumineers.com/music/");
-- Image source: https://en.wikipedia.org/wiki/https://en.wikipedia.org/wiki/Golden_Hour_(album) --
INSERT INTO albums (id, file_name, file_ext, album_title, artist, source) VALUES (11, "11.png", "png", "Golden Hour", "Kacey Musgraves", "https://en.wikipedia.org/wiki/Golden_Hour_(album)");

--tags table seed data:
INSERT INTO tags (id, tag) VALUES (1, "royals");
INSERT INTO tags (id, tag) VALUES (2, "drama - atic!");
INSERT INTO tags (id, tag) VALUES (3, "rainbow kitten surprise");
INSERT INTO tags (id, tag) VALUES (4, "So good!");
INSERT INTO tags (id, tag) VALUES (5, "Quarentine tunes!");
INSERT INTO tags (id, tag) VALUES (6, "Tay Tay!");



-- album_tags table seed data:
INSERT INTO album_tags (id, album_id, tag_id) VALUES (1, 1, 1);
INSERT INTO album_tags (id, album_id, tag_id) VALUES (2, 2, 2);
INSERT INTO album_tags (id, album_id, tag_id) VALUES (3, 6, 3);
INSERT INTO album_tags (id, album_id, tag_id) VALUES (4, 7, 3);
INSERT INTO album_tags (id, album_id, tag_id) VALUES (5, 8, 3);
INSERT INTO album_tags (id, album_id, tag_id) VALUES (6, 5, 4);
INSERT INTO album_tags (id, album_id, tag_id) VALUES (7, 10, 4);
INSERT INTO album_tags (id, album_id, tag_id) VALUES (8, 3, 4);
INSERT INTO album_tags (id, album_id, tag_id) VALUES (9, 5, 5);
INSERT INTO album_tags (id, album_id, tag_id) VALUES (10, 8, 5);
INSERT INTO album_tags (id, album_id, tag_id) VALUES (11, 4, 5);
INSERT INTO album_tags (id, album_id, tag_id) VALUES (12, 9, 5);
INSERT INTO album_tags (id, album_id, tag_id) VALUES (13, 6, 5);




COMMIT;
