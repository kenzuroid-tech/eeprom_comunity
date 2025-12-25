document.addEventListener('DOMContentLoaded', function () {
    // Dropdown Menu Toggle
    const dropdownBtns = document.querySelectorAll('.dropdown-btn');
    
    dropdownBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const dropdownItems = this.nextElementSibling;
            const isShowing = dropdownItems.classList.contains('show');
            
            // Close other dropdowns (Optional)
            // document.querySelectorAll('.nav-dropdown-items').forEach(el => el.classList.remove('show'));

            dropdownItems.classList.toggle('show');
            
            // Rotate icon
            const icon = this.querySelector('.bi-chevron-down');
            if (icon) {
                icon.style.transform = !isShowing ? 'rotate(180deg)' : 'rotate(0deg)';
                icon.style.transition = 'transform 0.3s ease';
            }
        });
    });

    // Mobile Sidebar Toggle
    const mobileToggle = document.getElementById('mobile-toggle');
    const sidebar = document.getElementById('sidebarMenu');
    
    if (mobileToggle) {
        mobileToggle.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });
    }

    // Countdown Timer Simulation
    function startTimer(duration, display) {
        let timer = duration, hours, minutes, seconds;
        
        const interval = setInterval(() => {
            hours = parseInt(timer / 3600, 10);
            minutes = parseInt((timer % 3600) / 60, 10);
            seconds = parseInt(timer % 60, 10);

            hours = hours < 10 ? "0" + hours : hours;
            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = hours + ":" + minutes + ":" + seconds;

            if (--timer < 0) {
                clearInterval(interval);
                display.textContent = "00:00:00";
            }
        }, 1000);
    }

    const timerElement = document.querySelector('#countdownTimer');
    if (timerElement) {
        startTimer(53130, timerElement);
    }

    // Real-time Votes Simulation
    const liveVotesEl = document.getElementById('liveVotes');
    const participationRateEl = document.getElementById('participationRate');

    if (liveVotesEl && participationRateEl) {
        setInterval(() => {
            let current = parseInt(liveVotesEl.innerText);
            const totalVoters = 250; // Target simulasi

            if (current < totalVoters && Math.random() > 0.6) {
                current++;
                liveVotesEl.innerText = current;
                participationRateEl.innerText = ((current / totalVoters) * 100).toFixed(1) + '%';
            }
        }, 5000);
    }
});