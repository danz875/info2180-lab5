document.addEventListener('DOMContentLoaded', function() {
    // Country Lookup Button
    const lookupButton = document.getElementById('lookup');
    lookupButton.addEventListener('click', function() {
        const countryInput = document.getElementById('country').value;
        
        // Fetch country data
        fetch(`world.php?country=${encodeURIComponent(countryInput)}`)
            .then(response => response.text())
            .then(data => {
                document.getElementById('result').innerHTML = data;
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('result').innerHTML = 'Error fetching data';
            });
    });

    // City Lookup Button
    const cityLookupButton = document.getElementById('citylookup');
    cityLookupButton.addEventListener('click', function() {
        const countryInput = document.getElementById('country').value;
        
        // Fetch city data
        fetch(`world.php?country=${encodeURIComponent(countryInput)}&lookup=cities`)
            .then(response => response.text())
            .then(data => {
                document.getElementById('result').innerHTML = data;
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('result').innerHTML = 'Error fetching data';
            });
    });
});