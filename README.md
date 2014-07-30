# Configuração necessária no Ubuntu #

Para que funcione perfeitamente, é necessário adicionar o seguinte trecho em **/etc/apache2/sites-enabled/000-default.conf**:

```
<Directory /var/www/html>
    Options Indexes FollowSymLinks MultiViews
    AllowOverride All
    Order Allow,Deny
    Allow from all
</Directory>
```


Após a edição do arquivo, execute:

```
sudo service apache2 reload
```

Para o SQLite funcionar perfeitamente, deve-se instalar o php5-sqlite e, em seguida, reiniciar o apache:
```
sudo apt-get install php5-sqlite
sudo service apache2 restart
```

# Informações adicionais #

Este modelo de consumo do checkout transparente está utilizando a API de teste, portanto não serão realizados lançamentos na fatura do cartão de crédito do cliente. Também não serão enviados e-mails para os clientes com os dados da compra.

Para que seu código funcione serão necessárias algumas modificações:

1. Abrir uma conta Gerencianet em http://gerencianet.com.br/.

2. Logue na conta Gerencianet criada e vá em **Desenvolvedor >> Checkout Transparente** e copie o código javascript que será exibido. Cole o código na linha 15 do arquivo **checkout.php**.

3. Na conta Gerencianet, vá em **Desenvolvedor >> Token de Integração** e gere um token para sua conta. Copie este token e cole na linha 64 do arquivo **actions/do-checkout.php**.

Para mais informações sobre o checkout transparente, visite http://gerencianet.com.br/desenvolvedores/checkout.


# Observação #

**Esta lojinha é somente um exemplo de implementação do checkout transparente. Com isso, os produtos apresentados são apenas de exemplo. A Gerencianet não os oferece.**
