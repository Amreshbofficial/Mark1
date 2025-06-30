// Admin Dashboard Scripts
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Charts
    if (typeof Chart !== 'undefined') {
        // Sales Chart
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7'],
                datasets: [{
                    label: 'Sales ($)',
                    data: [1200, 1900, 1500, 1800, 2200, 1700, 2000],
                    borderColor: '#0a45a6',
                    backgroundColor: 'rgba(10, 69, 166, 0.1)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Categories Chart
        const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
        const categoriesChart = new Chart(categoriesCtx, {
            type: 'doughnut',
            data: {
                labels: ['Electronics', 'Fashion', 'Home & Kitchen', 'Beauty', 'Sports'],
                datasets: [{
                    data: [35, 25, 20, 12, 8],
                    backgroundColor: [
                        '#0a45a6',
                        '#3a6bc7',
                        '#6b91d9',
                        '#9cb7eb',
                        '#cdddfd'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    }

    // Delete confirmation
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Are you sure you want to delete this item?')) {
                e.preventDefault();
            }
        });
    });
});