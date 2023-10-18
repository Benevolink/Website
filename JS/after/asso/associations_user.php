<script>
    if(document. readyState === 'complete'){
        get_list_assos();
    }else{
        let body = document.body;
        body.addEventListener("load",function(){
            get_list_assos();
        })
    }
    
</script>