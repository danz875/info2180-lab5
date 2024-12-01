document.addEventListener('DOMContentLoaded', () => {
    // Get elements from the DOM
    const lookupButton = document.getElementById('lookup');
    const countryInput = document.getElementById('country');
    const resultDiv = document.getElementById('result');

    // Add event listener to the Lookup button
    lookupButton.addEventListener('click', () => {
        const country = countryInput.value.trim();

        // Display loading text while waiting for the result
        resultDiv.innerHTML = "<p>Loading...</p>";

        // Send a request to the backend to fetch data
        fetch(`/world.php?country=${encodeURIComponent(country)}`)
            .then(response => response.text())  // Parse the response as text
            .then(data => {
                // Set the response to the result div
                resultDiv.innerHTML = data;
            })
            .catch(error => {
                resultDiv.innerHTML = "<p>Error fetching data. Please try again later.</p>";
                console.error("Error fetching data:", error);
            });
    });
});
