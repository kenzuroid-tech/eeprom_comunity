document.addEventListener('DOMContentLoaded', function () {
    // Sidebar Toggle
    const mobileBtn = document.getElementById('mobile-toggle');
    const sidebar = document.getElementById('sidebarMenu');
    if (mobileBtn) {
        mobileBtn.addEventListener('click', () => sidebar.classList.toggle('show'));
    }

    // Photo Preview
    const photoUpload = document.getElementById('photoUpload');
    const avatarPreview = document.getElementById('avatarPreview');
    photoUpload.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                avatarPreview.innerHTML = `<img src="${e.target.result}" style="width:100%; height:100%; object-fit:cover;">`;
            }
            reader.readAsDataURL(file);
        }
    });

    // Simple Skill Badge Adder (Edit Tab)
    const skillInput = document.getElementById('skillInput');
    const addSkillBtn = document.getElementById('addSkill');
    const editBadgeContainer = document.getElementById('edit-skill-badges');

    function createBadge(text) {
        const badge = document.createElement('span');
        badge.className = 'skill-badge bg-primary text-white';
        badge.innerHTML = `${text} <i class="bi bi-x-circle ms-2 cursor-pointer" onclick="this.parentElement.remove()"></i>`;
        editBadgeContainer.appendChild(badge);
    }

    addSkillBtn.addEventListener('click', () => {
        if (skillInput.value.trim() !== "") {
            createBadge(skillInput.value.trim());
            skillInput.value = "";
        }
    });

    // Form Submit Simulation
    document.getElementById('editProfileForm').addEventListener('submit', function (e) {
        e.preventDefault();
        alert('Perubahan profil berhasil disimpan!');
        document.getElementById('view-tab').click();
    });
});
