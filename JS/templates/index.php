<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script type="module">
    function test(){
        import("./classes/PopUp.js").then((module)=>{
            let PopUp = new module.PopUp();
            PopUp.show($("body"));
            console.log("ok");
        });
    }
    $(document).ready(test);
</script>
<?php
echo "blabla";
?>