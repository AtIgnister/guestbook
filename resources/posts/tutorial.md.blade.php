## How to set up a guestbook
### Step 1: Create An account
Email guestbooks@kamiscorner.xyz asking for an invite.
I will send you an email with an account creation link.  
Click on the link, and create an account.

### Step 2: Create a new guestbook
Go to your [Dashboard.](/dashboard)  

Click on "View Guestbooks".  
You will see text saying "No guestbooks yet. Go ahead and make one!".
<br>  
Click on ["Go ahead and make one!".](/guestbooks/create)
Give your guestbook a name - this part is mandatory.  
If you want to, you can fill out all the other fields here as well, but they aren't required to get your guestbook working.  

<br>
 
When you're done, click "create guestbook".

### Step 3: Embed your guestbook
On the [guestbooks page on your dashboard](/guestbooks), you should now see several links for your newly created guestbook.  
Click on the "edit" link.  
You now have two options:  
<br>
**If you are using a free bearblog account, or are on a different platform that does not support Javascript:**  
Scroll down to where it says "embed-code", and copy the contents of the textbox.
It should look kind of like this:
<textarea readonly><iframe src="https://guestbooks.kamiscorner.xyz/embed/guestbook/5234cf59-bfce-4dd2-9021-167f2af10f60" width="100%" height="500px" frameborder="0"></iframe></textarea>
<br>
<br>

**If you are paying for bearblog premium, or are on a different platform that supports Javascript:**  
Scroll down to where it says "JS Embed Code (Experimental)", and copy the contents of the textbox.
It should look kind of like this:
<textarea readonly>
<textarea readonly id="embed-code" name="embed-code" class="flex-1 h-60 block">{{ $html = view('embed.embedjs', [
                    'guestbook' => "example",
                ])->render() }}
</textarea>
<br>  
<br>

**Once you have copied the embed code for your platform:**  
Create a new page on your website, and paste the embed code. The guestbook will appear wherever you paste the code.  

<br>

**Congratulations, you're done!**    
If you find yourself having trouble with any of these steps, feel free to email me at guestbooks@kamiscorner.xyz.