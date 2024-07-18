const btnService = document.getElementById("btn_service");
const btnModifieService = document.getElementById("btn_service_modified");
const btnSupp = document.getElementById("btn_service_supp");
const formService = document.getElementById("form-service");
const formServiceModified = document.getElementById("form-service-modified");
const formServiceSupp = document.getElementById("form-service-supp");


btnService.addEventListener("click", NouveauService);
btnModifieService.addEventListener("click", ModifierService);
btnSupp.addEventListener("click", SupprimerService);






function SupprimerService(){

    
    const id = document.getElementById("IdInputSupp").value;
    
    

    const requestOptions = {
    method: "DELETE",
    redirect: "follow"
    };

    fetch("http://127.0.0.1:8000/api/service/"+ id, requestOptions)
    .then((response) => {
        response.text();
        window.location.replace("/FrontEnd/accueil");
    })
    .then((result) => console.log(result))
    .catch((error) => console.error(error));
}



function NouveauService(){

    let dataForm = new FormData(formService)

    
    const myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");

    const raw = JSON.stringify({
        "nom": dataForm.get("Titre"),
        "description": dataForm.get("description"),
        "heure_ouverture": dataForm.get("ouverture"),
        "heure_fermeture": dataForm.get("fermeture")
        
    });
    const requestOptions = {
    method: "POST",
    body: raw,
    redirect: "follow"
    };

    fetch(apiUrl+"service/new", requestOptions)
        .then((response) => {
            window.location.replace("/FrontEnd/accueil");
        })
        .then((result) => console.log(result))
        .catch((error) => console.error(error));
}



function ModifierService(){

    let dataForm = new FormData(formServiceModified)

    const id = document.getElementById("IdInput").value;
    const myHeaders = new Headers();
    
    myHeaders.append("Content-Type", "application/json");

    const raw = JSON.stringify({
        
        "nom": dataForm.get("Titre"),
        "description": dataForm.get("description"),
        "heure_ouverture": dataForm.get("ouverture"),
        "heure_fermeture": dataForm.get("fermeture")
    });

    const requestOptions = {
    method: "PUT",
    headers: myHeaders,
    body: raw,
    redirect: "follow"
    };

    fetch(apiUrl+"service/"+ id, requestOptions)
        .then((response) => {
            response.text();
            window.location.replace("/FrontEnd/accueil");
        })
        .then((result) => console.log(result))
        .catch((error) => console.error(error));
}





const containerServices = document.querySelector(".container-services");
const container = document.querySelector(".container");

const IdServcice = [1 ,2 ,3 ]//ajouter dans le tableau les id des futurs services 
const images = ['/images/iamges/6.png', '/images/iamges/7.png', '/images/iamges/5.png']; // tableau d'images correspondant aux ID des services

IdServcice.forEach((id, index) => {
    const url = `http://127.0.0.1:8000/api/service/${id}`;
    fetch(url).then((response) => {
        return response.json();
    
    }).then((services) =>{
        console.log(services);
        for (const service of [services]){
            const containerServices = document.createElement("div");
            containerServices.className = "container-services";
            containerServices.innerHTML = `
                <div class="container-services-card">
                    <h1 style="color: #FCCA18; font-family: Cormorant Upright;">${service.nom}</h1>
                    <div class="image-container">
                        <img src="${images[index]}" alt="table" class="img-services">
                    </div>
                    <p class="card-text">
                        ${service.description}
                    </p>
                </div>
                
            `; 
            
            container.appendChild(containerServices);
        }
    });
})



// fetch("http://127.0.0.1:8000/api/service/1").then((response) => {
//     return response.json();

// }).then((services) =>{
//     console.log(services);
//     for (const service of [services]){
//         const containerServices = document.createElement("div");
//         containerServices.className = "container-services";
//         containerServices.innerHTML = `
//             <div class="container-services-card">
//                 <h1 style="color: #FCCA18; font-family: Cormorant Upright;">${service.nom}</h1>
//                 <div class="image-container">
//                     <img src="/images/iamges/6.png" alt="table" class="img-services">
//                 </div>
//                 <p class="card-text">
//                     ${service.description}
//                 </p>
//             </div>
            
//         `;
        
//         container.appendChild(containerServices);
//     }
// });

// fetch("http://127.0.0.1:8000/api/service/3").then((response) => {
//     return response.json();

// }).then((services) =>{
//     console.log(services);
//     for (const service of [services]){
//         const containerServices = document.createElement("div");
//         containerServices.className = "container-services";
//         containerServices.innerHTML = `
//             <div class="container-services-card">
//                 <h1 style="color: #FCCA18; font-family: Cormorant Upright;">${service.nom}</h1>
//                 <div class="image-container">
//                     <img src="/images/iamges/5.png" alt="table" class="img-services">
//                 </div>
//                 <p class="card-text">
//                     ${service.description}
//                 </p>
//             </div>
            
//         `;
        
//         container.appendChild(containerServices);
//     }
// });