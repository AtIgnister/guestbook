## Creating a custom embed  
So, you wanna create a custom guestbook embed?  
Luckily, Guestbooks has an API that let's you do just that!  
Once you're done with this tutorial, you'll have your very own custom embed, that works very similiarly to the official version - and you'll be able to go ahead and add whatever new, custom functionality you want!  

### Chapters
<a href="/blog/diy">Chapter 1: Creating a basic, read-only guestbook (Current Chapter)</a>  
<a href="/blog/diy-chapter2">Chapter 2: Displaying optional fields & showing replies</a>

### Step 1: Creating the basic HTML
First of all, we're gonna need a bit of an HTML skeleton that we can use JS to insert all of your guestbook entries into.  
We'll add more to this later, but for now, just copy paste this code into an html file:
```html
<h1>My very cool guestbook</h1>
<div class="guestbook-entries"></div>
```

### Step 2: Preparing to call the API
Alright, nice!
We have some very basic html set up, but we're not fetching any guestbook entries right now. Let's start working on changing that!  

First of all, we're going to add a variable that tells us where exactly the api is.  
This will save us a bit of manual typing later, and will also make it easier to point your script at other instances of guestbooks, in case you want to self-host the service, for example.  
```html
<h1>My very cool guestbook</h1>
<div class="guestbook-entries"></div>

+ <script>
+ const apiUrl = "{{ config("app.url") }}/api/"
+ </script>
```  
Cool! Now that that's done, we can start querying the api.
Well, almost.
We do need one thing, still: The ID of your guestbook!  
Otherwise, how would guestbooks know what data to show you?  

<br>

Luckily, getting your guestbook id is pretty easy! <a href="/settings/developer">Just open the developer settings page of your account</a>, the first thing you see should be a list of the ids of all of your guestbooks.  
Simply press the copy button to get the ID of the guestbook you want to use for your embed.  

<br>
Alright, now that you've got the ID, we'll add another variable for it to our Javascript code.  

Same reasoning as last time: You wanna be able to edit this easily later, in case you want to the embed to display data for a different guestbook.

```html
<h1>My very cool guestbook</h1>
<div class="guestbook-entries"></div>

<script>
const apiUrl = "{{ config("app.url") }}/api/"
+ const guestbookId = "YOUR_ID_HERE"
</script>
```   

### Step 3: Calling the API
Nice! We're now ready to write some API calls!  
Time to add a function to let us do that!

```html
<h1>My very cool guestbook</h1>
<div class="guestbook-entries"></div>

<script>
const apiUrl = "{{ config("app.url") }}/api/"
const guestbookId = "YOUR_ID_HERE"

+ async function fetchFromApi(fetchPath) {
+     // combine apiUrl and our fetchPath, to get the full path we want to query
+     const url = apiUrl + fetchPath;
     
+     // use a try catch block, so that this function doesn't crash our script if it fails
+     // if we don't get any result, just want to return null instead of crashing.
+     try {
+          // take the result from our query, and put it into the response variable
+          // making a fetch request is asynchronous, which means we need to manually wait for it to complete, hence the wait keyword here.
+         const response = await fetch(url);
+ 
+         // if something went wrong, we want to know about it. Hence: logging it to the console.
+         if (!response.ok) {
+             throw new Error(`Response status: ${response.status}`);
+         }
 
+         // we save the result to the json variable.
+         const json = await response.json();

+         // we then log that result to the console. This is temporary, for now we just want to see if our api fetching code actually works.
+         console.log(json);

+         // now, all we need to do is return the JSON from our function.
+         return json;
+     } catch (error) {
+         // if something goes wrong, we just log it to the console, so we can see what happened.
+         console.error(error.message);
+         // we then simply return null, to indicate that we couldn't fetch the data.
+         return null;
+     }
+ }

+ // and, finally, we try to actually get some data from the api with our new function.
+ // the api route we are calling here is "{{ config("app.url") }}/api/YOUR_GUESTBOOK_ID/entries/json"
+ // this is because the /entries/json route will give us a json object that contains every entry of your guestbook
+ // we'll need this object for the next step.
+ const result = fetchFromApi(guestbookId + "/entries/json");
</script>
```   
Once you've edited your code to add those changes, and refreshed, you should be able to see all the entries for your guestbook logged in your browser console.
(To view the console, simply press F12, then click on the console tab)  
<br> 

### Step 4: Displaying guestbook entries
At last, we're ready!  
Time to display some entries from your guestbook!
This step is quite large, so make sure to read through everything carefully.  
Still, nothing that's happening here is all too complicated.  

