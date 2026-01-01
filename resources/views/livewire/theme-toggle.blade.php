<aside class="absolute top-2 left-2">
<script>
    function domtoggle()
    {
        if(document.body.classList.contains('dark')){
        document.body.classList.remove('dark')
    }
    else{
        document.body.classList.add('dark')
    }
    }
</script>
    <button wire:click="toggle" onClick="domtoggle()">Toggle theme</button>
</aside>
