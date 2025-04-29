document.addEventListener("DOMContentLoaded", function() {
    fetch('/TSEPROJECT/footer.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('footer').innerHTML = data;
        })
        .catch(error => console.error('Error fetching footer:', error));
});