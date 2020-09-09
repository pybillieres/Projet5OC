class Details
{
    constructor()
    {
        this.key = 'fd9a8abc18ee876e061e656506b72565';
        this.baseUrl = "http://image.tmdb.org/t/p/";
        this.getDetails();
    }


    selectById()
    {
        var movieId = document.getElementsByClassName("movie");
        return movieId[0].id;
    
    }

    request(id, callBack)
    {
        var film;
        ajaxGet('https://api.themoviedb.org/3/movie/'+id+'?api_key='+this.key+'&language=fr', function(response){
            film = JSON.parse(response);}.bind(this));  
            console.log(film);
        callBack(film);
    }

    getDetails()
    {
        var id = this.selectById();
        console.log(id);
        this.request(id, function(response){
            var film = response;
            console.log(film);
            var title = film.title;
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
            document.getElementById("title").textContent = title;
            document.getElementById("poster").src = posterPath;
            document.getElementById("releaseDate").textContent = releaseDate;
            document.getElementById("genres").textContent = genresString;
            }.bind(this));
    
    
    }
}