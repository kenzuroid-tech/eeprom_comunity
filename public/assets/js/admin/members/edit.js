document.addEventListener('DOMContentLoaded', function() {
    // 1. Sidebar Dropdown Toggle
    const dropdownBtn = document.querySelector('.dropdown-btn');
    const dropdownItems = document.querySelector('.nav-dropdown-items');
    const chevronIcon = document.getElementById('chevronIcon');

    if (dropdownBtn) {
        dropdownBtn.addEventListener('click', function() {
            dropdownItems.classList.toggle('show');
            const isOpen = dropdownItems.classList.contains('show');
            chevronIcon.style.transform = isOpen ? 'rotate(180deg)' : 'rotate(0deg)';
        });
    }

    // 2. Mobile Sidebar Toggle
    const mobileBtn = document.getElementById('mobile-toggle');
    const sidebar = document.getElementById('sidebarMenu');
    if (mobileBtn) {
        mobileBtn.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });
    }

    // 3. Photo Preview
    const photoUpload = document.getElementById('photoUpload');
    const avatarPreview = document.getElementById('avatarPreview');
    if (photoUpload) {
        photoUpload.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    avatarPreview.innerHTML = `<img src="${event.target.result}" alt="Avatar">`;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // 4. Skill Tag Logic
    const skillsInput = document.getElementById('skillsInput');
    const skillsContainer = document.getElementById('skillsContainer');
    const addSkillBtn = document.getElementById('addSkillBtn');

    // Pre-populate skills (as per HTML initial state)
    const initialSkills = ['Python', 'Arduino', 'Web Dev'];
    initialSkills.forEach(skill => createSkillTag(skill));

    function createSkillTag(text) {
        const span = document.createElement('span');
        span.className = 'skill-tag';
        span.innerHTML = `${text} <button type="button">&times;</button>`;
        
        span.querySelector('button').addEventListener('click', function() {
            span.remove();
        });
        
        skillsContainer.appendChild(span);
    }

    const handleAddSkill = () => {
        const val = skillsInput.value.trim();
        if (val) {
            createSkillTag(val);
            skillsInput.value = '';
        }
    };

    if (addSkillBtn) {
        addSkillBtn.addEventListener('click', handleAddSkill);
    }

    if (skillsInput) {
        skillsInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                handleAddSkill();
            }
        });
    }

    // 5. Toggle Status Logic (Activate / Make Alumni)
    const toggleBtn = document.getElementById('toggleStatusBtn');
    const stActive = document.getElementById('stActive');
    const stAlumni = document.getElementById('stAlumni');

    const updateToggleButton = () => {
        if (stAlumni.checked) {
            toggleBtn.innerHTML = '<i class="bi bi-check-circle me-1"></i> Activate';
            toggleBtn.className = 'btn btn-outline-success btn-sm rounded-pill';
        } else {
            toggleBtn.innerHTML = '<i class="bi bi-mortarboard me-1"></i> Make Alumni';
            toggleBtn.className = 'btn btn-outline-secondary btn-sm rounded-pill';
        }
    };

    // Initialize button state
    updateToggleButton();

    // Listen for radio changes
    [stActive, stAlumni].forEach(radio => {
        radio.addEventListener('change', updateToggleButton);
    });

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            if (stActive.checked) {
                stAlumni.checked = true;
            } else {
                stActive.checked = true;
            }
            updateToggleButton();
        });
    }

    // 6. Form Submit Simulation
    const form = document.getElementById('editMemberForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            // Implement your AJAX or form processing logic here
            alert('Berhasil memperbarui data anggota!');
        });
    }
});