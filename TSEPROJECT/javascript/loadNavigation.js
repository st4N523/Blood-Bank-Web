document.addEventListener("DOMContentLoaded", function() {
    fetch('/TSEPROJECT/navigation.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('navigation').innerHTML = data;
        })
        .catch(error => console.error('Error fetching navigation:', error));
});