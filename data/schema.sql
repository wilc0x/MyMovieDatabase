CREATE TABLE movie (id INTEGER PRIMARY KEY AUTOINCREMENT, title varchar(100) NOT NULL, genre varchar(100) NOT NULL, actors varchar(200) NOT NULL, rating char(3));
INSERT INTO movie (title, genre, actors, rating) VALUES ('Pulp Fiction', 'Crime', 'Bruce Willis, John Travolta, Samuel L Jackson', '4.5');
INSERT INTO movie (title, genre, actors, rating) VALUES ('Die Hard', 'Action', 'Bruce Willis, Alan Rickman', '4.0');
INSERT INTO movie (title, genre, actors, rating) VALUES ('Unforgiven', 'Western', 'Clint Eastwood, Morgan Freeman, Gene Hackman', '5.0');
INSERT INTO movie (title, genre, actors, rating) VALUES ('Robin Hood: Men In Tights', 'Comedy', 'Cary Elwes, Dave Chapelle, Richard Lewis', '4.5');
INSERT INTO movie (title, genre, actors, rating) VALUES ('Dumb And Dumber', 'Comedy', 'Jim Carrey, Jeff Daniels', '4.5');