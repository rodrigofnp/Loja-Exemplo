var addressFields = ["cep", "log", "num", "bai", "com", "cid", "uf"];

function sameAddressChange() {
    var useSameAddress = document.getElementById('checkout-same-address').checked;
    controlAddressFields(useSameAddress);
    var bilAddrEl = document.getElementById("checkout-billing-address");
    bilAddrEl.style.display = useSameAddress ? "none" : "block";
}

function controlAddressFields(sameAddress) {
    for (var i = 0; i < addressFields.length; i++) {
        var entVal = "";
        if (sameAddress) {
            entVal = document.getElementById("ent-" + addressFields[i]).value;
        }
        document.getElementById("cob-" + addressFields[i]).value = entVal;
    }
}

function correiocontrolcep(resp) {
    if ("erro" in resp) {
        resp = {
            localidade: "",
            logradouro: "",
            bairro: "",
            uf: ""
        }
    }
    document.getElementById(fieldCep + "cid").value = resp.localidade.trim();
    document.getElementById(fieldCep + "log").value = resp.logradouro.trim();
    document.getElementById(fieldCep + "bai").value = resp.bairro.trim();
    document.getElementById(fieldCep + "uf").value = resp.uf;
}

function searchCEP(cep, callback) {
    var jsonp = document.createElement("script");
    jsonp.src = "http://cep.correiocontrol.com.br/" + cep + ".js";
    document.getElementsByTagName("head")[0].appendChild(jsonp);
}


window.onload = function() {

    function handleBlurCep(value) {
        var cep = value || '';
        searchCEP(cep.replace(/[^\d]+/, ''));
    }
    document.getElementById("cob-cep").addEventListener("blur", function() {
        fieldCep = "cob-";
        handleBlurCep(this.value);
    });
    document.getElementById("ent-cep").addEventListener("blur", function() {
        fieldCep = "ent-";
        handleBlurCep(this.value);
    });
    if (document.getElementById("ent-cep").value) {
        fieldCep = "ent-";
        handleBlurCep(document.getElementById("ent-cep").value);
    }

    sameAddressChange();
    setTimeout(sameAddressChange, 5000);
    for (var i = 0; i < addressFields.length; i++) {
        document.getElementById("ent-" + addressFields[i]).onblur = sameAddressChange;
    }
}

function verifyEmail(field) {
    if (!document.getElementById("cliente-email").value.match(/^[a-zA-Z0-9\._-]+@[a-zA-Z0-9\._-]+.([a-zA-Z]{2,4})+$/)) {
        alertOn("O e-mail digitado é inválido!");
        return false;
    }
}

