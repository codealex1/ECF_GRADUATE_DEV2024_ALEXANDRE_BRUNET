

const BtnSubmit = document.getElementById("btn-alimentation");
const FormAlimentation = document.getElementById("form-alimentation");
const BtnAvisValid = document.getElementById("btn-avis-validation");
const formAvisValid = document.getElementById("form-avis-validation");


BtnSubmit.addEventListener("click", AjouterConso);
BtnAvisValid.addEventListener("click", ValiderAvis);

function AjouterConso(){

    let dataForm = new FormData(FormAlimentation)

    
    const myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");

    const raw = JSON.stringify({
        "animal": dataForm.get("Id"),
        "nourriture": dataForm.get("nourriture"),
        "quantite": dataForm.get("quantite"),
        
        
    });
    const requestOptions = {
    method: "POST",
    body: raw,
    redirect: "follow"
    };

    fetch(apiUrl+"alimentation/new", requestOptions)
        .then((response) => {
            window.location.replace("/FrontEnd/accueil");
        })
        .then((result) => console.log(result))
        .catch((error) => console.error(error));
}

const containerAvis= document.querySelector(".avis-container");

const IdAvis = [1 ,2 ,3 , 4 ,5 ,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30]//ajouter dans le tableau les id des futurs avis

IdAvis.forEach((id, index) => {
    const url = `http://127.0.0.1:8000/api/commentaire/${id}`;
    fetch(url).then((response) => {
        return response.json();
    
    }).then((avis) =>{
        console.log(avis);
        for (const avi of [avis]){
            if(avi.IsVisible == null && avi.id != null){
                const containerComments = document.createElement("div");
                containerComments.className = "avis";
                containerComments.innerHTML = `
                    <div class="avis-content">
                        <p>${avi.id}</p>
                        <p class="avis-text">${avi.commentaire}</p>
                        <p class="avis-author">${avi.pseudo}</p>
                        <p>${avi.IsVisible}</p>
                    </div>
                    
                `; 
                
                containerAvis.appendChild(containerComments);
        }}
    });
})

function ValiderAvis(){

    let dataForm = new FormData(formAvisValid)

    const id = document.getElementById("IdInput").value;
    const myHeaders = new Headers();
    
    
    
    myHeaders.append("Content-Type", "application/json");

    const raw = JSON.stringify({
        
        
        "is_visible": dataForm.get("IsVisible"),
        
    });

    const requestOptions = {
    method: "PUT",
    headers: myHeaders,
    body: raw,
    redirect: "follow"
    };

    fetch(apiUrl+"commentaire/"+ id, requestOptions)
        .then((response) => {
            response.text();
            window.location.replace("/FrontEnd/accueil");
        })
        .then((result) => console.log(result))
        .catch((error) => console.error(error));
}