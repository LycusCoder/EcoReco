<script>
    // Toggle Edit Profil
    const toggleEditButton = document.getElementById('toggle-edit-profile');
    const viewProfile = document.getElementById('view-profile');
    const editProfileForm = document.getElementById('edit-profile-form');

    if (toggleEditButton && viewProfile && editProfileForm) {
        toggleEditButton.addEventListener('click', () => {
            viewProfile.classList.toggle('hidden');
            editProfileForm.classList.toggle('hidden');
        });
    }

    // Dropdown Menu
    const dropdownButton = document.getElementById('dropdown-button');
    const dropdownMenu = document.getElementById('dropdown-menu');

    if (dropdownButton && dropdownMenu) {
        dropdownButton.addEventListener('click', () => {
            dropdownMenu.classList.toggle('show');
        });

        document.addEventListener('click', (event) => {
            if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.remove('show');
            }
        });
    }
</script>
