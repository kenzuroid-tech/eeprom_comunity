document.addEventListener('DOMContentLoaded', function() {
    
    // --- UI Interactions ---

    // Sidebar Dropdown Toggle
    const dropdownBtns = document.querySelectorAll('.dropdown-btn');
    dropdownBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const dropdownItems = this.nextElementSibling;
            dropdownItems.classList.toggle('show');
            const icon = this.querySelector('.bi-chevron-down');
            if(icon) {
                icon.style.transform = dropdownItems.classList.contains('show') ? 'rotate(180deg)' : 'rotate(0deg)';
                icon.style.transition = 'transform 0.3s ease';
            }
        });
    });

    // Mobile Sidebar Toggle
    const mobileToggle = document.getElementById('mobile-toggle');
    if(mobileToggle) {
        mobileToggle.addEventListener('click', () => {
            document.getElementById('sidebarMenu').classList.toggle('show');
        });
    }

    // --- Form Logic ---

    // Member Select Auto-fill
    const memberSelect = document.getElementById('memberSelect');
    if(memberSelect) {
        memberSelect.addEventListener('change', function() {
            const opt = this.options[this.selectedIndex];
            document.getElementById('candidateName').value = opt.dataset.name || '';
            document.getElementById('candidateGen').value = opt.dataset.gen || '';
        });
    }

    // Dynamic List Adder (Misi & Proker)
    const setupAdder = (btnId, inputId, containerId) => {
        const btn = document.getElementById(btnId);
        if(btn) {
            btn.addEventListener('click', () => {
                const input = document.getElementById(inputId);
                const container = document.getElementById(containerId);
                const val = input.value.trim();
                
                if (val) {
                    const div = document.createElement('div');
                    div.className = 'dynamic-item shadow-sm';
                    div.innerHTML = `
                        <span>${val}</span>
                        <button type="button" class="btn-close small" aria-label="Remove"></button>
                    `;
                    // Remove event
                    div.querySelector('.btn-close').addEventListener('click', () => div.remove());
                    
                    container.appendChild(div);
                    input.value = '';
                }
            });
        }
    };

    setupAdder('btnAddMisi', 'inputMisi', 'containerMisi');
    setupAdder('btnAddProker', 'inputProker', 'containerProker');

    // --- Drag & Drop Table Sort Logic ---

    let dragSrcEl = null;
    const sortableContainer = document.getElementById('candidateSortable');

    function updateNumbers() {
        const rows = document.querySelectorAll('#candidateSortable tr');
        rows.forEach((row, idx) => {
            row.querySelector('td:first-child').innerText = idx + 1;
        });
    }

    function handleDragStart(e) {
        dragSrcEl = this;
        e.dataTransfer.effectAllowed = 'move';
        this.classList.add('table-active');
    }

    function handleDragOver(e) {
        if (e.preventDefault) e.preventDefault();
        return false;
    }

    function handleDrop(e) {
        if (e.stopPropagation) e.stopPropagation();
        
        if (dragSrcEl !== this) {
            const allRows = Array.from(sortableContainer.children);
            const draggedIdx = allRows.indexOf(dragSrcEl);
            const targetIdx = allRows.indexOf(this);
            
            if (draggedIdx < targetIdx) {
                this.after(dragSrcEl);
            } else {
                this.before(dragSrcEl);
            }
            updateNumbers();
        }
        return false;
    }

    function initSortableRows() {
        const rows = document.querySelectorAll('#candidateSortable tr');
        rows.forEach(row => {
            row.addEventListener('dragstart', handleDragStart);
            row.addEventListener('dragover', handleDragOver);
            row.addEventListener('drop', handleDrop);
            row.addEventListener('dragend', () => row.classList.remove('table-active'));
        });
    }

    initSortableRows();

    // --- Action Functions (Global) ---

    window.deleteCandidate = (id) => {
        if(confirm('Apakah Anda yakin ingin menghapus kandidat ini?')) {
            // Logic hapus (AJAX) bisa ditaruh di sini
            alert('Simulasi: Kandidat dengan ID ' + id + ' berhasil dihapus.');
        }
    };

    window.editCandidate = (id) => {
        // Logic ambil data edit bisa ditaruh di sini
        const modal = new bootstrap.Modal(document.getElementById('candidateModal'));
        modal.show();
    };
});