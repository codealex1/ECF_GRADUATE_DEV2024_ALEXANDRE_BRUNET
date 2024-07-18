const btnSante = document.getElementById("btn-rapport-sante");
const formSante = document.getElementById("form-sante");
const btnModifieHabitat = document.getElementById("btn_habitat_modified");
const formHabitatModified = document.getElementById("form-habitat-modified");


btnModifieHabitat.addEventListener("click", ModifierHabitat);
btnSante.addEventListener("click", NouveauRapport);

function NouveauRapport(){

    let dataForm = new FormData(formSante)

    
    const myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");

    const raw = JSON.stringify({
        "animal_id":dataForm.get("Id"),
        "detail": dataForm.get("Detail"),
        "nom":dataForm.get("Nom")
        
        
    });
    const requestOptions = {
    method: "POST",
    body: raw,
    redirect: "follow"
    };

    fetch(apiUrl+"rapport/new", requestOptions)
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
        "commentaire_habitat": dataForm.get("Comments"),
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


const containerAlimentation= document.querySelector(".ali-grid");

const IdAli = [1 ,2 ,3 , 4 ,5 ]//ajouter dans le tableau les id des futurs services 

IdAli.forEach((id, index) => {
    const url = `http://127.0.0.1:8000/api/alimentation/${id}`;
    fetch(url).then((response) => {
        return response.json();
    
    }).then((alimention) =>{
        console.log(alimention);
        for (const conso of [alimention]){
            const date = new Date(conso.date.date);
            const formattedDate = `${date.getDate()}/${(date.getMonth() + 1)}/${date.getFullYear()}`;
            const containerConso = document.createElement("div");
            containerConso.className = "ali-card";
            containerConso.innerHTML = `
                <div class="ali-info">
                    <h2>${conso.animal_id}</h2>
                    <p>Nouriture : ${conso.nourriture}</p>
                    <p>Quantité: ${conso.quantite}</p>
                    <p>Date: ${formattedDate}</p>
                </div>
                
            `; 
            
            containerAlimentation.appendChild(containerConso);
        }
    });
})

