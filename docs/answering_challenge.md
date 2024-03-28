# Answering the challenge

**English**

### Database and architecture

When analyzing the scope of the challenge, the viability of creating *fare* and *plan* entities was identified, which provide essential information for calculating call prices. By storing them in a database, we guarantee the possibility of future editions and inclusions, facilitating subsequent expansions of the system's scope. Therefore, it was decided to use **MySQL** to persist the data required by the application.

To build the API it was used **Laravel**, an *open source* **PHP** framework whose objective is to allow the developer to work more quickly and effectively, with a greater focus on the development of business rules and less on architecture and configuration issues. Among the framework *features* used we can mention the *requests classes*, which perform validation of received data, and the models built with *Eloquent*, a powerful ORM (Object Relational Mapper) that is already built into Laravel by default.

Regarding the architecture, it was decided to distribute the code in different domain folders, an idea inspired by DDD (Domain Driven Design) concepts. In this way, domain folders were generated for "callprice", "common", "fare", "plan", "simulation" and "user", and the business logic was divided between them aiming for better organization.

In addition, the **service pattern** and **repository pattern** design patterns were also adopted with the aim of having a division between the business rule, data manipulation and data presentation layers, allowing for greater separation of responsibilities and facilitating the reuse of code snippets, thus respecting the DRY (Don't Repeat Yourself) approach.

### API explanation

One of the points of attention raised in the description of the challenge is the need to have an easy-to-use API. For this reason, an endpoint was defined for simulating the call value using the following structure:

```
POST {{baseUrl}}/call-prices/simulate
Accept: {{accept}}
Content-Type: {{contentType}}
Authorization: Bearer {{accessToken}}

{
    "ddd_origin": "011",
    "ddd_destination": "016",
    "call_minutes": 20,
    "plan_id": 1
}
```

Only 4 fields are required for the simulation: *DDD origin*, *DDD destination*, *call time* and *plan ID*. The endpoint returns, as requested by the challenge, the price of the call with the plan and the price of the call without the plan according to the parameters received. You can use the table of values referred to in the challenge description to carry out the simulations. The same is replicated below:

| Origin | Destination | Time | FaleMais Plan | With FaleMais | Without FaleMais |
| ------ | ------ | ------ | ------ | ------ | ------ |
| 011 | 016 | 20 | FaleMais 30 | R$ 0,00 | R$ 38,00 |
| 011 | 017 | 80 | FaleMais 60 | R$ 37,40 | R$ 136,00 |
| 018 | 011 | 200 | FaleMais 120 | R$ 167,20 | R$ 380,00 |

The DDDs are used to find out which fare will be used, and for this application only the fares present in the challenge description were registered and replicated as it follows.

| Origin | Destination | R$/min |
|---| --- | ---|
| 011 | 016 | 1,90 |
| 016 | 011 | 2,90 |
| 011 | 017 | 1,70 |
| 017 | 011 | 2,70 |
| 011 | 018 | 0,90 |
| 018 | 011 | 1,90 |

The list of all fares has its own endpoint within the application.

```
GET {{baseUrl}}/fares
Accept: {{accept}}
Content-Type: {{contentType}}
Authorization: Bearer {{accessToken}}
```

The plan is used to find out how much free call time is available. There is also an endpoint to display the list of all available plans.

```
GET {{baseUrl}}/plans
Accept: {{accept}}
Content-Type: {{contentType}}
Authorization: Bearer {{accessToken}}
```

### Security

Regarding API security, route protection was used with the requirement to send an access token in the header of all requests. The application provides a default user to use and a route for generating tokens. Details about this route can be found in the *API documentation*.

Although nothing in this regard was requested in the challenge description, it was considered valid to include some type of protection for the API.

### Environment

In order to avoid problems with divergent environments on different machines, all the application code was included in containers created with the **Docker** tool.

### Tests

The application tests, important for controlling expected behaviors and detecting flow failures, were built using *PHPUnit*. If you want to know more details about how to run them, you can refer to the **Running Tests** topic on the following [page](using_api.md).

### API documentation

To create the API documentation it was used the [Scribe](https://scribe.knuckles.wtf/laravel/), a package specialized in generating documentation with a more humanized language from the source code of *Laravel* or *Lumen* applications.

You can access the API documentation via the following URL:

```
http://localhost:9999/api-docs
```

Remember to launch the application before trying to access the API documentation page.

**Portuguese/Português**

### Banco de dados e arquitetura

Ao analisar o escopo do desafio, foi identificada a viabilidade de criar as entidades *tarifa* e *plano*, as quais fornecem informações essenciais para o cálculo do preço das ligações. Ao armazená-las em um banco de dados garantimos a possibilidade de futuras edições e inclusões, facilitando expansões posteriores do escopo do sistema. Assim, foi decidido utilizar o **MySQL** para a persistência dos dados requeridos pela aplicação.

Para a construção da API foi utilizado o **Laravel**, um framework *open source* de **PHP** cujo objetivo é permitir que o desenvolvedor trabalhe de forma mais rápida e eficaz, com um foco maior no desenvolvimento das regras de negócio e menor em questões de arquitetura e configurações. Dentre as *features* do framework utilizadas podemos citar as *classes requests*, que realizam validação de dados recebidos, e os models construídos com *Eloquent*, um poderoso ORM (Object Relational Mapper) que já vêm embutido no Laravel por padrão.

Com relação a arquitetura foi decidido efetuar uma distribuição do código em diferentes pastas de domínio, uma ideia inspirada em conceitos do DDD (Domain Driven Design). Desta maneira foram gerados pastas de domínio para "callprice", "common", "fare", "plan", "simulation" e "user", e a lógica do negócio foi dividida entre elas objetivando uma melhor organização. 

Além disso também foram adotados os padrões de projeto **service pattern** e **repository pattern** com o intuito de ter uma divisão entre as camadas de regra de negócio, de manipulação de dados e de apresentação de dados, permitindo uma maior separação de responsabilidades e facilitando a reutilização de trechos de códigos, respeitando, desta forma, a abordagem do DRY (Don’t Repeat Yourself).

### Explicação da API

Um dos pontos de atenção levantados na descrição do desafio é a necessidade de se ter uma API de fácil uso. Por esse motivo foi definido um endpoint para a simulação do valor da ligação utilizando a seguinte estrutura:

```
POST {{baseUrl}}/call-prices/simulate
Accept: {{accept}}
Content-Type: {{contentType}}
Authorization: Bearer {{accessToken}}

{
    "ddd_origin": "011",
    "ddd_destination": "016",
    "call_minutes": 20,
    "plan_id": 1
}
```

Apenas 4 campos são necessários para a simulação: *DDD de origem*, *DDD de destino*, *tempo de ligação* e *ID do plano*. O endpoint retorna, conforme solicitado pelo desafio, o preço da ligação com o plano e o preço da ligação sem o plano de acordo com os parâmetros recebidos. Você pode utilizar a tabela de valores referidas na descrição do desafio para realizar as simulações. A mesma é replicada a seguir:

| Origem | Destino | Tempo | Plano FaleMais | Com FaleMais | Sem FaleMais |
| ------ | ------ | ------ | ------ | ------ | ------ |
| 011 | 016 | 20 | FaleMais 30 | R$ 0,00 | R$ 38,00 |
| 011 | 017 | 80 | FaleMais 60 | R$ 37,40 | R$ 136,00 |
| 018 | 011 | 200 | FaleMais 120 | R$ 167,20 | R$ 380,00 |

Os DDDs são utilizados para descobrir qual tarifa será utilizada, sendo que para esta aplicação foram cadastradas apenas as tarifas presentes na descrição do desafio e replicadas a seguir.

| Origem | Destino | R$/min |
|---| --- | ---|
| 011 | 016 | 1,90 |
| 016 | 011 | 2,90 |
| 011 | 017 | 1,70 |
| 017 | 011 | 2,70 |
| 011 | 018 | 0,90 |
| 018 | 011 | 1,90 |

A lista de todas as tarifas possui um endpoint próprio dentro da aplicação.

```
GET {{baseUrl}}/fares
Accept: {{accept}}
Content-Type: {{contentType}}
Authorization: Bearer {{accessToken}}
```

Já o plano é utilizado para saber quanto tempo de ligação grátis está disponível. Também existe um endpoint para exibir a lista de todos os planos disponíveis.

```
GET {{baseUrl}}/plans
Accept: {{accept}}
Content-Type: {{contentType}}
Authorization: Bearer {{accessToken}}
```

### Segurança

Com relação a segurança da API, foi utilizada uma proteção das rotas com a exigência de envio de um token de acesso no cabeçalho de todas as requisições. A aplicação fornece um usuário padrão para uso e uma rota para geração de tokens. Detalhes sobre esta rota podem ser obtidos na *documentação da API*.

Embora não tenha sido solicitado nada nesse sentido na descrição do desafio, foi considerado válido incluir algum tipo de proteção para a API.

### Ambiente

Visando evitar problemas de divergência de ambientes em diferentes máquinas, todo o código da aplicação foi incluído em containers criados com a ferramenta **Docker**.

### Testes

Os testes da aplicação, importantes para controle de comportamentos esperados e detecção de falhas de fluxo, foram construídos usando o *PHPUnit*. Caso queira saber mais detalhes sobre como executá-los, você pode se referir ao tópico **Rodando Testes** na seguinte [página](using_api.md).

### Documentação da API

Para a criação da documentação da API foi utilizado o [Scribe](https://scribe.knuckles.wtf/laravel/), um package especializado em gerar documentações com uma linguagem mais humanizada a partir do código-fonte de aplicações *Laravel* ou *Lumen*.

Você pode acessar a documentação da API através da seguinte URL:

```
http://localhost:9999/api-docs
```

Lembre-se de iniciar a aplicação antes de tentar acessar a página da documentação da API.
