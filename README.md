[![Laravel][laravel-shield]][ref-laravel]
[![PHP][php-shield]][ref-php]
[![MySQL][mysql-shield]][ref-mysql]
[![JWT][jwt-shield]][ref-jwt]
[![Composer][composer-shield]][ref-composer]
[![Docker][docker-shield]][ref-docker]
[![Git][git-shield]][ref-git]

# Challenge FaleMais (Laravel 10 version)

*WORK IN PROGRESS*

## Challenge description

**English**

The fictional telephone company *VxTel*, specialized in national long distance calls, will put a new product on the market called **FaleMais**. Normally a VxTel customer can make a call from one city to another paying a fixed rate per minute, with the price being pre-defined in a list with the origin and destination *DDD* codes:

| Origin | Destination | R$/min |
|---| --- | ---|
| 011 | 016 | 1,90 |
| 016 | 011 | 2,90 |
| 011 | 017 | 1,70 |
| 017 | 011 | 2,70 |
| 011 | 018 | 0,90 |
| 018 | 011 | 1,90 |

With VxTel's new FaleMais product, the customer purchases a plan and can speak for free up to a certain time (in minutes) and only pays for the excess minutes. Excess minutes have a 10% increase over the normal minute rate. The plans are *FaleMais 30* (30 minutes), *FaleMais 60* (60 minutes) and *FaleMais 120* (120 minutes).

VxTel, concerned about transparency with its customers, wants to provide a web page where the customer can calculate the cost of the call. There, the customer can choose the codes for the cities of origin and destination, the call time in minutes and choose the FaleMais plan. The application must show two values: (1) the call value with the plan and (2) without the plan. The initial cost of acquiring the plan must be disregarded for this problem.

Example of values:

| Origin | Destination | Time | FaleMais Plan | With FaleMais | Without FaleMais |
| ------ | ------ | ------ | ------ | ------ | ------ |
| 011 | 016 | 20 | FaleMais 30 | R$ 0,00 | R$ 38,00 |
| 011 | 017 | 80 | FaleMais 60 | R$ 37,40 | R$ 136,00 |
| 018 | 011 | 200 | FaleMais 120 | R$ 167,20 | R$ 380,00 |

The objective of the challenge is to provide an API that allows the simulation of call values following the proposed rules.

The following points must be taken into consideration during development:

- Use of framework *features*
- Object orientation
- Application architecture/internal design
- Tests
- Code clarity and organization
- API must be easy to use

The monetary values present in the example tables are in *Real*, the current currency of Brazil.

*DDD* means *Direct Distance Dialing* and is an automatic telephone call system between different urban areas in Brazil through the insertion of prefixes, always with 3 digits.

**Portuguese/Português**

A empresa de telefonia fictícia *VxTel*, especializada em chamadas de longa distância nacional, vai colocar um novo produto no mercado chamado **FaleMais**. Normalmente um cliente VxTel pode fazer uma chamada de uma cidade para outra pagando uma tarifa fixa por minuto, com o preço sendo pré-definido em uma lista com os códigos *DDDs* de origem e destino:

| Origem | Destino | R$/min |
|---| --- | ---|
| 011 | 016 | 1,90 |
| 016 | 011 | 2,90 |
| 011 | 017 | 1,70 |
| 017 | 011 | 2,70 |
| 011 | 018 | 0,90 |
| 018 | 011 | 1,90 |

Com o novo produto FaleMais da VxTel o cliente adquire um plano e pode falar de graça até um determinado tempo (em minutos) e só paga os minutos excedentes. Os minutos excedentes tem um acrescimo de 10% sobre a tarifa normal do minuto. Os planos são *FaleMais 30* (30 minutos), *FaleMais 60* (60 minutos) e *FaleMais 120* (120 minutos).

A VxTel, preocupada com a transparência junto aos seus clientes, quer disponibilizar uma página na web onde o cliente pode calcular o valor da ligação. Ali, o cliente pode escolher os códigos das cidades de origem e destino, o tempo da ligação em minutos e escolher qual o plano FaleMais. O sistema deve mostrar dois valores: (1) o valor da ligação com o plano e (2) sem o plano. O custo inicial de aquisição do plano deve ser desconsiderado para este problema.

Exemplo de valores:

| Origem | Destino | Tempo | Plano FaleMais | Com FaleMais | Sem FaleMais |
| ------ | ------ | ------ | ------ | ------ | ------ |
| 011 | 016 | 20 | FaleMais 30 | R$ 0,00 | R$ 38,00 |
| 011 | 017 | 80 | FaleMais 60 | R$ 37,40 | R$ 136,00 |
| 018 | 011 | 200 | FaleMais 120 | R$ 167,20 | R$ 380,00 |

O objetivo do desafio é disponibilizar uma API que permita a simulação de valores da ligação seguindo as regras propostas.

Os seguintes pontos devem ser levados em consideração durante o desenvolvimento:

- Uso de *features* do framework
- Orientação a objeto
- Arquitetura/Design interno da aplicação
- Testes
- Clareza e organização do código
- Facilidade de uso da API

Os valores monetários presentes nas tabelas de exemplo estão em *Real*, a moeda atual do Brasil.

*DDD* significa *Discagem Direta à Distância* e é um sistema de ligação telefônica automática entre diferentes àreas urbanas do Brasil por meio da inserção de prefixos, sempre com 3 dígitos.

## Built with

| Name       | Version  |
| ---------- | -------- |
| Laravel | v10.x + |
| PHP | v8.2.x + |
| Docker | v20.10.x + |
| Docker Compose | v3.8.x + |
| MySQL | v8.0.x |

## Docs

* [Answering the challenge](./docs/answering_challenge.md)
* [Getting started](./docs/getting_started.md)
* [Using the API](./docs/using_api.md)
* [Database](./docs/database.md)

<!-- Badge Shields -->
[laravel-shield]: https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white
[php-shield]: https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white
[mysql-shield]: https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white
[jwt-shield]: https://img.shields.io/badge/JWT-black?style=for-the-badge&logo=JSON%20web%20tokens
[composer-shield]: https://img.shields.io/badge/Composer-885630?style=for-the-badge&logo=composer&logoColor=white
[docker-shield]: https://img.shields.io/badge/docker-%230db7ed.svg?style=for-the-badge&logo=docker&logoColor=white
[git-shield]: https://img.shields.io/badge/git-%23F05033.svg?style=for-the-badge&logo=git&logoColor=white

<!-- References -->
[ref-laravel]: https://laravel.com/docs/10.x/readme
[ref-php]: https://www.php.net
[ref-mysql]: https://www.mysql.com
[ref-jwt]: https://jwt.io
[ref-composer]: https://getcomposer.org
[ref-docker]: https://www.docker.com
[ref-git]: https://git-scm.com
