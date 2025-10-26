$(document).ready(function() {
    $.getJSON('data/menu.json', function(data) {
        let menuHTML = '';
        data.dishes.forEach(function(dish) {
            menuHTML += `
                <div class="menu-item fade-in">
                    <img src="${dish.image}" alt="${dish.name}">
                    <div class="menu-info">
                        <h3>${dish.name}</h3>
                        <p><strong>Cuisine:</strong> ${dish.cuisine}</p>
                        <p><strong>Category:</strong> ${dish.category}</p>
                        <p>${dish.description}</p>
                        <p><strong>Ingredients:</strong> ${dish.ingredients.join(', ')}</p>
                        <p class="price">${dish.price}</p>
                    </div>
                </div>
            `;
        });
        $('#menu').html(menuHTML);
    });
});
