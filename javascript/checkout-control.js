function confirm(respXml) {
    if (JSON.parse(respXml).status == 2) {
        window.location = "./sucesso";
    } else {
        window.location = "./erro-no-pagamento";
    }
}