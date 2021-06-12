DROP TABLE IF EXISTS users CASCADE;
CREATE TABLE users (
   id       SERIAL  PRIMARY KEY,
   nickname TEXT    UNIQUE NOT NULL,
   password TEXT    NOT NULL
);

DROP TABLE IF EXISTS questions CASCADE;
CREATE TABLE questions (
   id           SERIAL    PRIMARY KEY,
   "userID"     INT       NOT NULL,
   content      TEXT      NOT NULL,
   timestamp    TIMESTAMP NOT NULL,
   FOREIGN KEY ("userID") REFERENCES users (id)
);


DROP TABLE IF EXISTS answers CASCADE;
CREATE TABLE answers (
   id           SERIAL    PRIMARY KEY,
   "questionID" INT       NOT NULL,
   "userID"     INT       NOT NULL,
   content      TEXT      NOT NULL,
   timestamp    TIMESTAMP NOT NULL,
   FOREIGN KEY ("userID") REFERENCES users (id),
   FOREIGN KEY ("questionID") REFERENCES questions (id)
);

DROP TABLE IF EXISTS tokens CASCADE;
CREATE TABLE tokens (
   id           SERIAL    PRIMARY KEY,
   session      TEXT      UNIQUE NOT NULL,
   token        TEXT      UNIQUE NOT NULL,
   timestamp    TIMESTAMP NOT NULL
);

INSERT INTO users VALUES(0, 'System', 'nopass');
