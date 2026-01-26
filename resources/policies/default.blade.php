<h2>What data does this website collect?</h2>
<h2>Legal basis for processing</h2>
<p>I process your data based on the following legal grounds:</p>
<ul>
    <li><strong>Contractual necessity:</strong> To create accounts, authenticate users, and provide the service.</li>
    <li><strong>Legitimate interest:</strong> To secure the website, prevent abuse, and analyze anonymous usage. Anonymous analytics are collected under legitimate interest to improve the service, monitor performance, and prevent abuse.</li>
</ul>


<p>{{ config('app.site_name') }} collects the following data:</p>
<ol>
    <li>
        <strong>Account information (Email, Password, etc. Everything you enter into the registration form.)</strong>
        <p>This is required in order to let you log in and create guestbooks that get associated with your account.
        </p>
        <p>If you enable two-factor authentication (2FA), a secret key is stored with your account to allow secure
            login using a TOTP-supported application on your phone or desktop. This information is used solely for
            authentication and is not shared with third parties.</p>
    </li>
    <li>
        <strong>Password reset data (Email, reset tokens, timestamp of request time)</strong>
        <p>This is required to let users reset their passwords.</p>
    </li>
    <li>
        <strong>The content of all guestbook entries you create.</strong>
        <p>These are shown publicly.</p>
        <p>Guestbook entries are not linked to user accounts or stored with identifying information such as user IDs
            or IP addresses. I do store hashed IP addresses alongside entries, but I cannot use these hashed addresses to track you, only to check if you are currently using the website. 
            Hashed IP addresses are stored separately from guestbook entries and are not publicly visible. They are not used to identify individual users, only to enforce site rules.</p>
    </li>
    <li>
        <strong>Your session data: Your session data is valid for a total of 2 hours. Sending new requests resets
            this timer.</strong>
        <p>Your session data includes your IP, your user id (if you have an account and are currently logged in),
            your browser's user agent, and the last time you interacted with the website.</p>
        <p>A session cookie is also saved on your browser. Your session is <b>not</b> associated with any guestbook
            entries you create.</p>
        <p>Your session information is used in order to determine if the browser you are using is currently logged
            into the website, and to be able to persist your logged in status even when you close and reopen the
            browser.</p>
        <p>Expired sessions are automatically ignored and periodically removed.</p>
    </li>
    <li>
        <strong>Your hashed IP address</strong>
        <p>Your hashed IP address is stored on our servers for a total of 30 days, beginning from the creation of your last guestbook entry.</p>
        <p>It is exclusively used to IP ban you if you infringe on our commenting guidelines.</p>
        <p>After the 30 days are over, your IP and the associated IP ban get deleted permanently.</p>
    </li>
    <li>
        <strong>Anonymized Analytics, https://www.goatcounter.com/</strong>
        <p>I collect completely anonymous Analytics using goatcounter.com, which is located in Ireland and stores its data on servers located in Finland and Germany.</p>
        <p>This includes such things are referrer, screen size, browser information, and location.</p>
        <p>This information cannot be traced back to any individual user and will be used only to detect and fix bugs, watch out for suspicious traffic spikes, 
            assess site popularity to make decisions about whether or not to upgrade hardware and collect user feedback if this site ever gets linked to on a blogpost.</p>
        <p>The automatic emails I send you get sent out by the third-party emailing service https://maileroo.com/.</p>
        <p>I do not send marketing emails using this service. The only emails I send are sign up/password reset links and information about EULA updates.</p>
        <p>None of the emails contain any information about you besides your email address and username.</p>
        <p>I will never sell your data.</p>
    </li>
</ol>


<h2>Where is the server located?</h2>
<p>This website is hosted on servers located in the European Union.</p>

<h2>How do I use your data?</h2>
<p>I use your login info to let you log in and create new guestbooks, I use the data you enter into the guestbook
    creation form to create new guestbooks that are tied to your account, I use your session data to keep track of
    your login status, I use the data you enter into the guestbook entry creation form
    to create anonymous guestbook entries, I use your analytics data to improve the service and detect traffic spikes,
    I use your hashed IP address to IP ban you if you break the site rules.
</p>

<h2>Your rights</h2>
<p>When interacting with this website, you have these rights:</p>
<ol>
    <li><strong>Access:</strong> Request a copy of your data. You can do this at /guestbooks/export.</li>
    <li><strong>Correction:</strong> Update incorrect data. You can edit all of your account and guestbook info at
        any time using the dashboard.</li>
    <li><strong>Deletion:</strong> Request account deletion. This is possible using the dashboard, by pressing the
        delete account button. This will delete any data that is associated with your account. Because guestbook
        entries are anonymous and not linked to accounts, I cannot verify authorship. However, if an entry contains
        personal information, you may request its removal.</li>
    <li><strong>Restriction & Objection:</strong> Ask {{ config('app.site_name') }} to limit how your data is used.
    </li>
    <li><strong>Portability:</strong> Request your data in a portable format. This website currently offers JSON,
        CSV and HTML exports, which are all accessible from your dashboard. If you want to export your data in a
        format that currently isn't offered, you can email me at {{ config('app.contact') }}, and I may manually export it
        for you or add another export type. Exported data does not include your password in a usable form.</li>
</ol>

<h2>Account deletion:</h2>
<p>Deleting your account will delete all data I have that can be associated with your account. This consists of:
    Your account info (name, email, etc.) and all data about any guestbooks you have created.</p>

<h2>Security:</h2>
<p>I take reasonable measures to keep this website secure, but no system is perfect. Use a strong password and
    practice online safety. I strongly discourage you from posting any personally identifiable information in the
    guestbook entries or guestbooks you create.</p>
<p>If you want to check the security of this website for yourself, you can inspect the source code over at <a
        href="https://github.com/atignister/guestbook">Github.</a></p>
<p>If you have any security concerns, or find a vulnerability, please email me about it.</p>

<h2>Changes to this policy:</h2>
<p>If this policy changes, you will be notified via email if you have an account. This website also has a <a
        href="/privacy-policy">separate page</a> which tracks all changes that get made to the policy.</p>

<h2>Contact:</h2>
<p>If you have any questions, you can contact me at {{ config('app.contact') }}.</p>