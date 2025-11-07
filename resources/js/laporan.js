document.addEventListener('DOMContentLoaded', function() {
    // Filter and Search functionality
    const statusFilter = document.getElementById('status-filter');
    const searchInput = document.getElementById('search-input');
    const reportCards = document.querySelectorAll('.report-card');

    function filterReports() {
        const statusValue = statusFilter.value.toLowerCase();
        const searchValue = searchInput.value.toLowerCase();

        reportCards.forEach(card => {
            const status = card.dataset.status;
            const judul = card.dataset.judul;
            const lokasi = card.dataset.lokasi;

            const statusMatch = !statusValue || status === statusFilter.value;
            const searchMatch = !searchValue ||
                judul.includes(searchValue) ||
                lokasi.includes(searchValue) ||
                status.toLowerCase().includes(searchValue);

            card.style.display = (statusMatch && searchMatch) ? 'block' : 'none';
        });
    }

    if (statusFilter && searchInput) {
        statusFilter.addEventListener('change', filterReports);
        searchInput.addEventListener('input', filterReports);
    }

    // Delete confirmation modal
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        // Close modal when clicking outside
        deleteModal.addEventListener('click', function(e) {
            if (e.target === deleteModal) {
                closeDeleteModal();
            }
        });
    }
});

function confirmDelete(id, title) {
    const deleteModal = document.getElementById('deleteModal');
    const deleteTitle = document.getElementById('delete-title');
    const deleteForm = document.getElementById('delete-form');

    if (deleteTitle) deleteTitle.textContent = title;
    if (deleteForm) deleteForm.action = `/laporan/${id}`;
    if (deleteModal) deleteModal.style.display = 'flex';
}

function closeDeleteModal() {
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) deleteModal.style.display = 'none';
}
