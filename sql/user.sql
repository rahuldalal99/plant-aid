CREATE TABLE User(
  email_id email primary key, 
  name varchar(100),
  passwd varchar(50),
  pr_image_path varchar(350)
);

CREATE TABLE User_images(
  email_id email references User(email_id)on delete cascade,
  image_path varchar(350),
  prediction varchar(100)
  );
