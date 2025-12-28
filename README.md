TODO: (In order of difficulty, as judged by me)  
1. update the privacy policy to reflect us using maileroo for sending emails, and storing hashed Ip adresses for 30 days for moderation purposes. Also feel free to fix punctuation and grammar errors, and generally clean up the wording a bit if you've got ideas for improvements there (it's in resources/legal/privacy.blade.php)
This website is very much a WIP and not deployed anywhere yet, so right now the privacy policy also talks about things we currently don't do, but are planning to implement. If you find anything like that, add it to this list. That should be fairly easy as all of those features are marked with a TODO: label.
2. Have a look at both this blogpost https://anarchaeopteryx.bearblog.dev/2025-12-24-trusting-the-little-guy-me/ and https://avas.bearblog.dev/alternatives-trust/, and add everything there that we can implement to the TODO list
3. have another look over the commenting guidelines to check if I missed anything obvious we should add to the rules
4. allow people to add descriptions to their guestbook that users see when opening the respective guestbook page
5. Test the website to see if everything works and if the CSS is responsive. If not, either create issues for any of the problems you find or fix them yourself if they're easy fixes
5. add site-wide and per-guestbook IP bans (they each last for 30 days total, don't store IPs directly, hash them instead)
6. add an option to require approval for new guestbook entries
~~ 7. change all regular IDs we use to UUIDs, and store them as ints~~ Done!
8. Set up & test email sending with maileroo
9. add an admin dashboard that allows admin users to delete guestbook messages that violate TOS, and to ban people.
10. let admin users create invites to the service, that regular users can use to create accounts (there's already an account registration process that is currently deactivated in the settings, maybe figure out how to modify that to need invites for signup?)
11. figure out a way to automatically notify users of privacy policy changes (ideally i'd want both email and a message on the website itself. An RSS feed would be a nice bonus, but is not required.)  
12. fix or update all currently failing tests. Currently I'm not sure which of these are because of actual bugs, and which are just because I've refactored some parts to be different to the default laravel template this started out as

How to set up a local dev environment:  
1. clone repository
2. composer install
3. npm install
4. php artisan migrate
5. npm run dev
6. php artisan serve

How to contribute:  
1. Make a new branch for the thing you're trying to add
2. Create an issue for it, so I know that's what you're working on
3. When you're finished, make a pull request so I can look over the changes and give feedback - Please don't push directly to main, I want a chance to review the code first