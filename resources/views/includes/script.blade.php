<script>
    function show_admission_fields() {

        var checkbox_admit = document.getElementById("checkbox_admit");
        var hFields = document.getElementById("hidden_fields");

        if (hFields.style.display === "none") {
            hFields.style.display = "block";
            document.getElementById("admission_date").required = true;
            document.getElementById("admission_time").required = true;
            document.getElementById("ward").required = true;
        } else {
            hFields.style.display = "none";
        }
    }

    function use_current_datetime() {

        if(alt_datetime.checked == true){
            document.getElementById("admission_date").disabled = true;
            document.getElementById("admission_time").disabled = true;
            document.getElementById("admission_date").required = false;
            document.getElementById("admission_time").required = false;
        } else {
            document.getElementById("admission_date").disabled = false;
            document.getElementById("admission_time").disabled = false;
        }
    }

    function startTime() {
        const today = new Date();
        let h = today.getHours();
        let m = today.getMinutes();
        let s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('clock').innerHTML =  h + ":" + m + ":" + s;
        setTimeout(startTime, 1000);
        }

        function checkTime(i) {
        if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
        return i;
    }
</script>