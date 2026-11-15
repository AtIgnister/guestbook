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