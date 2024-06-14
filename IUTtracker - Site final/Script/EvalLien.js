function createEvaluation() {
    const evaluationName = document.getElementById('evaluation-name').value;
    if (evaluationName.trim() === '') {
        alert('Veuillez entrer le nom de l\'évaluation');
        return;
    }
    
    const linkContainer = document.getElementById('link-container');
    const newLink = document.createElement('a');
    newLink.href = `#`; // You can set the actual link here
    newLink.textContent = `Lien vers ${evaluationName}    /    `;
    linkContainer.appendChild(newLink);
}
