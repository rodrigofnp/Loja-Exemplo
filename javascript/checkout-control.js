function confirm(respXml) {

    if ("gn" in respXml && "erro" in respXml.gn) {
        alertOn("Ocorreu um erro na transação");
        return false;
    }

    if (respXml.status == 2) {
        window.location = "./sucesso";
    } else {
        window.location = "./erro-no-pagamento";
    }
}