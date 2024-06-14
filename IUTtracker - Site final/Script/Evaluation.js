document.addEventListener('DOMContentLoaded', () => {
    const filterButtons = document.querySelectorAll('.filter-button');
    const editButtons = document.querySelectorAll('.edit-button');
    const saveButton = document.querySelector('.save-button');
    const publishButton = document.querySelector('.publish-button');

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            alert('Filtre appliqué');
        });
    });

    editButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            const row = event.target.closest('tr');
            const noteInput = row.querySelector('input');
            noteInput.disabled = !noteInput.disabled;
            event.target.textContent = noteInput.disabled ? 'Modifier' : 'Enregistrer';
        });
    });

    saveButton.addEventListener('click', () => {
        alert('Enregistrement des notes');
    });

    publishButton.addEventListener('click', () => {
        alert('Publication des notes');
    });
});
