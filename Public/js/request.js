
class Request
{
constructor()
{

}

selectById()
{
    var movies = document.getElementsByClassName("movies");
    var idElements = [];
    for (const element of movies){
        idElements.push(element.id);
    }
    this.request(idElements);
    
}

request(idElements)
{
    console.log(idElements, 'toto');
    for (const element of idElements)
    {
        console.log(element);
        ajaxGet('https://api.themoviedb.org/3/configuration?api_key=fd9a8abc18ee876e061e656506b72565', function(response){
            var config = JSON.parse(response);
            console.log(config);}); 
        ajaxGet('https://api.themoviedb.org/3/movie/'+element+'?api_key=fd9a8abc18ee876e061e656506b72565&language=fr', function(response){
            var films = JSON.parse(response);
            console.log(films);});  
    }

}

}








/*https://api.themoviedb.org/3/search/company?api_key=<<api_key>>&page=1
https://api.themoviedb.org/3/movie/850?api_key=fd9a8abc18ee876e061e656506b72565&language=fr
'https://api.themoviedb.org/3/search/movie?api_key=fd9a8abc18ee876e061e656506b72565&query=test'*/
