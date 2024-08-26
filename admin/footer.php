<!-- footer.php -->
<footer>
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

