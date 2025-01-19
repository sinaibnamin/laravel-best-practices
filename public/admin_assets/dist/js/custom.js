// previous page should be reloaded when user navigate through browser navigation
// for mozilla
window.onunload = function () { };
// for chrome
if (window.performance && window.performance.navigation.type === window.performance.navigation.TYPE_BACK_FORWARD) {
    location.reload();
}
/////////////////

// service worker start

if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js', { type: 'module' })
        .then(registration => {
            console.log('Service Worker registered with scope:', registration.scope);
        })
        .catch(error => {
            console.log('Service Worker registration failed:', error);
        });


    navigator.serviceWorker.ready.then(() => {
        console.log('Service Worker is active.');
    });
}

// service worker end


// csrf token refresh sttart
document.addEventListener('DOMContentLoaded', function () {
    // Function to fetch a new CSRF token
    function refreshCsrfToken() {
        fetch('/csrf-token') // Adjust this endpoint to return the CSRF token
            .then(response => response.json())
            .then(data => {
                // Update all CSRF token inputs on the page
                const csrfInputs = document.querySelectorAll('input[name="_token"]');
                csrfInputs.forEach(input => {
                    input.value = data.token; // Set the new token in the input fields
                });

                // Update the CSRF token in the meta tag
                const csrfMetaTag = document.querySelector('meta[name="csrf-token"]');
                if (csrfMetaTag) {
                    csrfMetaTag.setAttribute('content', data.token); // Set the new token in the meta tag
                }

                // Optional: Log the new token for debugging purposes
                console.log('CSRF token refreshed:', data.token);
            })
            .catch(error => {
                console.error('Error refreshing CSRF token:', error);
            });
    }

    // Refresh the CSRF token every 5 minutes
    setInterval(refreshCsrfToken, 300000);
});

// csrf token refresh end



document.addEventListener("DOMContentLoaded", function () {

    const links = document.querySelectorAll("a.double-click-link");

    links.forEach(function (link) {

        link.addEventListener("click", function (event) {
            event.preventDefault();
        });

        link.addEventListener("dblclick", function () {
            window.location.href = this.href;
        });
    });
});

// double click button end

// submit form disable on click start 

const forms = document.querySelectorAll('form'); // Select all forms

// Loop through each form and attach an event listener
forms.forEach(form => {
    form.addEventListener('submit', event => {
    
        const submitButton = form.querySelector('button[type=submit]'); 
        console.log(form);
        if (submitButton) {
           
            submitButton.disabled = true; // Disable the button
            submitButton.innerText = 'Please wait...'; // Change button text
        }
    });
});

// submit form disable on click end