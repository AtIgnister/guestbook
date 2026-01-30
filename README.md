How to set up a local dev environment:  
1. clone repository
2. composer install
3. npm install
4. php artisan migrate --seed
5. npm run dev
6. php artisan serve

How to contribute:  
1. Make a new branch for the thing you're trying to add
2. Create an issue for it, so I know that's what you're working on
3. When you're finished, make a pull request so I can look over the changes and give feedback - Please don't push directly to main, I want a chance to review the code first

Note on deploying:  
The docker config is currently very scuffed when it comes to sharing assets between containers. As a result, after making changes to the CSS, you need to remove the guestbook_laravel-public-assets volume. Otherwise, the CSS files used by the application will not be rebuilt.