const btnAvis = document.getElementById("btn-avis");
const formAvis = document.getElementById("form-avis");

btnAvis.addEventListener("click", NouveauCommentaire);

function NouveauCommentaire(){

    let dataForm = new FormData(formAvis)

    
    const myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");

    const raw = JSON.stringify({
        "pseudo": dataForm.get("pseudo"),
        "commentaire": dataForm.get("commentaire"),
        
        
    });
    const requestOptions = {
    method: "POST",
    body: raw,
    redirect: "follow"
    };

    fetch(apiUrl+"commentaire/create", requestOptions)
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
            if(avi.IsVisible == true && avi.id != null){
                const containerComments = document.createElement("div");
                containerComments.className = "avis";
                containerComments.innerHTML = `
                    <div class="avis-content">
                        <p class="avis-text">${avi.commentaire}</p>
                        <p class="avis-author">${avi.pseudo}</p>
                    </div>
                    
                `; 
                
                containerAvis.appendChild(containerComments);
        }}
    });
})