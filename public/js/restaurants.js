let platCount = 1;
let menuCount = 1;
let plats = [];
let menus = [];

function addPlat() {
  const nom = document.querySelector(`input[name="carte[${platCount - 1}][nom]"]`).value;
  const type = document.querySelector(`input[name="carte[${platCount - 1}][type]"]`).value;
  const prix = document.querySelector(`input[name="carte[${platCount - 1}][prix]"]`).value;
  const devise = document.querySelector(`input[name="carte[${platCount - 1}][devise]"]`).value;
  const description = document.querySelector(`textarea[name="carte[${platCount - 1}][description]"]`).value;

  plats.push({ nom, type, prix, devise, description });

  console.log(plats);

  updatePlatsTable();

  document.querySelector(`input[name="carte[${platCount - 1}][nom]"]`).value = '';
  document.querySelector(`input[name="carte[${platCount - 1}][type]"]`).value = '';
  document.querySelector(`input[name="carte[${platCount - 1}][prix]"]`).value = '';
  document.querySelector(`input[name="carte[${platCount - 1}][devise]"]`).value = '';
  document.querySelector(`textarea[name="carte[${platCount - 1}][description]"]`).value = '';

  updateMenuOptions();
  platCount++;
}

function updatePlatsTable() {
    const platsTableBody = document.getElementById('platsTable').querySelector('tbody');
    platsTableBody.innerHTML = '';
    plats.forEach((plat, index) => {
      const row = platsTableBody.insertRow();
      row.innerHTML = `
        <td>${plat.nom}</td>
        <td>${plat.type}</td>
        <td>${plat.prix}</td>
        <td>${plat.devise}</td>
        <td>${plat.description}</td>
        <td>
          <button type="button" onclick="editPlat(${index})" class="btn edit"><i class="fas fa-edit"></i>Modifier</button>
          <button type="button" onclick="deletePlat(${index})" class="btn delete"><i class="fas fa-trash-alt"></i>Supprimer</button>
        </td>
      `;
    });
}

function editPlat(index) {
  const plat = plats[index];
  document.querySelector(`input[name="carte[${platCount - 1}][nom]"]`).value = plat.nom;
  document.querySelector(`input[name="carte[${platCount - 1}][type]"]`).value = plat.type;
  document.querySelector(`input[name="carte[${platCount - 1}][prix]"]`).value = plat.prix;
  document.querySelector(`input[name="carte[${platCount - 1}][devise]"]`).value = plat.devise;
  document.querySelector(`textarea[name="carte[${platCount - 1}][description]"]`).value = plat.description;

  plats.splice(index, 1);
  updatePlatsTable();
}

function deletePlat(index) {
  plats.splice(index, 1);
  updatePlatsTable();
  updateMenuOptions();
}

function addMenu() {
  const titre = document.querySelector(`input[name="menus[${menuCount - 1}][titre]"]`).value;
  const description = document.querySelector(`textarea[name="menus[${menuCount - 1}][description]"]`).value;
  const prix = document.querySelector(`input[name="menus[${menuCount - 1}][prix]"]`).value;
  const elements = Array.from(document.querySelector(`select[name="menus[${menuCount - 1}][elements][]"]`).selectedOptions)
                       .map(option => option.value);

  menus.push({ titre, description, prix, elements });
  updateMenusTable();

  // Vider les champs de saisie
  document.querySelector(`input[name="menus[${menuCount - 1}][titre]"]`).value = '';
  document.querySelector(`textarea[name="menus[${menuCount - 1}][description]"]`).value = '';
  document.querySelector(`input[name="menus[${menuCount - 1}][prix]"]`).value = '';
  document.querySelector(`select[name="menus[${menuCount - 1}][elements][]"]`).innerHTML = '';

  updateMenuOptions();
}

function updateMenusTable() {
  const menusTableBody = document.getElementById('menusTable').querySelector('tbody');
  menusTableBody.innerHTML = '';
  menus.forEach((menu, index) => {
    const row = menusTableBody.insertRow();
    row.innerHTML = `
      <td>${menu.titre}</td>
      <td>${menu.description}</td>
      <td>${menu.prix}</td>
      <td>${menu.elements.map(element => plats[element].nom).join(', ')}</td>
      <td>
          <button type="button" onclick="editMenu(${index})">Modifier</button>
          <button type="button" onclick="deleteMenu(${index})">Supprimer</button>
      </td>
    `;
  });
}

function editMenu(index) {
  const menu = menus[index];
  document.querySelector(`input[name="menus[${menuCount - 1}][titre]"]`).value = menu.titre;
  document.querySelector(`textarea[name="menus[${menuCount - 1}][description]"]`).value = menu.description;
  document.querySelector(`input[name="menus[${menuCount - 1}][prix]"]`).value = menu.prix;
  const elementsSelect = document.querySelector(`select[name="menus[${menuCount - 1}][elements][]"]`);
  elementsSelect.innerHTML = plats.map((plat, index) => `<option value="${index}" ${menu.elements.includes(index.toString()) ? 'selected' : ''}>${plat.nom}</option>`).join('');

  menus.splice(index, 1);
  updateMenusTable();
}

function deleteMenu(index) {
  menus.splice(index, 1);
  updateMenusTable();
}

function addElementToMenu(menuIndex) {
  const elementsSelect = document.querySelector(`select[name="menus[${menuIndex}][elements][]"]`);
  elementsSelect.innerHTML = plats.map((plat, index) => `<option value="${index}">${plat.nom}</option>`).join('');
}

function updateMenuOptions() {
  const menuSelects = document.querySelectorAll('#menus select');
  const options = plats.map((plat, index) => `<option value="${index}">${plat.nom}</option>`).join('');
  menuSelects.forEach(select => {
      select.innerHTML = options;
  });
}

function prepareSubmission() {
  const form = document.querySelector('form');

  plats.forEach((plat, index) => {
    form.appendChild(createHiddenField(`carte[${index}][nom]`, plat.nom));
    form.appendChild(createHiddenField(`carte[${index}][type]`, plat.type));
    form.appendChild(createHiddenField(`carte[${index}][prix]`, plat.prix));
    form.appendChild(createHiddenField(`carte[${index}][devise]`, plat.devise));
    form.appendChild(createHiddenField(`carte[${index}][description]`, plat.description));
  });

  menus.forEach((menu, index) => {
    form.appendChild(createHiddenField(`menus[${index}][titre]`, menu.titre));
    form.appendChild(createHiddenField(`menus[${index}][description]`, menu.description));
    form.appendChild(createHiddenField(`menus[${index}][prix]`, menu.prix));
    menu.elements.forEach((element, elementIndex) => {
      form.appendChild(createHiddenField(`menus[${index}][elements][${elementIndex}]`, element));
    });
  });
}

function createHiddenField(name, value) {
  const input = document.createElement('input');
  input.type = 'hidden';
  input.name = name;
  input.value = value;
  return input;
}

document.querySelector('form').addEventListener('submit', prepareSubmission);