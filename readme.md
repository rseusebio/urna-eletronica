# Urna eletronica - Uma simples implementação

Simulação simples de uma urna eletrônica.

### Topicos:
- [Como executar localmente](#Como-executar-localmente)
- [Servidor PHP](#Servidor-PHP)
- [Frontend da Urna](#Frontend-da-Urna)
- [Backoffice Resultado da eleicao](#Backoffice-Resultado-da-eleicao)
- [Documentacao da API](#Documentacao-da-API)

## Como executar localmente

Para executar este projeto localmente baster ter o docker e docker-compose instalados. 
Com esses requisitos, apenas executa o seguinte comando na raiz deste diretório.

```bash
docker-compose up -d --build
```

Para derrubar a aplicação basta executar o seguinte comando:

```bash
docker-compose down
```

O serviços estarão disponíveis na seguinte porta:
 - servidor PHP : localhost:8080/vote
 - Front da urna : localhost:8081
 - backoffice da eleicao : localhost:8082
  
## Servidor PHP

 - O codigo se encontra dentro da pasta public/
 - na pasta public/src/ temos dois arquivos:
   - Database.php (com a função de acesso ao database)
   - Vote.php (com a função de processamento das chamadas ao serviço)


## Frontend da Urna

- O Codigo do frontend da urna se encontra na past `frontend/`
- Não é de minha autoria.
- Exceto a função `vote` no arquivo `frontend/js/util.js`.


## Backoffice Resultado da eleicao

 - O Codigo do backoffice da urna se encontra na past `backoffice/`
 - O código foi feito em react e se encontra na pasta `backoffice/src`.
 - O build foi feito localmente e está na pasta  `backoffice/build`.
 - Para executar fora do ambiente docker é preciso instalar o node e npm e fazer:
   -   `npm install` seguindo de `npm start`.
   -   
## Documentacao da API

### Pega o status da eleicao

#### GET http://localhost:8080/status
#### GET http://3.83.161.213:8080/status

Response 
```json
{
    "status": true,
    "text": "Aberta"
}
```


### Abre as eleicoes

#### GET http://localhost:8080/open
#### GET http://3.83.161.213:8080/open

Response 
```json
{
    "status": "1",
    "text": "Aberta"
}
```


### Fecha as eleicoes (não é possivel alterar os votos depois)

#### GET http://localhost:8080/close
#### GET http://3.83.161.213:8080/close

Response 
```json
{
    "status": "0",
    "text": "Fechada"
}
```



### Retorna os votos e dados dos prefeitos e vereadores

#### GET http://localhost:8080/vote
#### GET http://3.83.161.213:8080/vote

Response 
```json
{
    "prefeitos": [
        {
            "ID": "0",
            "Titulo": "prefeito",
            "Nome": "BRANCO",
            "Partido": "",
            "Foto": "",
            "Votos": "0",
            "Vice": ""
        },
        {
            "ID": "-1",
            "Titulo": "prefeito",
            "Nome": "NULO",
            "Partido": "",
            "Foto": "",
            "Votos": "0",
            "Vice": ""
        },
        {
            "ID": "12",
            "Titulo": "prefeito",
            "Nome": "Chiquinho do Adbon",
            "Partido": "PDT",
            "Foto": "cp3.jpg",
            "Votos": "0",
            "Vice": "{\"nome\": \"Aru00e3o\", \"partido\": \"PRP\", \"foto\": \"v3.jpg\"}"
        },
        {
            "ID": "15",
            "Titulo": "prefeito",
            "Nome": "Malrinete Gralhada",
            "Partido": "MDB",
            "Foto": "cp2.jpg",
            "Votos": "0",
            "Vice": "{\"nome\": \"Biga\", \"partido\": \"MDB\", \"foto\": \"v2.jpg\"}"
        },
        {
            "ID": "45",
            "Titulo": "prefeito",
            "Nome": "Dr. Francisco",
            "Partido": "PSC",
            "Foto": "cp1.jpg",
            "Votos": "0",
            "Vice": "{\"nome\": \"Jou00e3o Rodrigues\", \"partido\": \"PV\", \"foto\": \"v1.jpg\"}"
        },
        {
            "ID": "54",
            "Titulo": "prefeito",
            "Nome": "Ze Lopes",
            "Partido": "PPL",
            "Foto": "cp4.jpg",
            "Votos": "0",
            "Vice": "{\"nome\": \"Francisca Ferreira Ramos\", \"partido\": \"PPL\", \"foto\": \"v4.jpg\"}"
        },
        {
            "ID": "65",
            "Titulo": "prefeito",
            "Nome": "Lindomar Pescador",
            "Partido": "PC do B",
            "Foto": "cp5.jpg",
            "Votos": "0",
            "Vice": "{\"nome\": \"Malu\", \"partido\": \"PC do B\", \"foto\": \"v5.jpg\"}"
        }
    ],
    "vereadores": [
        {
            "ID": "0",
            "Titulo": "vereador",
            "Nome": "BRANCO",
            "Partido": "",
            "Foto": "",
            "Votos": "0",
            "Vice": ""
        },
        {
            "ID": "-1",
            "Titulo": "vereador",
            "Nome": "NULO",
            "Partido": "",
            "Foto": "",
            "Votos": "0",
            "Vice": ""
        },
        {
            "ID": "51222",
            "Titulo": "vereador",
            "Nome": "Christianne Varao",
            "Partido": "PEN",
            "Foto": "cv1.jpg",
            "Votos": "0",
            "Vice": "{}"
        },
        {
            "ID": "55555",
            "Titulo": "vereador",
            "Nome": "Homero do Ze Filho",
            "Partido": "PSL",
            "Foto": "cv2.jpg",
            "Votos": "0",
            "Vice": "{}"
        },
        {
            "ID": "43333",
            "Titulo": "vereador",
            "Nome": "Dandor",
            "Partido": "PV",
            "Foto": "cv3.jpg",
            "Votos": "0",
            "Vice": "{}"
        },
        {
            "ID": "15123",
            "Titulo": "vereador",
            "Nome": "Filho",
            "Partido": "MDB",
            "Foto": "cv4.jpg",
            "Votos": "0",
            "Vice": "{}"
        },
        {
            "ID": "27222",
            "Titulo": "vereador",
            "Nome": "Joel Varao",
            "Partido": "PSDC",
            "Foto": "cv5.jpg",
            "Votos": "0",
            "Vice": "{}"
        },
        {
            "ID": "45000",
            "Titulo": "vereador",
            "Nome": "Professor Clebson Almeida",
            "Partido": "PSDB",
            "Foto": "cv6.jpg",
            "Votos": "0",
            "Vice": "{}"
        }
    ]
}
```



### Salva o voto

#### POST http://localhost:8080/vote/:v_id/:p_id
#### POST http://3.83.161.213:8080/vote/:v_id/:p_id

O valor 0 em qualquer um dos dois parametros vota BRANCO.
O valor -1 ou qualquer outro não encontrado nos dois parametros vota NULO.

exemplo: localhost:8080/vote/51222/65

Response 
```json
{
    "vereador": {
        "politician": {
            "ID": "51222",
            "Titulo": "vereador",
            "Nome": "Christianne Varao",
            "Partido": "PEN",
            "Foto": "cv1.jpg",
            "Votos": "1",
            "Vice": "{}"
        },
        "rowsUpdated": 1,
        "success": true
    },
    "prefeito": {
        "politician": {
            "ID": "65",
            "Titulo": "prefeito",
            "Nome": "Lindomar Pescador",
            "Partido": "PC do B",
            "Foto": "cp5.jpg",
            "Votos": "1",
            "Vice": "{\"nome\": \"Malu\", \"partido\": \"PC do B\", \"foto\": \"v5.jpg\"}"
        },
        "rowsUpdated": 1,
        "success": true
    }
}
```



### Zera todas as eleicoes e abre para votos

#### GET http://localhost:8080/reset
#### GET http://3.83.161.213:8080/reset

Response 
```json
{
    "resetRows": 2
}
```