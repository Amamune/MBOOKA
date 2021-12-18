import { search, getMovieById, getMovieByIdFullPlot } from "./api.js";

var urlParams = new URLSearchParams(window.location.search);
var allSearchResults;
var allYears = new Set();
var allSelectedYears = [];

search(urlParams.get("search"), function (data) {

    if (data.Response == "False") {
        $("h1").parent().attr("class", "w-100 text-center");
        $("h1").text("No results matching \"" + urlParams.get("search") + "\" found");
        $(".sort-btn").hide();
        $(".filter-btn").hide();
    }

    else {
        $("#search").text("\"" + urlParams.get("search") + "\"");
        allSearchResults = data.Search;
        displaySearchResults(data.Search);

        var filteredYears = sortFilterYear(allYears);
        displayAllFilterOptions(filteredYears);
    }
});

function displaySearchResults(searchResults) {
    $("#search-results").empty();
    allYears.length = 0;

    $("#result-count").text(searchResults.length)

    for (let result of searchResults) {
        //jquery magic look up later. IT JUST WORKS
        var template = $($("#search-result-template").html());

        template.find(".movie-title").text(result.Title);
        template.find(".result-year").text(result.Year);
        template.find(".btn").attr("href", "movie.html?id=" + result.imdbID);

        if (result.Type == "series") {
            template.find(".result-info").append("(TV Series)");
        }

        if (result.Poster == "N/A" || result.Poster == "") {
            template.find(".search-poster").attr("src", "https://www.tu-chemnitz.de/physik/TPSM/bilder/noimageavailable.png");
        }
        else {
            template.find(".search-poster").attr("src", result.Poster);
        }

        var filterYears = result.Year.split("–")[0];
        allYears.add(filterYears);

        template.attr("data-year", filterYears);

        $("#search-results").append(template);
    }
};

function sortSearchResults(searchResults, sortType) {

    return searchResults.sort(function (result1, result2) {
        if (sortType == "title-a-z") {
            return result1.Title.localeCompare(result2.Title);
        }
        else if (sortType == "title-z-a") {
            return result2.Title.localeCompare(result1.Title);
        }
        else if (sortType == "year-asc") {
            return result1.Year.localeCompare(result2.Year);
        }
        else if (sortType == "year-des") {
            return result2.Year.localeCompare(result1.Year);
        }

        return result1 - result2;
    });
}

function sortFilterYear(years) {
    var yearsArray = Array.from(years);
    return yearsArray.sort(function (year1, year2) {
        return year2.localeCompare(year1);
    });
}

function displayAllFilterOptions(years){
    
    for(let year of years){
        var filterTemplate = $($("#filter-checkbox-template").html());

        filterTemplate.find(".form-check-label").text(year);

        filterTemplate.on("change" , function(event){
            var yearSelected = $(event.target).attr("data-year"); //"2019"

            if(event.target.checked == true){
                allSelectedYears.push(yearSelected); //["2019"]
            }
            else {
                allSelectedYears.splice(allSelectedYears.indexOf(yearSelected), 1);
            }

            filterSearchResults(allSelectedYears);

        });

        filterTemplate.find("input").attr("data-year", year);
        $("#filter-menu").append(filterTemplate);
    }

}

function filterSearchResults(selectedYears) {
        $("#search-results .row, #search-results hr").show();
        $("#search-results .row, #search-results hr").each(function() {
            if(selectedYears.length > 0 && !selectedYears.includes($(this).attr("data-year"))) {
                $(this).hide();
            }
        });
}

// Sorting buttons
$("#title-a-z").on("click", function (event) {
    var sortedResults = sortSearchResults(allSearchResults, "title-a-z")
    displaySearchResults(sortedResults);
    filterSearchResults(allSelectedYears);
});

$("#title-z-a").on("click", function (event) {
    var sortedResults = sortSearchResults(allSearchResults, "title-z-a")
    displaySearchResults(sortedResults);
    filterSearchResults(allSelectedYears);
});

$("#year-asc").on("click", function (event) {
    var sortedResults = sortSearchResults(allSearchResults, "year-asc")
    displaySearchResults(sortedResults);
    filterSearchResults(allSelectedYears);
});

$("#year-des").on("click", function (event) {
    var sortedResults = sortSearchResults(allSearchResults, "year-des")
    displaySearchResults(sortedResults);
    filterSearchResults(allSelectedYears);
});

