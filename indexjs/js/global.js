$('.toast').toast({autohide:true, delay:2000});
$(".toast").hide();

$('.toast').on('hidden.bs.toast', function () {
    $(".toast").hide();
  })

$("#search-form").on("submit", function(event){
    
    event.preventDefault();

    var searchSerial = $('#search-form').serialize(); // search=dora%20the

    if($("#search-form input").val() == ""){
        $(".toast").show();
        $('.toast').toast('show');
    }
    else {
        location.href="search.html?" + searchSerial;
    }
    
});