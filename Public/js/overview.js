class Overview {
    constructor() {
        this.key = 'fd9a8abc18ee876e061e656506b72565';
        this.baseUrl = "http://image.tmdb.org/t/p/";
        this.index = document.getElementById("pageIndex").textContent;
        this.sortBy;
        this.date;
        this.Init();

    }

    Init() {
        var today = new Date();
        if (today.getDate() < 10) {
            this.date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-0' + today.getDate();
        }
        else {
            this.date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
        }

        if (document.getElementById("orderBy") !== null) {
            this.sortBy = (document.getElementById("orderBy").className);
        }


    }

    Index(nbrPages) { //permet d'afficher le nombre de page total dans l'index en bas de page
        if (nbrPages == 0) {
            document.getElementById("indexPages").style.display = "none";
        }
        if (nbrPages == 1) {
            document.getElementById("nxtPageIndex").style.display = "none";
        }
        if (nbrPages > 2) {
            document.getElementById("lastPageIndex").textContent = nbrPages;
        }
        if (nbrPages <= 3) {
            document.getElementById("indexDots").style.display = "none";
        }
        if (nbrPages > 3) {
            document.getElementById("indexDots").style.display = "inline";
        }
        if ((nbrPages - this.index) < 3) {
            document.getElementById("indexDots").style.display = "none";
        }
        if ((nbrPages - this.index) < 2) {
            document.getElementById("indexDots").style.display = "none";
            document.getElementById("lastPageIndex").textContent = "";
        }
        if (nbrPages == this.index) {
            document.getElementById("nxtPage").style.display = "none";
            document.getElementById("nxtPageIndex").style.display = "none";
            document.getElementById("lastPageIndex").textContent = "";

        }
    }


    ListRequest(sortBy, page, callBack) {
        var films;
        ajaxGet('https://api.themoviedb.org/3/discover/movie?api_key=' + this.key + '&language=fr&sort_by=' + sortBy + '&include_adult=false&include_video=false&page=' + page + '&release_date.lte=' + this.date, function (response) {
            films = JSON.parse(response);
        });
        callBack(films)
    }

    SearchRequest(title, page, callBack) {
        var films;
        ajaxGet('https://api.themoviedb.org/3/search/movie?api_key=' + this.key + '&language=fr&query=' + title + '&page=' + page + '&include_adult=false', function (response) {
            films = JSON.parse(response);
        });
        callBack(films)
    }

    MovieByIdRequest(idElements, callBack) {
        var films = [];
        console.log(idElements);
        for (const element of idElements.result) {
            ajaxGet('https://api.themoviedb.org/3/movie/' + element + '?api_key=' + this.key + '&language=fr', function (response) {
                films.push(JSON.parse(response));
            });
        }
        callBack(films);
    }

    createView()//comment nommer cette fonction ?
    {
        if (this.sortBy === "lastComment") {
            ajaxGet('api/lastReviewsApi/' + this.index, function (response) {
                response = JSON.parse(response);
                this.MovieByIdRequest(response, function (response) {
                    var films = response;
                    console.log(films.length);
                    console.log(response);
                    for (let i = 0; i < films.length; i++) {
                        this.View(i, films[i]);
                    }
                }.bind(this));
                this.Index(response.total_pages);
            }.bind(this));
        }

        else {

            this.ListRequest(this.sortBy, this.index, function (response) {
                console.log('toto');
                this.Index(response.total_pages);
                var films = response.results;
                console.log(response);
                for (let i = 0; i < 20; i++) {
                    this.View(i, films[i]);
                }
            }.bind(this));
        }
    }

    View(index, film) {
        var id = film.id;
        var title = film.title;
        if (film.poster_path != null) {
            var posterPath = this.baseUrl + "w185" + film.poster_path;
        }
        else {
            var posterPath = "public/posterDefaultW185.jpg";
        }
        document.getElementById("poster" + [index]).src = posterPath;
        document.getElementById("title" + [index]).textContent = title;
        document.getElementById("movie" + [index]).href = "Movie/MovieDetails/" + id;


    }

    searchFilm() {
        var title = document.getElementById("searchTitle").innerText;
        this.SearchRequest(title, this.index, function (response) {
            //console.log(response);
            this.Index(response.total_pages);
            if (response.total_results !== 0) {
                var films = response.results;
                var nbrPages = response.total_pages;
                for (let i = 0; i < 20; i++) {
                    this.View(i, films[i]);
                }
            }
            else {
                document.getElementById("pageTitle").textContent = 'Aucun résultat pour ' + title;
            }

        }.bind(this));
    }

}