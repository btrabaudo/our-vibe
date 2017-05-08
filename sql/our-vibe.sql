DROP TABLE IF EXISTS eventImage;
DROP TABLE IF EXISTS eventTag;
DROP TABLE IF EXISTS image;
DROP TABLE IF EXISTS tag;
DROP TABLE IF EXISTS 'event';
DROP TABLE IF EXISTS venue;

CREATE TABLE venue (

  venueId INT UNSIGNED AUTO_INCREMENT NOT NULL,
  venueImageId INT UNSIGNED,
  venueAddress1 VARCHAR(128) NOT NULL,
  venueAddress2 VARCHAR(128),
  venueCity CHAR (32) NOT NULL,
  venueContact VARCHAR(128) NOT NULL,
  venueContent VARCHAR (768) NOT NULL,
  venueName CHAR (32) NOT NULL,
  venueState CHAR (32) NOT NULL,
  venueZip VARCHAR (10) NOT NULL,
  venuePassHash CHAR(128) NOT NULL,
  venuePassSalt CHAR(64) NOT NULL,


  INDEX (venueImageId),

  PRIMARY KEY (venueId),

  FOREIGN KEY (venueImageId) REFERENCES image(imageId)

);

CREATE TABLE 'event' (

  eventId INT UNSIGNED AUTO_INCREMENT NOT NULL,
  eventContact VARCHAR(128) NOT NULL,
  eventContent VARCHAR (768) NOT NULL,
  eventDateTime DATETIME(6) NOT NULL,
  eventName CHAR (128) NOT NULL,

  PRIMARY KEY (eventId)

);

CREATE TABLE tag (

  tagId   INT UNSIGNED AUTO_INCREMENT NOT NULL,
  tagName CHAR(32) NOT NULL,

  PRIMARY KEY (tagId)

);

CREATE TABLE image (

  imageId INT UNSIGNED AUTO_INCREMENT NOT NULL,
  imageCloudinaryId VARCHAR(32),

  INDEX (imageCloudinaryId),

  PRIMARY KEY (imageId),

  FOREIGN KEY (imageCloudinaryId) REFERENCES cloudnaryId(cloudnaryId)


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







