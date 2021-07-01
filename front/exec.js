$(".pets-grid").ready(function() {
    $.ajax({
        url : 'http://127.0.0.1:8000/api/pets', // La ressource ciblÃ©e
        type : 'GET', // Le type de la requÃªte HTTP.
        

        error: function(e) {
            console.log(e);
            alert("error");

        }
    }).done(function(response)  {
        console.log("response: " + response);
        for(let i = 0; i < response.length; i++)  {
            console.log(response[i]);
            $(".pets-grid").append("<li class='pet-item"+i+"'><a href='#'><img width='200' height='200' src='https://www.zoomalia.com/blogz/1743/border-collie.jpeg' alt='Product picture' /></a><p><strong>Name: "+response[i].name+"</strong><br><span class='desc'>Description: "+response[i].description+"</span></p></li>")
        }
    });
});

$(".product-grid").ready(function() {
    $.ajax({
        url : 'http://127.0.0.1:8000/api/products', // La ressource ciblÃ©e
        type : 'GET', // Le type de la requÃªte HTTP.
        

        error: function(e) {
            console.log(e);
            alert("error");

        }
    }).done(function(response)  {
        console.log("response: " + response);
        for(let i = 0; i < response.length; i++)  {
            console.log(response[i]);
            $(".product-grid").append("<li class='product-item'><a href='#'><img width='200' height='200' src='https://lallahoriye.com/wp-content/uploads/2019/04/Product_Lg_Type.jpg' alt='Product picture' /></a><p><strong>Name: "+response[i].name+"</strong><br><span class='desc'>Description: "+response[i].description+"</span><br><span class='desc'>Prix: "+response[i].prix+"</span></p></li>")
        }
    });
});