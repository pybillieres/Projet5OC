class Overview
{
    constructor()
    {
        this.key = 'fd9a8abc18ee876e061e656506b72565';
        this.baseUrl = "http://image.tmdb.org/t/p/";
        this.index = 1;
        this.sortBy = "release_date.desc"; 
        this.Init();
    }

    Init()
    {
        document.getElementById("prvPage").addEventListener("click", function(){this.PreviousPage()}.bind(this));
        document.getElementById("nxtPage").addEventListener("click", function(){this.NextPage()}.bind(this));
        document.getElementById("OrderByDate").addEventListener("click", function(){this.OrderByDate()}.bind(this));
        document.getElementById("OrderByLastReview").addEventListener("click", function(){this.OrderByLastReview()}.bind(this));
        document.getElementById("OrderByPopularity").addEventListener("click", function(){this.OrderByPopularity()}.bind(this));
        this.createView();
    }


    ListRequest(sortBy, page, callBack)
    {
        var films;
        ajaxGet('https://api.themoviedb.org/3/discover/movie?api_key='+this.key+'&language=fr&sort_by='+sortBy+'&include_adult=false&include_video=false&page='+page+'&release_date.lte=2020-01-01', function(response){
            films = JSON.parse(response);});
        callBack(films)
    }

    createView()//comment nommer cette fonction ?
    {
        this.ListRequest(this.sortBy, this.index, function(response){
            var films = response.results;
            var nbrPages = response.total_pages;
            for (let i=0; i<20; i++)
            {
                this.View(i, films[i]);
            }
        }.bind(this));
    }

    NextPage()
    {
        this.index ++;
        this.createView()
        document.getElementById("pageIndex").textContent = this.index;
    }

    PreviousPage()
    {
        this.index --;
        this.createView()
        document.getElementById("pageIndex").textContent = this.index;
    }

    View(index, film)
    {
        var id = film.id;
        var title = film.title;
        var posterPath = this.baseUrl + "w92" + film.poster_path; //revoir dimensions du poster
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
}