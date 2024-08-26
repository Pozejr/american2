<!-- footer.php -->
<style>
    .site-footer {
        background-color: #b52233; /* Background color of the footer */
        color: white; /* Text color */
        text-align: center; /* Center align the text */
        padding: 20px 0; /* Padding for top and bottom */
        position: fixed; /* Fix the footer to the bottom of the viewport */
        bottom: 0; /* Align at the bottom of the viewport */
        width: 100%; /* Full width of the viewport */
        left: 0; /* Align at the left of the viewport */
    }
</style>

<footer class="site-footer">
    <p>&copy; <span id="year"></span> Developed by Pandomi Tech Innovations</p>
</footer>

<script>
    // Get the current year for the footer
    function updateYear() {
        var currentYear = new Date().getFullYear();
        document.getElementById('year').textContent = currentYear;
    }
    window.onload = updateYear;
</script>

