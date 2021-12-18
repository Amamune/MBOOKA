
import {getMovieById} from "./api.js";

//list of movie ids to populate portfolio cards
var movies = ["tt0120338", "tt1291150", "tt0172495", "tt0128853", "tt7547410", "tt3896198"];

for(var i = 0; i < 6; i++){
    getMovieById(movies[i], function(data){
        var index = movies.indexOf(data.imdbID); 
        var portfolio = $(".portfolio-item").eq(index);
        
        portfolio.find(".card-img-top").attr("src", data.Poster);
        portfolio.find(".card-title a").text(data.Title);
        portfolio.find(".card-text").text(data.Plot);
        portfolio.find("a").attr("href", "movie.html?id=" + data.imdbID);
    });
}

