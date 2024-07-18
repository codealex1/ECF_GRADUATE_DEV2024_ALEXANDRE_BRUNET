//Implémenter le js de ma page


const inputNom = document.getElementById("NomInput");
const inputPreNom = document.getElementById("PrenomInput");
const inputMail = document.getElementById("EmailInput");
const inputPassword = document.getElementById("PasswordInput");
const inputRole = document.getElementById("RoleInput");
const btnValidation = document.getElementById("btn-validation-inscription")
const inputValidationPassword = document.getElementById("ValidatePasswordInput");
const formInscription = document.getElementById("formulaireInscription");

inputNom.addEventListener("keyup", validateForm); 
inputPreNom.addEventListener("keyup", validateForm);
inputMail.addEventListener("keyup", validateForm);
inputPassword.addEventListener("keyup", validateForm);
inputValidationPassword.addEventListener("keyup", validateForm);
btnValidation.addEventListener("click", InscrireUser);

function validateForm(){

    const nomOk = validateRequired(inputNom);
    const prenomOk = validateRequired(inputPreNom);
    const mailOk = validateMail(inputMail);
    const passwordOk = validatePassword(inputPassword);
    const passworConfirmdOk = validateConfirmationPassword(inputPassword,inputValidationPassword);

    if(nomOk && prenomOk && mailOk && passwordOk && passworConfirmdOk){
        btnValidation.disabled = false;

    }
    else{
        btnValidation.disabled = true;
    }
    
}
function validatePassword(input){
    //Définir mon regex
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/;
    const passwordUser = input.value;
    if(passwordUser.match(passwordRegex)){
        input.classList.add("is-valid");
        input.classList.remove("is-invalid"); 
        return true;
    }
    else{
        input.classList.remove("is-valid");
        input.classList.add("is-invalid");
        return false;
    }
}
function validateConfirmationPassword(inputPwd, inputConfirmPwd){
    if(inputPwd.value == inputConfirmPwd.value){
        inputConfirmPwd.classList.add("is-valid");
        inputConfirmPwd.classList.remove("is-invalid");
        return true;
    }
    else{
        inputConfirmPwd.classList.add("is-invalid");
        inputConfirmPwd.classList.remove("is-valid");
        return false;
    }
}

function validateMail(input){
    //Définir mon regex
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const mailUser = input.value;
    if(mailUser.match(emailRegex)){
        input.classList.add("is-valid");
        input.classList.remove("is-invalid"); 
        return true;
    }
    else{
        input.classList.remove("is-valid");
        input.classList.add("is-invalid");
        return false;
    }
}

function validateRequired(input){
    if(input.value !=''){
        input.classList.add("is-valid");
        input.classList.remove("is-invalid")
        return true;
    }
    else{
        input.classList.remove("is-valid");
        input.classList.add("is-invalid")
        return false;
    }
}

function InscrireUser(){


    
    let dataForm = new FormData(formInscription)

    

    
    const myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");

    const raw = JSON.stringify({
        "firstName": dataForm.get("Nom"),
        "lastName": dataForm.get("Prenom"),
        "email": dataForm.get("Email"),
        "password": dataForm.get("Password"),
        "roles":[dataForm.get("Role")]
        
    });
    
    const requestOptions = {
        method: "POST",
        headers: myHeaders,
        body: raw,
        redirect: "follow"
    };

    fetch("http://127.0.0.1:8000/api/registration", requestOptions)
    .then((response)=> {
        response.text();
        window.location.replace("/FrontEnd/accueil");
    })
    .then((result) => console.log(result))
    .catch((error) => console.error(error));
}

//Ajout suppression modification animal/habitat

const btnHabitat = document.getElementById("btn_habitat");
const btnModifieHabitat = document.getElementById("btn_habitat_modified"); 
const btnSuppHabitat = document.getElementById("btn_habitat_supp");
const formHabitat = document.getElementById("form-habitat");
const formHabitatModified = document.getElementById("form-habitat-modified");
const formHabitatSupp = document.getElementById("form-habitat-supp");

btnHabitat.addEventListener("click", NouveauHabitat);
btnModifieHabitat.addEventListener("click", ModifierHabitat);
btnSuppHabitat.addEventListener("click", SupprimerHabitat);

function SupprimerHabitat(){

    
    const id = document.getElementById("IdInputSuppHabitat").value;
    
    

    const requestOptions = {
    method: "DELETE",
    redirect: "follow"
    };

    fetch("http://127.0.0.1:8000/api/habitat/"+ id, requestOptions)
    .then((response) => {
        response.text();
        window.location.replace("/FrontEnd/accueil");
    })
    .then((result) => console.log(result))
    .catch((error) => console.error(error));
}






function NouveauHabitat(){

    let dataForm = new FormData(formHabitat)

    
    const myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");

    const raw = JSON.stringify({
        "nom": dataForm.get("Nom"),
        "description": dataForm.get("Description"),
        "commentaire_habitat": dataForm.get("Comments")
        
        
    });
    const requestOptions = {
    method: "POST",
    body: raw,
    redirect: "follow"
    };

    fetch(apiUrl+"habitat/new", requestOptions)
        .then((response) => {
            window.location.replace("/FrontEnd/accueil");
        })
        .then((result) => console.log(result))
        .catch((error) => console.error(error));
}




function ModifierHabitat(){

    let dataForm = new FormData(formHabitatModified)

    const id = document.getElementById("IdInputHabitat").value;
    const myHeaders = new Headers();
    
    myHeaders.append("Content-Type", "application/json");

    const raw = JSON.stringify({
        
        "nom": dataForm.get("Nom"),
        "description": dataForm.get("Description"),
        "commentaire_habitat": dataForm.get("Comments")
    });

    const requestOptions = {
    method: "PUT",
    headers: myHeaders, 
    body: raw,
    redirect: "follow"
    };

    fetch(apiUrl+"habitat/"+ id, requestOptions)
        .then((response) => {
            response.text();
            window.location.replace("/FrontEnd/accueil");
        })
        .then((result) => console.log(result))
        .catch((error) => console.error(error));
}

