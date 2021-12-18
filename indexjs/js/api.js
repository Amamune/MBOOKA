
const url = "https://www.omdbapi.com/?apikey=d4428604";

export function getMovieById(id, callback) {
    $.get(url + "&i=" + id, callback);
}

export function getMovieByIdFullPlot(id, callback) {
    $.get(url + "&i=" + id + "&plot=full", callback);
}

export function search(query, callback) {
    $.get(url + "&s=" + query, callback);
}