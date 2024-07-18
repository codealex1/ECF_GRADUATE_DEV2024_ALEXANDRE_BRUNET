import Route from "./Route.js";

//Définir ici vos routes
export const allRoutes = [
    new Route("/FrontEnd/accueil", "Accueil", "/FrontEnd/pages/home.html",[] , "/FrontEnd/js/home/home.js"),
    new Route("/FrontEnd/services", "services", "/FrontEnd/pages/services.html", [],"/FrontEnd/js/service/service.js"),
    new Route("/FrontEnd/sante", "sante", "/FrontEnd/pages/sante.html", ["ROLE_VETERINAIRE"],"/FrontEnd/js/veterinaire/sante.js"),
    new Route("/FrontEnd/habitats", "habitats", "/FrontEnd/pages/habitats.html", [] ,"/FrontEnd/js/habitat/habitat.js"),
    new Route("/FrontEnd/contact", "contact", "/FrontEnd/pages/contact.html", [],"/FrontEnd/js/contact/contact.js"),
    new Route("/FrontEnd/admin", "admin", "/FrontEnd/pages/Admin/admin.html",["ROLE_ADMIN"], "/FrontEnd/js/admin/admin.js"),
    new Route("/FrontEnd/employe", "employe", "/FrontEnd/pages/employe.html",["ROLE_EMPLOYE"],"/FrontEnd/js/employe/employe.js"),
    new Route("/FrontEnd/connexion", "connexion", "/FrontEnd/pages/connexion.html" ,[],"/FrontEnd/js/auth/signin.js"),];



//Le titre s'affiche comme ceci : Route.titre - websitename
export const websiteName = "Arcadia";