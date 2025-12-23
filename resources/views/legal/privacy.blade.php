<!-- resources/views/guestbooks/create.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Guestbook</title>
    <link rel="stylesheet" href="{{ asset('app.css') }}">
</head>
<body>
    <h1>Privacy Policy</h1>
    <h2>What data does this website collect?</h2>
    <p>guestbooks.kamiscorner.xyz collects the following data:</p>
    <p>1. Account information (Email, Password, etc. Everything you enter into the regstration form.)</p>
    <p>This is required in order to let you log in and create guestbooks that get associated with your account.</p>
    <p>2. The content of all guestbook entries you create. These are shown publicly. 
        I do not store any information about who made a specific entry, or when it was made.
        I have no way of tracing any guestbook entry back to any specific person or ip adress.
    </p>
    <p>3. Your session data: Your session data is stored in the database for a total of 2 hours. Sending new requests resets this timer.
        Your session data includes your IP, your user id (if you have an account and are currently logged in), your browsers user agent, and the last time you interacted with the website.
        A session cookie is also saved on your browser. Your session is <b>not</b> associated with any guestbook entries you create.
        This information is used in order to determine if the browser you are using is currently logged into the website, and to be able to persist your logged in status even when you close and reopen the browser.
    </p>
    
    <h2>Where is the server located?</h2>
    <p>Everything this website uses is hosted on a hetzner server located in germany(?) WIP: double check server location</p>

    <h2>How do I use your data?</h2>
    <p>I use your login info to let you log in and create new guestbooks, I use the data you enter into the guestbook creation form to create new guestbooks that are tied to your account, I use your session data to keep track of your login status, I use the data you enter into the guestbook entry creation form 
        to create anonymous guestbook entries.
    </p>

    <h2>Your rights:</h2>
    <p>
        No matter where you are in the world, you have these rights:<br>

        Access: Request a copy of your data. You can do this from the dashboard by pressing the "download complete user data backup" button TODO: implement this<br>
        Correction: Update incorrect data. You can edit all of your account and guestbook info at any time using the dashboard.<br>
        Deletion: Request account deletion. This is possible using the dashboard, by pressing the delete account button. This will delete any data that is associated with your account.<br>
        I cannot delete guestbook entries you create, as they are completely anonymous and I have no way of telling who originally created them. If an entry contains your personally identifiable information, you can contact me at kami@kamiscorner.xyz to have it removed.<br>
        Restriction & Objection: Ask guestbooks.kamiscorner.xyz to limit how your data is used.<br>
        Portability: Request your data in a portable format. We currently offer JSON, CSV and HTML exports, which are all accessible from your dashboard. Creating a full export of your account data using the dashboard will export <b>all</b> data we have that is associated with your account, with no exceptions. This includes all data about your current session at the time of requesting your export, all guestbooks you own, all of their associated entries, names, and custom stylesheets, and the hashed version of your password we store. If you want to export your data in a format we currently don't offer, you can email me at kami@kamiscorner.xyz, and I may manually export it for you or add another export type.<br>
    </p>

    <h2>Account deletion:</h2>
    <p>Deleting your account will delete all data we have that can be associated with your account. This consists of: Your account info (name, email, etc.) and all data about any guestbooks you have created.</p>
   
    <h2>Security:</h2>
    <p>I take reasonable measures to keep this website secure, but no system is perfect. Use a strong password and practice online safety. I strongly discourage you from posting any personably identifiable information in the guestbook entries or guestbooks you create.</p>
    <p>If you want to check the security of this website for yourself, you can inspect the source code over at <a href="https://github.com/atignister/guestbook">Github.</a></p>
    <p>If you have any security concerns, or find a vulnerability, please email me about it.</p>

    <h2>Changes to this policy:</h2>
    <p>If this policy changes, you will be notified the next time you open this website. We also have a <a href="">seperate page</a> (TODO: implement this) as well as an RSS-Feed that keeps track of all policy updates which you can follow with a feed reader of your choice. We will also send out an email whenever the policy changes.</p>

    <h2>Contact:</h2>
    <p>If you have any questions, you can contact me at kami@kamiscorner.xyz.</p>
</body>
</html>