```html
<h1>My very cool guestbook</h1>
<div class="guestbook-entries"></div>

<script>
const apiPath = "http://localhost:8000/api/"
const guestbookId = "YOUR_ID_HERE"

async function fetchFromApi(fetchPath) {
    const url = apiPath + fetchPath;

    try {
        const response = await fetch(url);

        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }

        const json = await response.json();
        console.log(json);
        return json;
    } catch (error) {
        console.error(error.message);
        return null;
    }
}

+ // this function will be responsible for displaying all of our guestbook entries
+ // the function takes the entries as input instead of fetching them, so that in a later step we'll be able to asynchronously fetch all the entries as the HTML document is still loading.
+ // but you don't need to worry about that for now.
+ // doing it this way is also slightly nicer, in case we ever want to use the entries object for something other than just rendering all the entries here.
+ // like adding an entry counter, for example.
+ async function displayEntries(entries) {
+     // first, we create a document fragment.
+     // we'll be adding all of our entry html elements to this document fragment. This is basically a temporary container for all of our elements to go into before we add them to the document.
+     const entriesFragment = document.createDocumentFragment();
+ 
+     // now, we loop through each entry
+     entries.forEach(entry => {
+         // first, we make a div for the entry content to go into.
+         const entryContainer = document.createElement("div");
+         // then we give it a class, so we can style it with css later, if we want to.
+         entryContainer.classList.add("guestbook-entry");

+         // now, we create a paragraph element for the name of the user who wrote the entry.
+         const entryNamePara = document.createElement("p");
+         // we set the text content of the entry to the users name.
+         // it's important that this is the text content, and not the innerHTML.
+         // if we set this via innerHTML, any HTML tags inside the users name would be rendered.
+         entryNamePara.textContent = `${entry.name} said...`;
+         // like last time, we also give the name element a class.
+         entryNamePara.classList.add("guestbook-entry-name");
+         // then, we add the name element to our entry container.
+         entryContainer.appendChild(entryNamePara);

+         // next, we create a div for the message the user left us.
+         // this isn't a paragraph, because the users rendered message might contain html content, 
+         // as guestbooks allows markdown, and also auto-transforms linbreaks into the <br> html element.
+         // so, using a div makes more sense here.
+         const entryMessageDiv = document.createElement("div");
+         // we then put the text of the comment the user wrote into the div we just made.
+         // it's important that we set the innerHTML here, and not textcontent.
+         // because we need the html in the message to get rendered, not displayed as plain text.
+         entryMessageDiv.innerHTML = entry.rendered_comment;

+         // we then add the message to our entry container
+         entryContainer.appendChild(entryMessageDiv);
+         // and finally, we add the entry container to our document fragment.
+         entriesFragment.appendChild(entryContainer);
+     });

+     // now, we take the document fragment, and put everything that's inside the fragment into our .guestbook-entries element
+     // once that's done, they'll all show up in the HTML document.
+     document.querySelector(".guestbook-entries").appendChild(entriesFragment);
+ }

+ // this init function is responsible for fetching all of the data our guestbook embed needs.
+ // for now, that just means getting all the entries people left on the guestbook,
+ // and passing them to the displayEntries function, which then displays all our guestbook entries.
+ async function init() {
+     // we get all of the entries here, via the /entries/json endpoint of the api.
+     const entries = await fetchFromApi(
+         guestbookId + "/entries/json"
+     );
+     // then we check if the function actually returned anything,
+     // and if the data it did return is an array.
+     // our code for displaying entries expects both of these things to be true -
+     // so we check for them here.
+     if (entries && Array.isArray(entries)) {
+         displayEntries(entries);
+     }
+     // if one of the conditions is not true, we just don't display the entries.
+ }

+ // finally, we get to call the init(); function. this is what actually makes all our guestbook entries show up on the screen.
+ init();
</script>
```
Once you've added all of this code, try and refresh the page!  
The name and content of all the guestbook entries should now show be visible.
We're not _quite_ done now, however.
There is still one thing left to do:  

## Step 5: Adding custom heading styles  
Guestbooks supports using markdown for guestbook entries.  
This means that users will be able to add headings in their guestbook entries.  
If guestbooks simply rendered those heading elements as &lt;h1&gt;'s, &lt;h2&gt;'s and so on, it would mess up the heading order of the website the guestbook is on -  
Which would be pretty terrible for accessibility.  

So, guestbooks instead replaces these elements with paragraph elements that have custom classes.  
<br>
Basically, this means that this guestbook comment:
```md
# This is a heading!
```  
<br>

Would be turned into this:
```html
<p class="h h1">This is a heading!</p>
```  
<br>  

Instead of this, like you'd normally expect:
```html
<h1>This is a heading!</h1>
```  
<br>  

Long story short: You're gonna need to add some custom css to your markup, so that these fake headings display properly.  
Simply copy-paste somes styles for these custom classes into your existing markup:
```html
+ <style>
+ /* fake heading styles for guestbook entries*/
+ .h {
+     font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
+     line-height: 1.2;

+     margin-top: 0.7em;
+     margin-bottom: 0.5em;
}

+ .h1 {
+     font-size: 2.25rem; /* 36px */
+     font-weight: 700;
+     letter-spacing: -0.02em;
+ }

+ .h2 {
+     font-size: 1.875rem; /* 30px */
+     font-weight: 700;
+     letter-spacing: -0.01em;
+ }

+ .h3 {
+     font-size: 1.5rem; /* 24px */
+     font-weight: 700;
+ }

+ .h4 {
+     font-size: 1.25rem; /* 20px */
+     font-weight: 600;
+ }

+ .h5 {
+     font-size: 1.125rem; /* 18px */
+     font-weight: 600;
+ }

+ .h6 {
+     font-size: 1rem; /* 16px */
+     font-weight: 600;
+ }
+ </style>

<h1>My very cool guestbook</h1>

<div class="guestbook-entries"></div>

<script>
// ...
</script>
```   
<br>

Aaaand, that's it!  
You can obviously change these styles to whatever you like, in case you want your headings to look different.  
The ones that are shown here will just make your headings look close enough to the default HTML headings that most browsers show. You can get a lot fancier with this, if you wanna do that.  
<br>

Anyways, that's the first Chapter of our tutorial done!  
Congrats on making it this far!  
<br>

By now, your guestbook embed should look kind of like this:  
![](/embed-tutorial-chapter1-finished.webp)

In the next chapter, we'll go and render all of the optional fields that the guestbooks api gives us, as well as rendering guestbook entry replies -  
And I'll give you some suggestions for fields that you might want to display in your own, custom embed that are not shown in the official one!  

<br>
<a href="diy-chapter2">Next Chapter: Displaying optional fields & showing replies</a>