function format(mask, field) {
    var i = field.value.length;
    var output = mask.substring(0, 1);
    var text = mask.substring(i)

    if (text.substring(0, 1) != output) {
        field.value += text.substring(0, 1);
    }

}

function verifyCPF(field) {
    var cpf = field.value;
    cpf = cpf.replace('.', '');
    cpf = cpf.replace('.', '');
    cpf = cpf.replace('-', '');

    var i;
    var dv = cpf.substr(9, 2);
    var sum = 0;
    var rest = 0;
    var result = true;
    var cpfInvalid = ['00000000000', '11111111111', '22222222222', '33333333333', '44444444444', '55555555555', '66666666666', '77777777777', '88888888888', '99999999999'];

    for (i = 0; i < 9 && result; i++) {
        if (cpfInvalid[i] == cpf) {
            result = false;
        }
    }

    if (result) {
        // Verify first digit
        for (i = 0; i < 9; i++) {
            sum += cpf.charAt(i) * (10 - i);
        }

        rest = sum % 11;
        if (rest < 2 && dv.charAt(0) != 0) {
            result = false;
        } else {
            if (rest >= 2) {
                var d1 = 11 - rest;
                if (dv.charAt(0) != d1) {
                    result = false;
                }
            }
        }
    }

    if (result) {
        //Verify second digit
        sum = 0;
        for (i = 0; i < 10; i++) {
            sum += cpf.charAt(i) * (11 - i);
        }

        rest = sum % 11;
        if (rest < 2 && dv.charAt(1) != 0) {
            result = false;
        } else {
            if (rest >= 2) {
                d1 = 11 - rest;
                if (dv.charAt(1) != d1) {
                    result = false;
                }
            }
        }
    }
    if (result == false) {
        alertOn("O CPF digitado é inválido.");
        return false;
    }
    return true;
}

function maskCel( field ) {
	function format( value,  isOnBlur ) {
		value = value.replace(/\D/g,"");             			
		value = value.replace(/^(\d{2})(\d)/g,"($1)$2"); 		
		if( isOnBlur ) {
			value = value.replace(/(\d)(\d{4})$/,"$1-$2");   
		} else {
			value = value.replace(/(\d)(\d{3})$/,"$1-$2"); 
		}
		return value;
	}
	
	field.onkeypress = function (evt) {
		var code = (window.event) ? window.event.keyCode : evt.which;	
		var value = this.value;
		if(code > 57 || (code < 48 && code != 8 ))  {
			return false;
		} else {
			this.value = format(value, false);
		}
	}
	
	field.onblur = function() {
		var value = this.value;
		if( value.length < 13 ) {
			this.value = "";
		}else {		
			this.value = format( this.value, true );
		}
	}
	field.maxLength = 14;
}
