---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost/docs/collection.json)
<!-- END_INFO -->

#general
<!-- START_c394d72c2a7456a820c66f068b86c884 -->
## api/consultant_registration

> Example request:

```bash
curl -X GET "http://localhost/api/consultant_registration" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/consultant_registration",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": {
        "message": "No data found",
        "status_code": 404
    }
}
```

### HTTP Request
`GET api/consultant_registration`

`HEAD api/consultant_registration`


<!-- END_c394d72c2a7456a820c66f068b86c884 -->

<!-- START_be66bb400353f9ee460e0ed7100e7f0c -->
## api/consultant_registration/create

> Example request:

```bash
curl -X GET "http://localhost/api/consultant_registration/create" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/consultant_registration/create",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "token_not_provided"
}
```

### HTTP Request
`GET api/consultant_registration/create`

`HEAD api/consultant_registration/create`


<!-- END_be66bb400353f9ee460e0ed7100e7f0c -->

<!-- START_1ab115c037016ee450355d104cbb208d -->
## To create new consultant

> Example request:

```bash
curl -X POST "http://localhost/api/consultant_registration" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/consultant_registration",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/consultant_registration`


<!-- END_1ab115c037016ee450355d104cbb208d -->

<!-- START_741ff70b00800397795e680dab2b65a4 -->
## Get one consultant row if exist

> Example request:

```bash
curl -X GET "http://localhost/api/consultant_registration/{consultant_registration}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/consultant_registration/{consultant_registration}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "token_not_provided"
}
```

### HTTP Request
`GET api/consultant_registration/{consultant_registration}`

`HEAD api/consultant_registration/{consultant_registration}`


<!-- END_741ff70b00800397795e680dab2b65a4 -->

<!-- START_32215c718a7185e32389e3a71b76e174 -->
## api/consultant_registration/{consultant_registration}/edit

> Example request:

```bash
curl -X GET "http://localhost/api/consultant_registration/{consultant_registration}/edit" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/consultant_registration/{consultant_registration}/edit",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "token_not_provided"
}
```

### HTTP Request
`GET api/consultant_registration/{consultant_registration}/edit`

`HEAD api/consultant_registration/{consultant_registration}/edit`


<!-- END_32215c718a7185e32389e3a71b76e174 -->

<!-- START_feb9b99fa71c2ed349e5ba8edd6003ce -->
## To update specific consultant

> Example request:

```bash
curl -X PUT "http://localhost/api/consultant_registration/{consultant_registration}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/consultant_registration/{consultant_registration}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT api/consultant_registration/{consultant_registration}`

`PATCH api/consultant_registration/{consultant_registration}`


<!-- END_feb9b99fa71c2ed349e5ba8edd6003ce -->

<!-- START_130315b954c57c0619c7f1b5be20dbe9 -->
## api/consultant_registration/{consultant_registration}

> Example request:

```bash
curl -X DELETE "http://localhost/api/consultant_registration/{consultant_registration}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/consultant_registration/{consultant_registration}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE api/consultant_registration/{consultant_registration}`


<!-- END_130315b954c57c0619c7f1b5be20dbe9 -->

<!-- START_6e8a975e54e9aff666ac6c158cf89f5f -->
## Insert fake data for test process

> Example request:

```bash
curl -X GET "http://localhost/api/consultant_registration_insert_fake_data" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/consultant_registration_insert_fake_data",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "token_not_provided"
}
```

### HTTP Request
`GET api/consultant_registration_insert_fake_data`

`HEAD api/consultant_registration_insert_fake_data`


<!-- END_6e8a975e54e9aff666ac6c158cf89f5f -->

<!-- START_4a6a89e9e0eaea9c72ceea57315f2c42 -->
## Login method  for authenticate user

> Example request:

```bash
curl -X POST "http://localhost/api/authenticate" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/authenticate",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/authenticate`


<!-- END_4a6a89e9e0eaea9c72ceea57315f2c42 -->

<!-- START_d60ad1114f6b4ea7f109fa117db8b340 -->
## api/authenticate/user

> Example request:

```bash
curl -X GET "http://localhost/api/authenticate/user" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/authenticate/user",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "error": "token_not_provided"
}
```

### HTTP Request
`GET api/authenticate/user`

`HEAD api/authenticate/user`


<!-- END_d60ad1114f6b4ea7f109fa117db8b340 -->

<!-- START_90f45d502fd52fdc0b289e55ba3c2ec6 -->
## api/signup

> Example request:

```bash
curl -X POST "http://localhost/api/signup" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/signup",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/signup`


<!-- END_90f45d502fd52fdc0b289e55ba3c2ec6 -->

