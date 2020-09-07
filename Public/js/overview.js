class Overview
{
    constructor()
    {
        this.key = 'fd9a8abc18ee876e061e656506b72565';
        this.baseUrl = "http://image.tmdb.org/t/p/";
        this.index = document.getElementById("pageIndex").textContent;
        this.sortBy = "release_date.desc"; 
        //this.Init();
    }

    /*Init()
    {
        this.createView();
    }*/


    ListRequest(sortBy, page, callBack)
    {
        var films;
        ajaxGet('https://api.themoviedb.org/3/discover/movie?api_key='+this.key+'&language=fr&sort_by='+sortBy+'&include_adult=false&include_video=false&page='+page+'&release_date.lte=2020-01-01', function(response){
            films = JSON.parse(response);});
        callBack(films)
    }

    SearchRequest(title, callBack)
    {
        var films;
        ajaxGet('https://api.themoviedb.org/3/search/movie?api_key='+this.key+'&language=fr&query='+title+'&page=1&include_adult=false', function(response){
            films = JSON.parse(response);});
        callBack(films)
    }

    createView()//comment nommer cette fonction ?
    {
        console.log('test1');
        this.ListRequest(this.sortBy, this.index, function(response){
            var films = response.results;
            console.log(response);
            for (let i=0; i<20; i++)
            {
                this.View(i, films[i]);
            }
        }.bind(this));
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
        
        document.getElementById("poster" + [index]).src = posterPath; //penser a gerer le cas ou le posterPath n'est pas fourni (=>remplacer par image grise)
        document.getElementById("title" + [index]).textContent = title;
        document.getElementById("movie" + [index]).href = "Movie/MovieDetails/" + id;

    }

    OrderByDate()
    {
        this.index = 1;
        this.sortBy = "release_date.desc";
        this.createView();
    }

    OrderByLastReview() 
    {
        //requete ajax vers php pour demander quel sont les dernieres review
    }

    OrderByPopularity()
    {
        this.index = 1;
        this.sortBy = "popularity.desc"
        this.createView();
    }

    searchFilm()
    {
        console.log(document.getElementById("searchTitle").textContent);
        var title = document.getElementById("searchTitle").innerText;
        console.log(title);
        this.SearchRequest(title, function(response){
            var films = response.results;
            var nbrPages = response.total_pages;
            for (let i=0; i<20; i++)
            {
                this.View(i, films[i]);
            }
        }.bind(this));
    }
}