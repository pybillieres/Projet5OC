
class Request
{

constructor()
{
    this.key = 'fd9a8abc18ee876e061e656506b72565';
    this.baseUrl = "http://image.tmdb.org/t/p/";
}

selectById()
{
    var movies = document.getElementsByClassName("movies");
    var idElements = [];
    for (const element of movies){
        idElements.push(element.id);
    }
    return idElements;
    
}


request(idElements, callBack)
{
    var films = [];
    for (const element of idElements)
    {
        ajaxGet('https://api.themoviedb.org/3/movie/'+element+'?api_key='+this.key+'&language=fr', function(response){
            films.push(JSON.parse(response));});  
    }
    callBack(films);
}

getPoster()
{
    var idElements = this.selectById();
    this.request(idElements, function(response){
        var films = [];
        films = response;
        console.log(films.length);
        films.forEach(function(film){
            var posterPath = this.baseUrl + "w92" + film.poster_path;
            console.log(film.title);
            console.log(posterPath);
            document.getElementById(film.id).src = posterPath;
        }.bind(this))
        }.bind(this));


}

getDetails()
{
    var idElements = this.selectById();
    this.request(idElements, function(response){
        var film = response[0];
        var posterPath = this.baseUrl + "w92" + film.poster_path; //revoir eventuelement dimensions demandées
        var releaseDate = film.release_date;
        var genres = film.genres;//voir si moyen de simplifier conversion array string pour les genres
        var genresString = "";
        for (var i = 0; i < genres.length; i++) {
            var genre = genres[i].name;
            if(i < genres.length - 1)
            {
                genresString = genresString + genre + ', ';    
            }
            else
            {
                genresString = genresString + genre;  
            }
          }
        document.getElementById("poster").src = posterPath;
        document.getElementById("releaseDate").textContent = releaseDate;
        document.getElementById("genres").textContent = genresString;
        }.bind(this));


}

}








/*https://api.themoviedb.org/3/search/company?api_key=<<api_key>>&page=1
https://api.themoviedb.org/3/movie/850?api_key=fd9a8abc18ee876e061e656506b72565&language=fr
'https://api.themoviedb.org/3/search/movie?api_key=fd9a8abc18ee876e061e656506b72565&query=test'*/
