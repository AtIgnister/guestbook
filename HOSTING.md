Guestbooks is currently beta software. This means that there is no stable, tagged release and things can break between versions.  
So, if you don't intend on updating very frequently, self hosting is a bad idea right now.  
Still, here's how to do it:  

0. Prerequisites: In order to run guestbooks, you will need to have docker compose installed.
1. Clone the repository
2. Configuration:
    1. Copy the .env.example, and rename it to .env
    2. set the APP_URL to the url of the website you want to host guestbooks on
    3. change NGINX_PORT to the port you want to run the website on
    4. Comment out the sqlite connection and uncomment the pgsql connection
    5. Comment out all mail_mailer defaults, and uncomment mailer production defaults. If you want to use maileroo for your mailing service, you will have to sign up for an account with them and paste your api key in here
    6. Set the contact email and site name. These are purely cosmetic and mostly used in the privacy policy
    7. Set ANALYTICS_SRC to the script html of your analytics provider of choice. I recommend goatcounter due them being privacy respecting. If you don't want analytics, just leave this option blank.
    8. If you have forked the repo, change SOURCE_URL to contain a link to the source code of your fork
3. Read through policies/default.php and then edit it to reflect your circumstances
4. Run docker compose build && docker compose up -d. The web app should now be running
5. run php artisan key:generate inside the php-fpm container, and copy paste the result into your .env file. Restart the containers.
6. run php artisan admin:user:create inside the php-fpm container to create an admin user.
7. The application should now be up and running. The nginx configuration is at docker/production/nginx/nginx.conf. If you want https, either edit it or use a local instance of nginx as a reverse proxy.  

The application is still somewhat unstable and these instructions are not guaranteed to work. Things might break, and these instructions are not guaranteed to be up to date with the latest commit.