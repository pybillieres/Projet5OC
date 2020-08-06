
ajaxGet('https://api.themoviedb.org/3/search/movie?api_key=fd9a8abc18ee876e061e656506b72565&query=test', function(response){
    var films = JSON.parse(response);
    console.log(films);

})
/*https://api.themoviedb.org/3/search/company?api_key=<<api_key>>&page=1
https://api.themoviedb.org/3/movie/850?api_key=fd9a8abc18ee876e061e656506b72565&language=fr*/


