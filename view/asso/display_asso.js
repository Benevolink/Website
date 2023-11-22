function displayAsso(id_asso) {
    const asso = new Asso(id_asso);

    Promise.all([
        asso.getName(),
        asso.getLogo(),
        asso.getDesc()
    ]).then(([name, logo, description]) => {
        $('.nom_asso').text(name);
        $('#logo').attr('src', logo);
        $('.description').text(description);
    }).catch(error => {
        console.error('Error:', error);
    });
    
}