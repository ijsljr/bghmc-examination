<script>
    function show_ward() {
        var checkbox_admit = document.getElementById("checkbox_admit");
        var hFields = document.getElementById("hidden_fields");
        var ward = document.getElementById("ward");
        var admission_date = document.getElementById("admission_date");
        var admission_time = document.getElementById("admission_time");

        if (hFields.style.display === "none") {
            hFields.style.display = "block";
            document.getElementById("admission_date").required = true;
            document.getElementById("admission_time").required = true;
            document.getElementById("ward").required = true;
        } else {
            hFields.style.display = "none";
        }

        // if(checkbox_admit.checked == true){
        //     document.getElementById("ward").disabled = false;
        // } else {
        //     document.getElementById("ward").disabled = true;
        // }
    }
</script>