// Auto-hide alert messages after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s, transform 0.5s';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            
            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 5000);
    });
});

// Confirm delete action
document.addEventListener('DOMContentLoaded', function() {
    const deleteForms = document.querySelectorAll('form[action*="tugas"]');
    
    deleteForms.forEach(form => {
        if (form.querySelector('input[name="_method"][value="DELETE"]')) {
            form.addEventListener('submit', function(e) {
                if (!confirm('Yakin ingin menghapus tugas ini?')) {
                    e.preventDefault();
                }
            });
        }
    });
});

// Form validation
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredInputs = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredInputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.style.borderColor = '#dc3545';
                } else {
                    input.style.borderColor = '#e0e0e0';
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Mohon lengkapi semua field yang wajib diisi!');
            }
        });
    });
});

// Highlight overdue tasks
document.addEventListener('DOMContentLoaded', function() {
    const tugasTable = document.querySelector('.tugas-table tbody');
    
    if (tugasTable) {
        const rows = tugasTable.querySelectorAll('tr');
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        
        rows.forEach(row => {
            const deadlineCell = row.children[3]; // Deadline column
            const statusBadge = row.querySelector('.status-badge');
            
            if (deadlineCell && statusBadge) {
                const deadlineText = deadlineCell.textContent.trim();
                const deadlineDate = parseIndonesianDate(deadlineText);
                
                // Highlight if overdue and not completed
                if (deadlineDate < today && statusBadge.classList.contains('status-belum')) {
                    row.style.backgroundColor = '#ffebee';
                    deadlineCell.style.color = '#dc3545';
                    deadlineCell.style.fontWeight = 'bold';
                }
            }
        });
    }
});

// Helper function to parse Indonesian date format
function parseIndonesianDate(dateStr) {
    const months = {
        'Jan': 0, 'Feb': 1, 'Mar': 2, 'Apr': 3, 'Mei': 4, 'Jun': 5,
        'Jul': 6, 'Agt': 7, 'Sep': 8, 'Okt': 9, 'Nov': 10, 'Des': 11
    };
    
    const parts = dateStr.split(' ');
    if (parts.length === 3) {
        const day = parseInt(parts[0]);
        const month = months[parts[1]];
        const year = parseInt(parts[2]);
        return new Date(year, month, day);
    }
    
    return new Date();
}

// Add smooth scrolling
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});