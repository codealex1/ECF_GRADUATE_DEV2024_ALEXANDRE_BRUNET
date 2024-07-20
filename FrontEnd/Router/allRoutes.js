import Route from "./Route.js";

//Définir ici vos routes
export const allRoutes = [
    new Route("/FrontEnd/accueil", "Accueil", "./pages/pages/home.html",[] , "./js/home/home.js"),
    new Route("/FrontEnd/services", "services", "./pages/pages/services.html", [],"./js/service/service.js"),
    new Route("/FrontEnd/sante", "sante", "./pages/pages/sante.html", ["ROLE_VETERINAIRE"],"./js/veterinaire/sante.js"),
    new Route("/FrontEnd/habitats", "habitats", "./pages/pages/habitats.html", [] ,"./js/habitat/habitat.js"),
    new Route("/FrontEnd/contact", "contact", "./pages/pages/contact.html", [],"./js/contact/contact.js"),
    new Route("/FrontEnd/admin", "admin", "./pages/Admin/admin.html",["ROLE_ADMIN"], "./js/admin/admin.js"),
    new Route("/FrontEnd/employe", "employe", "./pages/pages/employe.html",["ROLE_EMPLOYE"],"./js/employe/employe.js"),
    new Route("/FrontEnd/connexion", "connexion", "./pages/pages/connexion.html" ,[],"./js/auth/signin.js"),];



//Le titre s'affiche comme ceci : Route.titre - websitename
export const websiteName = "Arcadia";