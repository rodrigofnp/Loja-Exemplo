function confirm(respXml) {
    if (respXml.status == 2) {
        window.location = "./sucesso";
    } else {
        window.location = "./erro-no-pagamento";
    }
}