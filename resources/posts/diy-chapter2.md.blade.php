## Displaying optional fields & showing replies

### Chapters
<a href="/blog/diy">Chapter 1: Creating a basic, read-only guestbook</a>  
<a href="/blog/diy-chapter2">Chapter 2: Displaying optional fields & showing replies (Current Chapter)</a>  
<br>

Now that we're done displaying the basic fields, that every guestbook entry will have, it's time to move on to the optional fields!  
Well, the optional field, i suppose, since there's only one, currently.  
<br>

Anyways, let's get this over with, and change the displayEntries() function to display the optional website field!  

```js
async function displayEntries(entries) {
    const entriesFragment = document.createDocumentFragment();

    entries.forEach(entry => {
        const entryContainer = document.createElement("div");
        entryContainer.classList.add("guestbook-entry")

        const entryNamePara = document.createElement("p");
        entryNamePara.textContent = `${entry.name} wrote...`;
        entryNamePara.classList.add("guestbook-entry-name");
        entryContainer.appendChild(entryNamePara);

+       // if there's content in the website field
+       if(entry.website) {
+             // create a sup element that we'll put the link inside of
+             const websiteSup = document.createElement("sup");
+             websiteSup.textContent = "Website: ";

+             // create the link we'll put in the sup element
+             const websiteAnchor = document.createElement("a");
+             // set the url and text to the content of our website field
+             websiteAnchor.innerText = entry.website;
+             websiteAnchor.href = entry.website;
                    
+             // put the link inside of our sup element
+             websiteSup.appendChild(websiteAnchor);
+             // put the sup element inside of our entry element
+             entryContainer.appendChild(websiteSup);
+       }

        const entryMessageDiv = document.createElement("div");
        entryMessageDiv.innerHTML = entry.rendered_comment;

        entryContainer.appendChild(entryMessageDiv);
        entriesFragment.appendChild(entryContainer);
    });

    document.querySelector(".guestbook-entries").appendChild(entriesFragment);
}
```

Alright, now that that's done, it's time to add support for displaying replies!  
Now, since replies are just regular guestbook entries that have a special flag set that marks them as being a reply,  
we don't actually have to make that many changes to our code - we already have a function that lets us display guestbook entries!  
<br>

However, it's currently not quite as modular as it needs to be to support displaying replies where we want them.  
So, let's fix that!  

```js
+ // change the function signature so we can specify where to display the replies, and what verb to use for them.
+ // we need the verb parameter so the replies can say "replied" instead of "wrote".
+ async function displayEntries(entries, target, verb = "wrote...") {
    const entriesFragment = document.createDocumentFragment();

    entries.forEach(entry => {
        const entryContainer = document.createElement("div");
        entryContainer.classList.add("guestbook-entry")

        const entryNamePara = document.createElement("p");
+        // change the textcontent to use the verb variable instead of hardcoding "wrote..." 
+        entryNamePara.textContent = `${entry.name} ${verb}`;
        entryNamePara.classList.add("guestbook-entry-name");
        entryContainer.appendChild(entryNamePara);

        if(entry.website) {
            const websiteSup = document.createElement("sup");
            websiteSup.textContent = "Website: ";

            const websiteAnchor = document.createElement("a");
            websiteAnchor.innerText = entry.website;
            websiteAnchor.href = entry.website;
                    
            websiteSup.appendChild(websiteAnchor);
            entryContainer.appendChild(websiteSup);
        }

        const entryMessageDiv = document.createElement("div");
        entryMessageDiv.innerHTML = entry.rendered_comment;

        entryContainer.appendChild(entryMessageDiv);
        entriesFragment.appendChild(entryContainer);

+         // if the replies field exists and has more than zero entries, we want to display the replies 
+         if(entry.replies && entry.replies.length > 0) {
+             // we then create a reply container, so we have somewhere to put all the replies
+             const replyContainer = document.createElement("div");
+             // we add a css class, so people can style replies seperately
+             replyContainer.classList.add("reply-container");
+             // and then we call the displayReplies function again, to display all of the entries replies.
+             displayEntries(entry.replies, replyContainer, "replied...");
+             // we put the replyContainer into the entryContainer so it shows up in the document
+             entryContainer.appendChild(replyContainer);
+         }
    });

+     // finally, we use our new target variable to figure out where to put the replies, instead of relying
+     // on a hard-coded querySelector
+     target.appendChild(entriesFragment);
}

async function init() {
    const entries = await fetchFromApi(
        guestbookId + "/entries/json"
    );

    if (entries && Array.isArray(entries)) {
        const entryTarget = document.querySelector(".guestbook-entries");
+         // we also have to make a small change to init(), so that it works with our modified displayEntries function.
+         displayEntries(entries, entryTarget);
    }
}
```  
<br>

Aaaand look at that, we're done already!  
Now that we've added all of the fields we need, you can take a moment to look at the console, to inspect all of the fields the guestbooks api gives you to work with. Maybe you want to display some of them in your own implementation?  
<br>

If you want users to be able to see exactly when an entry was published, for example, you could use the entries.posted_at field!  
Or maybe you don't want your embed to support markdown, or _do_ want it to support some other, custom markup language.  
In which case, you could take a look at the entries.comment field, which contains the raw comment, that hasn't yet had any markdown parsing done to it.  
<br>

Anyways, Have fun!  
I'll see you in the next part, where I'll explain how to start displaying captchas,
in preparation for letting people actually leave guestbook entries using your embed.