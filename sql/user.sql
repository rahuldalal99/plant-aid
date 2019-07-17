CREATE TABLE Users(
  email_id varchar(100),
  name varchar(100),
  passwd varchar(50),
  pr_image_path varchar(350)
);

CREATE TABLE User_images(
  email_id varchar(100) references Users(email_id)on delete cascade,
  image_path varchar(350),
  prediction varchar(100),
  date_upload timestamp
  );