function validateForm() {

    var formValidateErrors = "";
    if (document.getElementById("total").value == null || document.getElementById("total").value == "" || parseInt(document.getElementById('total').value) < 500) {
        alert('O valor mínimo de compra é R$5,00');
        return false;
    }
    if (document.getElementById("cliente-nome").value.trim() == null || document.getElementById("cliente-nome").value.trim() == "") {
        formValidateErrors += "Preencha o nome do cliente.<br/>";
    }
    if (document.getElementById("cliente-email").value.trim() == null || document.getElementById("cliente-nome").value.trim() == "") {
        formValidateErrors += "Preencha o e-mail do cliente.<br/>";
    }
    if (document.getElementById("cpf").value.trim() == null || document.getElementById("cpf").value.trim() == "") {
        formValidateErrors += "Preencha o CPF do cliente.<br/>";
    }
    if (document.getElementById("celular").value.trim() == null || document.getElementById("celular").value.trim() == "") {
        formValidateErrors += "Preencha o celular do cliente.<br/>";
    }
    if (document.getElementById("date").value.trim() == null || document.getElementById("date").value.trim() == "") {
        formValidateErrors += "Preencha a data de nascimento do cliente.<br/>";
    }

    if (document.getElementById("ent-cep").value.trim() == null || document.getElementById("ent-cep").value.trim() == "") {
        formValidateErrors += "Preencha o CEP de entrega do cliente.<br/>";
    }
    if (document.getElementById("ent-log").value.trim() == null || document.getElementById("ent-log").value.trim() == "") {
        formValidateErrors += "Preencha o endereço de entrega do cliente.<br/>";
    }
    if (document.getElementById("ent-num").value.trim() == null || document.getElementById("ent-num").value.trim() == "") {
        formValidateErrors += "Preencha o número do endereço de entrega do cliente.<br/>";
    }
    if (document.getElementById("ent-bai").value.trim() == null || document.getElementById("ent-bai").value.trim() == "") {
        formValidateErrors += "Preencha o bairro de entrega do cliente.<br/>";
    }
    if (document.getElementById("ent-cid").value.trim() == null || document.getElementById("ent-cid").value.trim() == "") {
        formValidateErrors += "Preencha a cidade de entrega do cliente.<br/>";
    }
    if (document.getElementById("ent-uf").value.trim() == null || document.getElementById("ent-uf").value.trim() == "") {
        formValidateErrors += "Preencha o estado de entrega do cliente.<br/>";
    }

    var payTypeIsCard = document.forms[0].elements["gn-forma-pagamento"] && document.forms[0].elements["gn-forma-pagamento"][0].checked;

    if (payTypeIsCard && !document.getElementById('checkout-same-address').checked) {
        if (document.getElementById("cob-cep").value.trim() == null || document.getElementById("cob-cep").value.trim() == "") {
            formValidateErrors += "Preencha o CEP de cobrança do cliente.<br/>";
        }
        if (document.getElementById("cob-log").value.trim() == null || document.getElementById("cob-log").value.trim() == "") {
            formValidateErrors += "Preencha o endereço de cobrança do cliente.<br/>";
        }
        if (document.getElementById("cob-num").value.trim() == null || document.getElementById("cob-num").value.trim() == "") {
            formValidateErrors += "Preencha o número do endereço de cobrança do cliente.<br/>";
        }
        if (document.getElementById("cob-bai").value.trim() == null || document.getElementById("cob-bai").value.trim() == "") {
            formValidateErrors += "Preencha o bairro de cobrança do cliente.<br/>";
        }
        if (document.getElementById("cob-cid").value.trim() == null || document.getElementById("cob-cid").value.trim() == "") {
            formValidateErrors += "Preencha a cidade de cobrança do cliente.<br/>";
        }
        if (document.getElementById("cob-uf").value.trim() == null || document.getElementById("cob-uf").value.trim() == "") {
            formValidateErrors += "Preencha o estado de cobrança do cliente.<br/>";
        }
    }

    if (formValidateErrors != "") {
        alertOn(formValidateErrors);
        return false;

    } else {
        var selecionado = "";
        var radiosFormaPagamento = document.getElementsByName('gn-forma-pagamento');
        for (var i = 0, length = radiosFormaPagamento.length; i < length; i++) {
            if (radiosFormaPagamento[i].checked) {
                selecionado = radiosFormaPagamento[i].value;
                break;
            }
        }
        if (selecionado == "cartao-credito") {
            var bandeiras = document.getElementsByName("gn-cartao-bandeiras");
            var cardSelected = -1;
            for (var i = 0; i < bandeiras.length; i++) {
                if (bandeiras[i].checked) {
                    cardSelected = i;
                }
            }
            if (cardSelected == -1) {
                alertOn("Selecione uma bandeira de cartão para realizar o pagamento.");
                return false;
            }
            if (!document.getElementById("numero-cartao").value.match(/^[0-9]+$/)) {
                alertOn("O número do cartão de crédito informado é inválido.\nOBS.: O número não deve conter espaços.");
                return false;
            }
            if (!document.getElementById("mes-venc-cartao").value.match(/^(1|2|3|4|5|6|7|8|9|01|02|03|04|05|06|07|08|09|10|11|12)$/)) {
                alertOn("O mês de vencimento do cartão de crédito informado é inválido.");
                return false;
            }
            if (!document.getElementById("ano-venc-cartao").value.match(/^([0-9]{4,4})$/)) {
                alertOn("O ano de vencimento do cartão de crédito informado é inválido.");
                return false;
            }
            if (!document.getElementById("ano-venc-cartao").value.match(/^([0-9]{4,4})$/)) {
                alertOn("O ano de vencimento do cartão de crédito informado é inválido.");
                return false;
            }
            if (!document.getElementsByClassName('gn-cartao-parcelas')[0].value) {
                alertOn("Selecione a quantidade de parcelas.");
                return false;
            }
        }


        if (!document.getElementById("cliente-nome").value.match(/^[ ]*(.+[ ]+)+.+[ ]*$/) ||
            document.getElementById("cliente-nome").value.length <= 1 ||
            document.getElementById("cliente-nome").value.length > 255) {
            alertOn("O nome do cliente é inválido");
            return false;
        }
        if (!verifyCPF(document.getElementById("cpf"))) {
            formValidateErrors += "CPF inválido.\n";
            return false;
        }
        if (verifyEmail(document.getElementById("cliente-email"))) {
            return false;
        }
        if (!document.getElementById("date").value.match(/^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/)) {
            alertOn("A data de nascimento do cliente é inválida.");
            return false;
        }
        if (!document.getElementById("celular").value.match(/^\(\d{2}\)\d{4,5}\-\d{4,5}$/)) {
            alertOn("O número do celular informado é inválido.");
            return false;
        }
        if (document.getElementById("cob-cep").value.length != 9) {
            alertOn("O CEP do endereço de cobrança é inválido.");
            return false;
        }
        if (!document.getElementById("cob-uf").value.match(/^[A-Z]{2}$/)) {
            alertOn("O estado do endereço de cobrança é inválido.");
            return false;
        }
        if (!document.getElementById('checkout-same-address').checked) {
            if (document.getElementById("ent-cep").value.length != 9) {
                alertOn("O CEP do endereço de entrega é inválido.");
                return false;
            }
            if (!document.getElementById("ent-uf").value.match(/^[A-Z]{2}$/)) {
                alertOn("O estado do endereço de entrega é inválido.");
                return false;
            }
        }
    }
    return true;
}

function sendForm() {
    if (validateForm()) {
        $gn.submit();
    }
}

function alertOff() {
    document.getElementById("validation-alert").style.display = "none";
}

function alertOn(message) {
    document.getElementById("validation-alert").style.display = "block";
    document.getElementById("text-validation-alert").innerHTML = message;
}
