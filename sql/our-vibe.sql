DROP TABLE IF EXISTS eventImage;
DROP TABLE IF EXISTS eventTag;
DROP TABLE IF EXISTS tag;
DROP TABLE IF EXISTS event;
DROP TABLE IF EXISTS venue;
DROP TABLE IF EXISTS image;


CREATE TABLE image (

  imageId INT UNSIGNED AUTO_INCREMENT NOT NULL,
  imageCloudinaryId VARCHAR(32),

  PRIMARY KEY (imageId)

);

CREATE TABLE venue (

  venueId INT UNSIGNED AUTO_INCREMENT NOT NULL,
  venueImageId INT UNSIGNED,
  venueActivationToken VARCHAR (32),
  venueAddress1 VARCHAR(128) NOT NULL,
  venueAddress2 VARCHAR(128),
  venueCity VARCHAR (32) NOT NULL,
  venueContact VARCHAR(128) NOT NULL,
  venueContent VARCHAR (768) NOT NULL,
  venueName VARCHAR (32) NOT NULL,
  venueState VARCHAR (32) NOT NULL,
  venueZip VARCHAR (10) NOT NULL,
  venuePassHash CHAR(128) NOT NULL,
  venuePassSalt CHAR(64) NOT NULL,


  INDEX (venueImageId),

  PRIMARY KEY (venueId),

  FOREIGN KEY (venueImageId) REFERENCES image(imageId)

);

CREATE TABLE event (

  eventId INT UNSIGNED AUTO_INCREMENT NOT NULL,
  eventVenueId INT UNSIGNED NOT NULL,
  eventContact VARCHAR(128) NOT NULL,
  eventContent VARCHAR (768) NOT NULL,
  eventDate DATETIME(6) NOT NULL,
  eventName VARCHAR (128) NOT NULL,

  INDEX (eventVenueId),

  PRIMARY KEY (eventId),

  FOREIGN KEY (eventVenueId) REFERENCES venue(venueId)


);

CREATE TABLE tag (

  tagId   INT UNSIGNED AUTO_INCREMENT NOT NULL,
  tagName VARCHAR(32) NOT NULL,

  PRIMARY KEY (tagId)

);


CREATE TABLE eventTag (

  eventTagEventId INT UNSIGNED NOT NULL,
  eventTagTagId INT UNSIGNED NOT NULL,

  INDEX(eventTagEventId),
  INDEX(eventTagTagId),

  FOREIGN KEY (eventTagEventId) REFERENCES event(eventId),
  FOREIGN KEY (eventTagTagId) REFERENCES tag(tagId),

  PRIMARY KEY (eventTagTagId, eventTagEventId)
);

CREATE TABLE eventImage (
  eventImageImageId INT UNSIGNED NOT NULL,
  eventImageEventId INT UNSIGNED NOT NULL,

  INDEX(eventImageEventId),
  INDEX(eventImageEventId),

  FOREIGN KEY (eventImageImageId) REFERENCES image(imageId),
  FOREIGN KEY (eventImageEventId) REFERENCES event(eventId),

  PRIMARY KEY (eventImageImageId, eventImageEventId)

);