const btnAnimal = document.getElementById("btn_animal");
const btnModifieAnimal = document.getElementById("btn_animal_modified"); 
const btnSuppAnimal = document.getElementById("btn_animal_supp");
const formAnimal = document.getElementById("form-animal");
const formAnimalModified = document.getElementById("form-animal-modified");
const formAnimalSupp = document.getElementById("form-animal-supp");

btnAnimal.addEventListener("click", NouveauAnimal);
btnModifieAnimal.addEventListener("click", ModifierAnimal);
btnSuppAnimal.addEventListener("click", SupprimerAnimal);

function SupprimerAnimal(){

    
    const id = document.getElementById("IdInputSuppAnimal").value;
    
    

    const requestOptions = {
    method: "DELETE",
    redirect: "follow"
    };

    fetch("http://127.0.0.1:8000/api/animal/"+ id, requestOptions)
    .then((response) => {
        response.text();
        window.location.replace("/FrontEnd/accueil");
    })
    .then((result) => console.log(result))
    .catch((error) => console.error(error));
}






function NouveauAnimal(){

    let dataForm = new FormData(formAnimal)

    
    const myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");

    const raw = JSON.stringify({
        "habitat_id": dataForm.get("Habitat"),
        "prenom": dataForm.get("Nom"),
        "etat": dataForm.get("Etat"),
        "race": dataForm.get("Race")
        
        
    });
    const requestOptions = {
    method: "POST",
    body: raw,
    redirect: "follow"
    };

    fetch(apiUrl+"animal/new", requestOptions)
        .then((response) => {
            window.location.replace("/FrontEnd/accueil");
        })
        .then((result) => console.log(result))
        .catch((error) => console.error(error));
}




function ModifierAnimal(){

    let dataForm = new FormData(formAnimalModified)

    const id = document.getElementById("IdInputAnimal").value;
    const myHeaders = new Headers();
    
    myHeaders.append("Content-Type", "application/json");

    const raw = JSON.stringify({
        
        "prenom": dataForm.get("Nom"),
        "etat": dataForm.get("Etat"),
        "race": dataForm.get("Race")
    });

    const requestOptions = {
    method: "PUT",
    headers: myHeaders, 
    body: raw,
    redirect: "follow"
    };

    fetch(apiUrl+"animal/"+ id, requestOptions)
        .then((response) => {
            response.text();
            window.location.replace("/FrontEnd/accueil");
        })
        .then((result) => console.log(result))
        .catch((error) => console.error(error));
}




const containerRapport = document.querySelector(".container-rapport");
const container = document.querySelector(".container");

const IdRapport = [1, 2, 3, 4,5,6,7,8,9]; // ajouter dans le tableau les id des futurs rapport
let rapports = []; // store all reports in an array

IdRapport.forEach((id, index) => {
  const url = `http://127.0.0.1:8000/api/rapport/${id}`;
  fetch(url)
    .then((response) => response.json())
    .then((rapport) => {
      rapports.push(rapport); // ajouter le rapport dans le tableau
      displayRapport(rapport); // display les rapports
    });
});

// Fonction display rapport
function displayRapport(rapport) {
  const containerRapport = document.createElement("div");
  containerRapport.className = "container-rapport";
  containerRapport.innerHTML = `
    <div class="container-rapport-card">
      <h1 style="color:white; font-family: Cormorant Upright;">${rapport.animal_id}</h1>
      <h2 style="color:white;">${rapport.nom}</h2>
      <p class="card-text">
        ${rapport.detail}
      </p>
      <p class="card-text">
         ${new Intl.DateTimeFormat('fr-FR', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        }).format(new Date(rapport.date.date))}
      </p>
    </div> 
  `;
  container.appendChild(containerRapport);
}

// Add event listener 
const filterForm = document.querySelector(".filter-form");
filterForm.addEventListener("submit", (e) => {
  e.preventDefault();
  const dateFilter = document.getElementById("date-filter").value;
  const animalIdFilter = document.getElementById("animal-id-filter").value;
  filterReports(dateFilter, animalIdFilter);
});

// Filtrer les rapports 
function filterReports(dateFilter, animalIdFilter) {
  container.innerHTML = ""; 
  rapports.forEach((rapport) => {
    if (
      (dateFilter === "" || rapport.date.date === dateFilter) &&
      (animalIdFilter === "" || rapport.animal_id === parseInt(animalIdFilter))
    ) {
      displayRapport(rapport); 
    }
  });
}



const containerAnimaux = document.querySelector(".animal-grid");

const IdAnimal = [1 ,2 ,3 ,4, 5,6,7,8,9,10]//ajouter dans le tableau les id des futurs services 

IdAnimal.forEach((id, index) => {
    const url = `http://127.0.0.1:8000/api/animal/${id}`;
    fetch(url).then((response) => {
        return response.json();
    
    }).then((animaux) =>{
        console.log(animaux);
        for (const animal of [animaux]){
            if(animal.prenom != null){
                const containerAnimal = document.createElement("div");
                containerAnimal.className = "animal-card";
                containerAnimal.innerHTML = `
                    <div class="animal-info">
                        <h2>${animal.prenom}</h2>
                        <p>Nombre de vue : ${animal.click}</p>
                    </div>
                    
                `; 
                
                containerAnimaux.appendChild(containerAnimal);
            }
            
        }
    });
})