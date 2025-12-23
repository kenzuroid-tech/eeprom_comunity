document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Sidebar Dropdown Toggle
    const dropdownBtns = document.querySelectorAll('.dropdown-btn');
    dropdownBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const dropdown = this.nextElementSibling;
            dropdown.classList.toggle('show');
            const icon = this.querySelector('.bi-chevron-down');
            if(icon) {
                icon.style.transform = dropdown.classList.contains('show') ? 'rotate(180deg)' : 'rotate(0deg)';
            }
        });
    });

    // 2. Mobile Sidebar Toggle
    const mobileBtn = document.getElementById('mobile-toggle');
    const sidebar = document.getElementById('sidebarMenu');
    if(mobileBtn) {
        mobileBtn.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });
    }

    // 3. Photo Preview Logic
    const photoInput = document.getElementById('foto');
    const photoPreview = document.getElementById('photoPreview');
    if(photoInput) {
        photoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    photoPreview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // 4. Skills Logic
    const skillInput = document.getElementById('skillInput');
    const addSkillBtn = document.getElementById('addSkill');
    const skillsContainer = document.getElementById('skillsContainer');
    
    function createSkillTag(text) {
        const tag = document.createElement('span');
        tag.className = 'skill-tag';
        tag.innerHTML = `${text} <i class="bi bi-x-lg"></i> <input type="hidden" name="skills[]" value="${text}">`;
        tag.querySelector('i').onclick = () => tag.remove();
        skillsContainer.appendChild(tag);
    }

    if(addSkillBtn) {
        addSkillBtn.onclick = () => {
            if(skillInput.value.trim() !== "") {
                createSkillTag(skillInput.value.trim());
                skillInput.value = "";
            }
        };
    }
    
    if(skillInput) {
        skillInput.onkeypress = (e) => {
            if(e.key === "Enter") {
                e.preventDefault();
                addSkillBtn.click();
            }
        };
    }

    // 5. Account Section Toggle & Autofill NIM
    const createAccCheck = document.getElementById('createAccount');
    const accountSection = document.getElementById('accountSection');
    const nimInput = document.getElementById('nimInput');
    const usernameField = document.getElementById('usernameField');

    if(createAccCheck) {
        createAccCheck.onchange = function() {
            accountSection.style.display = this.checked ? 'block' : 'none';
            usernameField.value = nimInput.value;
        };
    }

    if(nimInput) {
        nimInput.oninput = function() {
            if(createAccCheck && createAccCheck.checked) {
                usernameField.value = this.value;
            }
        };
    }

    // 6. Generate Generasi Options
    const generasiSelect = document.getElementById('generasiSelect');
    if(generasiSelect) {
        let options = "";
        for(let i=1; i<=17; i++) {
            options += `<option value="${i}">Generasi ${i}</option>`;
        }
        generasiSelect.innerHTML = options;
    }
});