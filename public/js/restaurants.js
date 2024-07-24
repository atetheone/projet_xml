document.addEventListener('DOMContentLoaded', function() {
  if (typeof descriptionCount === 'undefined') {
    descriptionCount = 0;
  }
  if (typeof platCount === 'undefined') {
    platCount = 0;
  }
  if (typeof menuCount === 'undefined') {
    menuCount = 0;
  }
  if (typeof plats === 'undefined') {
    plats = [];
  }
  if (typeof menus === 'undefined') {
    menus = [];
  }

  updatePlatsTable();
  updateMenusTable();
});



function addDescriptionItem() {
  const descriptionDiv = document.getElementById('description');
  const newItem = document.createElement('div');
  newItem.className = 'description-item';
  newItem.innerHTML = `
    <select name="description[${descriptionCount}][type]" required>
      <option value="texte">Texte</option>
      <option value="image">Image</option>
      <option value="liste">Liste</option>
      <option value="important">Important</option>
    </select>
    <textarea name="description[${descriptionCount}][content]" placeholder="Contenu" required></textarea>
    <button class="btn btn-2" type="button" onclick="removeDescriptionItem(this)">Supprimer</button>
  `;
  descriptionDiv.appendChild(newItem);
  descriptionCount++;
  updateDescriptionList();
}

function removeDescriptionItem(button) {
  const descriptionItem = button.parentElement;
  descriptionItem.remove();
  updateDescriptionList();
}

function updateDescriptionList() {
  const descriptionItems = document.querySelectorAll('.description-item');
  const descriptionList = document.getElementById('descriptionList');
  descriptionList.innerHTML = '';

  descriptionItems.forEach((item, index) => {
    const type = item.querySelector('select').value;
    const content = item.querySelector('textarea').value;
    const descriptionEntry = document.createElement('div');
    descriptionEntry.innerHTML = `<strong>${type}:</strong> ${content}`;
    descriptionList.appendChild(descriptionEntry);
  });
}

function addPlat() {
  const id = document.getElementById('platId').value || uniqueId('p');
  const nom = document.getElementById('platNom').value;
  const type = document.getElementById('platType').value;
  const prix = document.getElementById('platPrix').value;
  const devise = document.getElementById('platDevise').value;
  const description = document.getElementById('platDescription').value;

  const plat = { id, nom, type, prix, devise, description };

  if (editingPlatIndex >= 0) {
    plats[editingPlatIndex] = plat;
    editingPlatIndex = -1;
  } else {
    plats.push(plat);
  }

  console.log(plats);

  updatePlatsTable();

  document.getElementById('platId').value = '';
  document.getElementById('platNom').value = '';
  document.getElementById('platType').value = '';
  document.getElementById('platPrix').value = '';
  document.getElementById('platDevise').value = '';
  document.getElementById('platDescription').value = '';

  platCount++;
  updateMenuOptions();
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
          <button class="btn btn-2" type="button" onclick="editPlat(${index})" class="btn edit"><i class="fas fa-edit"></i>Modifier</button>
          <button class="btn btn-2" type="button" onclick="deletePlat(${index})" class="btn delete"><i class="fas fa-trash-alt"></i>Supprimer</button>
        </td>
      `;
    });
}

function editPlat(index) {
  const plat = plats[index];

  document.getElementById('platId').value = plat.id;
  document.getElementById('platNom').value = plat.nom;
  document.getElementById('platType').value = plat.type;
  document.getElementById('platPrix').value = plat.prix;
  document.getElementById('platDevise').value = plat.devise;
  document.getElementById('platDescription').value = plat.description;

  plats.splice(index, 1);
  editingPlatIndex = index;
  updatePlatsTable();
}


function deletePlat(index) {
  plats.splice(index, 1);
  updatePlatsTable();
  updateMenuOptions();
}

function addMenu() {
  const titre = document.getElementById('menuTitre').value;
  const description = document.getElementById('menuDescription').value;
  const prix = document.getElementById('menuPrix').value;
  const devise = document.getElementById('menuDevise').value;
  const selectElements = Array.from(document.getElementById('menuElements').selectedOptions);

  let elements = [];

  selectElements.forEach(element => { 
    console.log(element.value);
    elements.push(element.value);
  });


  const menu = { titre, description, prix, devise, elements };

  console.log(JSON.stringify(menu, null, 2));

  if (editingMenuIndex >= 0) {
    menus[editingMenuIndex] = menu;
    editingMenuIndex = -1;
  } else {
    menus.push(menu);
  }
  updateMenusTable();

  // Vider les champs de saisie
  document.getElementById('menuTitre').value = '';
  document.getElementById('menuDescription').value = '';
  document.getElementById('menuPrix').value = '';
  document.getElementById('menuDevise').value = ''
  document.getElementById('menuElements').selectedIndex = -1;

  menuCount++;
  updateMenuOptions();
}


function updateMenusTable() {
  const menusTableBody = document.getElementById('menusTable').querySelector('tbody');
  menusTableBody.innerHTML = '';
  menus.forEach((menu, index) => {
    console.log(menu.elements);
    const row = menusTableBody.insertRow();
    row.innerHTML = `
      <td>${menu.titre}</td>
      <td>${menu.description}</td>
      <td>${menu.prix}</td>
      <td>${menu.elements.map(elementId => plats.find(plat => plat.id === elementId)?.nom || '').join(', ')}</td>      <td>
        <button class="btn btn-2" type="button" onclick="editMenu(${index})">Modifier</button>
        <button class="btn btn-2" type="button" onclick="deleteMenu(${index})">Supprimer</button>
      </td>
    `;
  });
}

function editMenu(index) {
  const menu = menus[index];
  document.getElementById('menuTitre').value = menu.titre;
  document.getElementById('menuDescription').value = menu.description;
  document.getElementById('menuPrix').value = menu.prix;
  document.getElementById('menuDevise').value = menu.devise;

  const elementsSelect = document.getElementById('menuElements');
  Array.from(elementsSelect.options).forEach(option => {
    option.selected = menu.elements.includes(option.value);
  });

  menus.splice(index, 1);
  updateMenusTable();
}

function deleteMenu(index) {
  menus.splice(index, 1);
  updateMenusTable();
}



function updateMenuOptions() {
  const menuSelects = document.querySelectorAll('#menuElements');
  const options = plats.map((plat) => `<option value="${plat.id}">${plat.nom}</option>`).join('');
  menuSelects.forEach(select => {
    select.innerHTML = options;
  });
}

function prepareSubmission() {
  const form = document.querySelector('form');

  form.querySelectorAll('input[type="hidden"]').forEach(input => input.remove());


  plats.forEach((plat, index) => {
    form.appendChild(createHiddenField(`carte[${index}][id]`, plat.id));
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
    form.appendChild(createHiddenField(`menus[${index}][devise]`, menu.devise));
    console.log(menu.elements);
    menu.elements.forEach((elementId, elementIndex) => {
      form.appendChild(createHiddenField(`menus[${index}][elements][${elementIndex}]`, elementId));
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

function uniqueId(prefix = "", random = false) {
  const sec = Date.now() * 1000 + Math.random() * 1000;
  const id = sec.toString(16).replace(/\./g, "").padEnd(14, "0");
  return `${prefix}${id}${random ? `.${Math.trunc(Math.random() * 100000000)}`:""}`;
};

document.querySelector('form').addEventListener('submit', function(event) {
  event.preventDefault();
  prepareSubmission();
  this.submit();
});
