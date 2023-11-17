window.addEventListener("load", function() {
    $('#cep').blur(function () {
        var cep = $(this).val().replace(/\D/g, '');
        if (cep) {
            $.getJSON(`https://viacep.com.br/ws/${cep}/json/`, function (data) {
                if (!data.erro) {
                    $('#country').val('Brasil');
                    $('#state').val(data.uf);
                    $('#city').val(data.localidade);
                    $('#street').val(data.logradouro);
                    $('#number').focus();
                }
            });
        }
    });
    $('#cep').mask('00000-000');
    $('#cpf').mask('000.000.000-00', { reverse: true });
    $('#birthdate').mask('00/00/0000');
    $('#state').mask('AA');
});

$('#preco').mask('000.000.000,00', {reverse: true});