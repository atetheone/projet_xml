let horaireCount = 0;

document.addEventListener('DOMContentLoaded', function() {
  if (Array.isArray(horaires)) {
    horaires.forEach(horaire => {
      addHoraireToTable(horaire.jour, horaire.heure, horaire.minute);
    });
  }

  document.querySelector('form').addEventListener('submit', prepareSubmission);
});

function addHoraire() {
  const jour = document.getElementById('jour').value;
  const heure = document.getElementById('heure').value;
  const minute = document.getElementById('minute').value;

  if (jour && heure !== '' && minute !== '') {
    addHoraireToTable(jour, heure, minute);
    // Réinitialiser les champs du formulaire
    document.getElementById('jour').value = 'lundi';
    document.getElementById('heure').value = '';
    document.getElementById('minute').value = '00';
  } else {
    alert("Veuillez remplir tous les champs d'horaire.");
  }

  // Réinitialiser les champs du formulaire
  document.getElementById('jour').value = 'lundi';
  document.getElementById('heure').value = '';
  document.getElementById('minute').value = '00';
}

function addHoraireToTable(jour, heure, minute) {
  const horairesTableBody = document.getElementById('horaires-table').querySelector('tbody');
  const row = horairesTableBody.insertRow();
  row.innerHTML = `
    <td>${jour}</td>
    <td>${heure}</td>
    <td>${minute}</td>
    <td>
        <button class="btn btn-2" type="button" onclick="removeHoraire(this)">
            <i class="fas fa-trash-alt"></i> Supprimer
        </button>
    </td>
  `;
  row.dataset.index = horaireCount++;
}

function removeHoraire(button) {
  const row = button.parentElement.parentElement;
  row.remove();
}

function prepareSubmission() {
  const horaires = [];
  document.querySelectorAll('#horaires-table tbody tr').forEach(row => {
    const jour = row.cells[0].textContent;
    const heure = row.cells[1].textContent;
    const minute = row.cells[2].textContent;
    horaires.push({ jour, heure, minute });
  });

  if (horaires.length === 0) {
    alert("Veuillez ajouter au moins un horaire.");
    event.preventDefault(); 
    return;
  }

  // Ajouter les horaires au formulaire pour la soumission
  const horairesInput = document.createElement('input');
  horairesInput.type = 'hidden';
  horairesInput.name = 'horaires';
  horairesInput.value = JSON.stringify(horaires);
  document.querySelector('form').appendChild(horairesInput);
}
