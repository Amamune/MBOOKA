import {getMovieById, getMovieByIdFullPlot} from "./api.js";

//Grab whats after the ? in the url
var urlParams = new URLSearchParams(window.location.search);

//get the id from the url then search api for that movie's data and populate corresponding web fields
getMovieById(urlParams.get("id"), function(data){
    $(".breadcrumb-item.active").text(data.Title);
    $("#title").text(data.Title);
    $("#title-year").text("(" + data.Year+ ")");
    $("#subtext").text(data.Rated + " | " + data.Runtime + " | " + data.Genre + " | " + data.Released + " | " + data.Country);
    
    $("#short-plot").text(data.Plot);
    $("#director").append(data.Director);
    $("#writers").append(data.Writer);
    $("#actors").append(data.Actors);
    $("#awards").text(data.Awards);
    $("#country").append(data.Country);
    $("#language").append(data.Language);
    $("#released").append(data.Released);
    $("#box-office").append(data.BoxOffice);
    $("#production").append(data.Production);

    if(data.Poster == "N/A" || data.Poster == ""){
        $("#poster").attr("src", "https://www.tu-chemnitz.de/physik/TPSM/bilder/noimageavailable.png");
    }
    else {
        $("#poster").attr("src", data.Poster);
    }

});

//get the full plot
getMovieByIdFullPlot(urlParams.get("id"), function(data){
    $("#long-plot").text(data.Plot);
});