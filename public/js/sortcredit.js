$(document).ready(function() {
    // Function to sort credits by their montant
    function compare(a, b) {
        return a.montant - b.montant;
    }

    // AJAX request to retrieve credits from Symfony route
    $.ajax({
        url: '/ajaxcredit',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            // Sort the credits by montant
            data.sort(compare);

            // Display the sorted credits
            var sortedCreditsDiv = $('#sortedCredits');
            sortedCreditsDiv.empty(); // Clear previous contents
            data.forEach(function(credit) {
                var creditElement = $('<div>').text("ID: " + credit.id + ", Montant: " + credit.montant);
                sortedCreditsDiv.append(creditElement);
            });
        },
        error: function(xhr, status, error) {
            console.error('Error retrieving credits:', status, error);
        }
    });
});
