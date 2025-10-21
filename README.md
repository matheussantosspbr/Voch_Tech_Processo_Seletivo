## Passos para o funcionamento do sistema <br/>

Eu ultilizei o xampp para ultilizar o MySQL, acesse esse site para o download ou use uma de sua preferrencia: <br/>
Link <a href="https://www.apachefriends.org/pt_br/download.html">Apache Friends - Xampp</a>

Abra o Terminal:<br/>
1- `git clone https://github.com/matheussantosspbr/Voch_Tech_Processo_Seletivo.git`

2- `cd Voch_Tech_Processo_Seletivo`

3- `code .`

4- Renomeio o arquivo `.env.example` para `.env`

5- Crie um banco de dados chamado `voch_tech`

6- no terminal digite `composer install`

7- `php artisan migrate`

8- `npm install` e logo após `npm run build`

9- Digite `php artisan serve`

10- Abra no navegador `http://127.0.0.1:8000`

E pronto, ja está pronto para usar o sistema.
