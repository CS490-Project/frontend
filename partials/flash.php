
<div class="container" id="flash">
    <?php $messages = getMessages(); ?>
    <?php if ($messages): ?>
        <?php foreach ($messages as $msg): ?>
            <div id="flash">
                <h2 class="Error"> <?php echo $msg; ?> </h2>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<script>
    //used to pretend the flash messages are below the first nav element
    function moveMeUp(ele) {
        let target = document.getElementsByTagName("header")[0];
        if (target) {
            target.after(ele);
        }
    }

    moveMeUp(document.getElementById("flash"));
</script>