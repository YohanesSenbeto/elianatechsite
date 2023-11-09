// JavaScript code to handle the button click event
document.getElementById("searchForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent the form from submitting

    // Get the entered IP address
    var ipAddress = document.getElementById("wanip").value;

    // Check if the IP address is empty
    if (ipAddress.trim() === "") {
        alert("Please enter a WAN IP address.");
        return; // Stop further execution
    }

    // Create an AJAX request
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "result.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Define the callback function when the request is complete
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            // Display the response from the PHP file
            console.log(xhr.responseText);
        }
    };

    // Send the form data to the PHP file
    xhr.send("wan_ip=" + encodeURIComponent(ipAddress));
});