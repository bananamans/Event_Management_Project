<html>
<div class="navbar">
    <div class="navLeft">
        <img src="images/favicon.png" alt="logo" id="logo" />
        <div class="navItem" id="navHome"><a href="#">Home</a></div>
        <div class="navItem"><a href="search.php">Search</a></div>
        <div class="navItem">
            <a href="seminarForm.php">Booking</a>
            <ul class="subMenu">
                <li><a href="seminarForm.php" id="topItem">Seminar</a></li>
                <li><a href="privateEventForm.php">Private Event</a></li>
            </ul>
        </div>
        <div class="navItem" id="navAbout"><a href="publicPage/about.html">About</a></div>
    </div>
    <div class="navRight">
        <div id="navProfilePic" style="width: 50px; height: 50px">
            <img src="" alt="Profile Icon" class="logo" id="profileIcon" width="100%" height="100%"
                style="display: none;">
        </div>
        <ul id="dropdownContent" class="dropdown-content">
            <li><a href="editProfile.php">Edit Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</div>
<div class="breakSpace"></div>

</html>
<?php
if (isset($_SESSION['username'])) {
    echo "<script> 
        document.addEventListener('DOMContentLoaded', function() {
            var navProfilePic = document.getElementById('navProfilePic');
            var profileIcon = document.getElementById('profileIcon');
            var dropdownContent = document.getElementById('dropdownContent');

            if ('" . $_SESSION['profile_icon'] . "' !== '') {
                profileIcon.src = '" . $_SESSION['profile_icon'] . "';
            }else{
                profileIcon.src = 'images/profile-icon.png';
            }
            
            profileIcon.style.display = 'block';

            profileIcon.addEventListener('click', function() {
                window.location.href = 'uploadPhoto.php';
            });

            profileIcon.addEventListener('mouseenter', function() {
                dropdownContent.style.display = 'block';
            });
        
            dropdownContent.addEventListener('mouseenter', function() {
                dropdownContent.style.display = 'block';
            });
        
            profileIcon.addEventListener('mouseleave', function() {
                dropdownContent.style.display = 'none';
            });
        
            dropdownContent.addEventListener('mouseleave', function() {
                dropdownContent.style.display = 'none';
            });

            document.getElementById('navAbout').style.display = 'none';
            document.getElementById('logo').addEventListener('click', () => {
                window.location.href = 'memberDashboard.php';
            });
            document.getElementById('navHome').addEventListener('click', () => {
                window.location.href = 'memberDashboard.php';
            });
        });
        </script>";

} else {
    echo "<script> 
            document.getElementById('navProfilePic').innerHTML =
                '<a href=\"login.php\">Login</a>';
            document.getElementById('logo').addEventListener('click', () => {
                window.location.href = 'index.html';
            });
            document.getElementById('navHome').addEventListener('click', () => {
                window.location.href = 'index.html';
            });
        </script>";
}
?>