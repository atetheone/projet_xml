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
  const nom = document.getElementById('platNom').value;
  const type = document.getElementById('platType').value;
  const prix = document.getElementById('platPrix').value;
  const devise = document.getElementById('platDevise').value;
  const description = document.getElementById('platDescription').value;

  const plat = { nom, type, prix, devise, description };

  if (editingPlatIndex >= 0) {
    plats[editingPlatIndex] = plat;
    editingPlatIndex = -1;
  } else {
    plats.push(plat);
  }

  console.log(plats);

  updatePlatsTable();

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
  const elements = Array.from(document.getElementById('menuElements').selectedOptions)
                       .map(option => option.value);


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
  document.getElementById('menuElements').innerHTML = plats.map((plat, index) => `<option value="${index}">${plat.nom}</option>`).join('');

  menuCount++;
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
          <button class="btn btn-2" type="button" onclick="editMenu(${index})"><i class="fas fa-edit"></i>Modifier</button>
          <button class="btn btn-2" type="button" onclick="deleteMenu(${index})"><i class="fas fa-trash-alt"></i>Supprimer</button>
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
  elementsSelect.innerHTML = plats.map((plat, platIndex) => `<option value="${platIndex}" ${menu.elements.includes(platIndex.toString()) ? 'selected' : ''}>${plat.nom}</option>`).join('');

  menus.splice(index, 1);
  updateMenusTable();
}

function deleteMenu(index) {
  menus.splice(index, 1);
  updateMenusTable();
}

function addElementToMenu() {
  const elementsSelect = document.getElementById('menuElements');;
  const selectedElements = Array.from(elementsSelect.selectedOptions).map(option => option.value);
  const menuElementsDiv = document.getElementById('menu-elements');
  menuElementsDiv.innerHTML = '';

  selectedElements.forEach((elementIndex) => {
    const elementDiv = document.createElement('div');
    elementDiv.className = 'menu-element';
    elementDiv.innerHTML = `
      <span>${plats[elementIndex].nom}</span>
      <button class="btn btn-2" type="button" onclick="editElementInMenu(${elementIndex})">Modifier</button>
      <button class="btn btn-2" type="button" onclick="removeElementFromMenu(${elementIndex})">Supprimer</button>
    `;
    menuElementsDiv.appendChild(elementDiv);
  });

  // Met à jour les éléments du menu en cours d'édition
  if (editingMenuIndex >= 0) {
    menus[editingMenuIndex].elements = selectedElements;
  }
}

function editElementInMenu(elementIndex) {
  const element = menus[menuIndex].elements[elementIndex];
  const elementsSelect = document.getElementById('menuElements');
  elementsSelect.value = element;
  removeElementFromMenu(elementIndex);
}


function removeElementFromMenu(elementIndex) {
  const elementsSelect = document.getElementById('menuElements');
  elementsSelect.options[elementIndex].selected = false;
  addElementToMenu();
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

document.querySelector('form').addEventListener('submit', function(event) {
  event.preventDefault();
  prepareSubmission();
  this.submit();
});

export {
  addDescriptionItem,
  removeDescriptionItem,
  updateDescriptionList,

  addPlat,
  updatePlatsTable,
  editPlat,
  deletePlat,

  addMenu,
  updateMenusTable,
  editMenu,
  deleteMenu,

  addElementToMenu,
  editElementInMenu,
  removeElementFromMenu,

  updateMenuOptions,
  prepareSubmission
}