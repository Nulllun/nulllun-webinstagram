# csci4140-assignment1
> Name: Lun Yin Fung
> SID: 1155092566
> Heroku link: https://nulllun-webinstagram.herokuapp.com/

## functionality of each directory
>### photo_album/
>> store the edited image file
>> provide static permalink for the image
>### temp/
>> all upload image file will store here right after the uploading
>> image files are taken from here for editing

## procedure of building the system
>### building
>> used MAMP as localhost, built and debugged in local
>### deployment
>> linked Heroku to github repository
>> fixed new bugs during deployment
>### keycomponent
>> database: Heroku Postgres (storing path of image and user information)
>> photo edit: Imagick 

In this assignment, I used the Heroku Postgres add-on as my database
instead of using a csv file, which is more difficult and I have gained
the experience of deployment and setting up database.