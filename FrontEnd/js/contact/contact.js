
const btnSubmit = document.getElementById("btn-contact-submit");
const formContact = document.getElementById("form-contact");

btnSubmit.addEventListener("click", EnvoyerMail);


function EnvoyerMail(){
    let dataForm = new FormData(formContact)

    const myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");
    myHeaders.append("Cookie", "PHPSESSID=2c6eerf6tet5fm1k276h0qq2na");

    const raw = JSON.stringify({
        "titre": dataForm.get("titre"),
        "email": dataForm.get("email"),
        "message": dataForm.get("message"),
    });

    const requestOptions = {
    method: "POST",
    headers: myHeaders,
    body: raw,
    redirect: "follow"
    };

    fetch("http://127.0.0.1:8000/api/profile/contact", requestOptions)
    .then((response) => response.text())
    .then((result) => console.log(result))
    .catch((error) => console.error(error));
}
