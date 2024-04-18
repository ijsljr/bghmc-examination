<script>
    function show_ward() {
        var checkbox_admit = document.getElementById("checkbox_admit");
        var ward_div = document .getElementById("ward");

        if(checkbox_admit.checked == true){
            document.getElementById("ward").disabled = false;
        } else {
            document.getElementById("ward").disabled = true;
        }
    }
</script>