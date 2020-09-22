class Overview
{
    constructor()
    {
        this.key = 'fd9a8abc18ee876e061e656506b72565';
        this.baseUrl = "http://image.tmdb.org/t/p/";
        this.index = document.getElementById("pageIndex").textContent;
        this.sortBy;
        this.Init();
        
    }

    Init()
    {
       if(document.getElementById("orderBy") !== null )
       {
           this.sortBy = (document.getElementById("orderBy").className);
       } 
    }


    ListRequest(sortBy, page, callBack)
    {
        var films;
        ajaxGet('https://api.themoviedb.org/3/discover/movie?api_key='+this.key+'&language=fr&sort_by='+sortBy+'&include_adult=false&include_video=false&page='+page+'&release_date.lte=2020-01-01', function(response){
            films = JSON.parse(response);});
        callBack(films)
    }

    SearchRequest(title, page, callBack)
    {
        var films;
        ajaxGet('https://api.themoviedb.org/3/search/movie?api_key='+this.key+'&language=fr&query='+title+'&page='+page+'&include_adult=false', function(response){
            films = JSON.parse(response);});
        callBack(films)
    }

    MovieByIdRequest(idElements, callBack)
    {
        var films = [];
        console.log(idElements);
        for (const element of idElements.result)
        {
            ajaxGet('https://api.themoviedb.org/3/movie/'+element+'?api_key='+this.key+'&language=fr', function(response){
                films.push(JSON.parse(response));});  
        }
        callBack(films);
    }

    createView()//comment nommer cette fonction ?
    {
        if(this.sortBy === "lastComment")
        {
            ajaxGet('api/lastReviewsApi/'+this.index, function(response){
                this.MovieByIdRequest(JSON.parse(response), function(response)
                {
                    console.log(response);
                    var films = response;
                    for (let i=0; i<20; i++)
                    {
                        this.View(i, films[i]);
                    }
                }.bind(this));}.bind(this));
            }
        
        else
        {
            console.log(this.sortBy);
            this.ListRequest(this.sortBy, this.index, function(response){
            var films = response.results;
            console.log(response);
            for (let i=0; i<20; i++)
            {
                this.View(i, films[i]);
            }
        }.bind(this));            
        }
    }

    View(index, film)
    {
        var id = film.id;
        var title = film.title;
        if(film.poster_path != null)
        {
            var posterPath = this.baseUrl + "w92" + film.poster_path; //revoir dimensions du poster
        }
        else
        {
            var posterPath = "public/posterDefault.jpg";
        }
        
        document.getElementById("poster" + [index]).src = posterPath;
        document.getElementById("title" + [index]).textContent = title;
        document.getElementById("movie" + [index]).href = "Movie/MovieDetails/" + id;

    }

    searchFilm()
    {
        console.log('ici');
        var title = document.getElementById("searchTitle").innerText;
        console.log(title);
        this.SearchRequest(title, this.index, function(response){
            var films = response.results;
            console.log(films);
            var nbrPages = response.total_pages;
            for (let i=0; i<20; i++)
            {
                this.View(i, films[i]);
            }
        }.bind(this));
    }

    filmByLastReview()
    {

    }
}