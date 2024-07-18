


function ClickIncrement(animalId){
    const myHeaders = new Headers();
    myHeaders.append("Cookie", "PHPSESSID=2c6eerf6tet5fm1k276h0qq2na");

    const requestOptions = {
    method: "POST",
    headers: myHeaders,
    redirect: "follow"
    };

    fetch(`http://127.0.0.1:8000/api/animal/${animalId}/click`, requestOptions)
    .then((response) => response.text())
    .then((result) => console.log(result))
    .catch((error) => console.error(error));
}