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
[Get Postman Collection]({baseUrl}/docs/collection.json)

<!-- END_INFO -->

#Cart management


APIs for managing user cart
<!-- START_432cff2f8fe7f56638f911bbe734c9d7 -->
## Cart List for customer

[Insert optional longer description of the API endpoint here.]

> Example request:

```bash
curl -X GET \
    -G "{baseUrl}/api/customers/carts" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "{baseUrl}/api/customers/carts"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "status": false,
    "message": "Invalid Token"
}
```

### HTTP Request
`GET api/customers/carts`


<!-- END_432cff2f8fe7f56638f911bbe734c9d7 -->

<!-- START_aeb2d9ca0ef2f3ce4fa41b12a5782f88 -->
## Add to cart

> Example request:

```bash
curl -X POST \
    "{baseUrl}/api/customers/carts" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"store_id":9,"prod_id":6,"price":7.109,"qty":2}'

```

```javascript
const url = new URL(
    "{baseUrl}/api/customers/carts"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "store_id": 9,
    "prod_id": 6,
    "price": 7.109,
    "qty": 2
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/customers/carts`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `store_id` | integer |  required  | the store_id of the post
        `prod_id` | integer |  required  | the product id is required for the post
        `price` | float |  required  | the price is required for the post
        `qty` | integer |  required  | the qty is required for the post
    
<!-- END_aeb2d9ca0ef2f3ce4fa41b12a5782f88 -->

<!-- START_49685a0d55cede5937b36a4714670899 -->
## Edit cart

> Example request:

```bash
curl -X POST \
    "{baseUrl}/api/customers/carts/1" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"qty":6}'

```

```javascript
const url = new URL(
    "{baseUrl}/api/customers/carts/1"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "qty": 6
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/customers/carts/{id}`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `qty` | integer |  optional  | float required the qty is required for the post
    
<!-- END_49685a0d55cede5937b36a4714670899 -->

<!-- START_4b931ab4b666f2da01878433c1e08fab -->
## delete cart

> Example request:

```bash
curl -X DELETE \
    "{baseUrl}/api/customers/carts/et" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "{baseUrl}/api/customers/carts/et"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/customers/carts/{id}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  optional  | int required the cart id is required of the post

<!-- END_4b931ab4b666f2da01878433c1e08fab -->

#Customer Management

Api for managing customers
<!-- START_25243cbe6690cae84fc14d2359b1b23a -->
## Customer signup/ Customer Registration

> Example request:

```bash
curl -X POST \
    "{baseUrl}/api/customers/signup" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"name":"ullam","phone":42609.9291,"email":"optio","address":"saepe","password":"veritatis"}'

```

```javascript
const url = new URL(
    "{baseUrl}/api/customers/signup"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "ullam",
    "phone": 42609.9291,
    "email": "optio",
    "address": "saepe",
    "password": "veritatis"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/customers/signup`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name` | string |  required  | Customer Full name
        `phone` | number |  required  | Phone number for registration, It is unique for everyone
        `email` | string |  required  | Email address of a customer
        `address` | string |  required  | Customer address
        `password` | strting |  required  | customer password for accout access
    
<!-- END_25243cbe6690cae84fc14d2359b1b23a -->

<!-- START_5d222af879941754145c8d95172a8874 -->
## Customer Login

> Example request:

```bash
curl -X POST \
    "{baseUrl}/api/customers/login" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"username":"soluta","password":"molestiae"}'

```

```javascript
const url = new URL(
    "{baseUrl}/api/customers/login"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "username": "soluta",
    "password": "molestiae"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/customers/login`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `username` | string |  required  | customer account phone number
        `password` | string |  required  | customer account password
    
<!-- END_5d222af879941754145c8d95172a8874 -->

<!-- START_13f628fc987c6068f54ac22aebf5799c -->
## api/customers/forgot-password
> Example request:

```bash
curl -X POST \
    "{baseUrl}/api/customers/forgot-password" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "{baseUrl}/api/customers/forgot-password"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/customers/forgot-password`


<!-- END_13f628fc987c6068f54ac22aebf5799c -->

<!-- START_4a71de99f911468b3e411adda609b713 -->
## api/customers/reset-password
> Example request:

```bash
curl -X POST \
    "{baseUrl}/api/customers/reset-password" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "{baseUrl}/api/customers/reset-password"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/customers/reset-password`


<!-- END_4a71de99f911468b3e411adda609b713 -->

<!-- START_53d7318c8dae3b2c032b6c692ba966f5 -->
## Customer OTP verified

> Example request:

```bash
curl -X POST \
    "{baseUrl}/api/customers/otp-verified" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"otp":"labore"}'

```

```javascript
const url = new URL(
    "{baseUrl}/api/customers/otp-verified"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "otp": "labore"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/customers/otp-verified`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `otp` | init |  optional  | 
    
<!-- END_53d7318c8dae3b2c032b6c692ba966f5 -->

<!-- START_086f80ba9e5ba5ed623d59cd441c6db2 -->
## api/customers/resent-otp
> Example request:

```bash
curl -X POST \
    "{baseUrl}/api/customers/resent-otp" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "{baseUrl}/api/customers/resent-otp"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/customers/resent-otp`


<!-- END_086f80ba9e5ba5ed623d59cd441c6db2 -->

#Order Management

This is order managent api for customer , agent and store
<!-- START_51f3f08cd47760d9815ae49219b37beb -->
## Order Create by customer

> Example request:

```bash
curl -X POST \
    "{baseUrl}/api/customers/orders" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "{baseUrl}/api/customers/orders"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/customers/orders`


<!-- END_51f3f08cd47760d9815ae49219b37beb -->

#Product Category management


APIs for managing store product category
<!-- START_c16472605edbbe9fb0979fe24fa2f11c -->
## Product Category list for store

> Example request:

```bash
curl -X GET \
    -G "{baseUrl}/api/stores/product-categories" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "{baseUrl}/api/stores/product-categories"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "status": false,
    "message": "Invalid Token"
}
```

### HTTP Request
`GET api/stores/product-categories`


<!-- END_c16472605edbbe9fb0979fe24fa2f11c -->

<!-- START_7f114412a5b9d6c696844a961745d576 -->
## Create Product Category for store

> Example request:

```bash
curl -X POST \
    "{baseUrl}/api/stores/product-categories" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"cat_name":"et","cat_img":"id","cat_desc":"enim"}'

```

```javascript
const url = new URL(
    "{baseUrl}/api/stores/product-categories"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "cat_name": "et",
    "cat_img": "id",
    "cat_desc": "enim"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/stores/product-categories`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `cat_name` | string |  required  | Cat name required for this post
        `cat_img` | file |  required  | Cat image required for this post
        `cat_desc` | string |  optional  | Category description
    
<!-- END_7f114412a5b9d6c696844a961745d576 -->

<!-- START_24445a3ac312309c11b9869d6ee209bc -->
## Edit Product Category for store

> Example request:

```bash
curl -X POST \
    "{baseUrl}/api/stores/product-categories/dolorem" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"cat_name":"aut","cat_img":"odit","cat_desc":"omnis"}'

```

```javascript
const url = new URL(
    "{baseUrl}/api/stores/product-categories/dolorem"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "cat_name": "aut",
    "cat_img": "odit",
    "cat_desc": "omnis"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/stores/product-categories/{id}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  optional  | int required Product category id required for this api
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `cat_name` | string |  required  | Cat name required for this post
        `cat_img` | file |  optional  | optinal Cat image required for this post
        `cat_desc` | string |  optional  | optional Category description
    
<!-- END_24445a3ac312309c11b9869d6ee209bc -->

<!-- START_154fdedb7f3703c6bf2e9138c7c4b327 -->
## Delete Product Category for store

> Example request:

```bash
curl -X DELETE \
    "{baseUrl}/api/stores/product-categories/enim" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "{baseUrl}/api/stores/product-categories/enim"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/stores/product-categories/{id}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  optional  | int required Product category id required for this post

<!-- END_154fdedb7f3703c6bf2e9138c7c4b327 -->

#Store Product Management


This api for store product management
<!-- START_4f60e6914375b0c6c3775d16fe64d9f2 -->
## Product list

> Example request:

```bash
curl -X GET \
    -G "{baseUrl}/api/stores/products" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "{baseUrl}/api/stores/products"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "status": false,
    "message": "Invalid Token"
}
```

### HTTP Request
`GET api/stores/products`


<!-- END_4f60e6914375b0c6c3775d16fe64d9f2 -->

<!-- START_ada9a748b0762a43faedc77b80cce3e7 -->
## Product add

> Example request:

```bash
curl -X POST \
    "{baseUrl}/api/stores/products" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"prod_name":"nesciunt","prod_cat_id":20,"prod_price":2910.552,"prod_delivery_time":7,"prod_img":"quo"}'

```

```javascript
const url = new URL(
    "{baseUrl}/api/stores/products"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "prod_name": "nesciunt",
    "prod_cat_id": 20,
    "prod_price": 2910.552,
    "prod_delivery_time": 7,
    "prod_img": "quo"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/stores/products`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `prod_name` | string |  required  | Product name
        `prod_cat_id` | integer |  required  | Product category name
        `prod_price` | float |  required  | Product price
        `prod_delivery_time` | integer |  required  | Product delivery time
        `prod_img` | file |  optional  | Product image
    
<!-- END_ada9a748b0762a43faedc77b80cce3e7 -->

<!-- START_dfecf853489faf2117897a93b0de6f45 -->
## api/stores/products/{id}
> Example request:

```bash
curl -X POST \
    "{baseUrl}/api/stores/products/1" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "{baseUrl}/api/stores/products/1"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/stores/products/{id}`


<!-- END_dfecf853489faf2117897a93b0de6f45 -->

<!-- START_0c2b1fce02ce0e0834cf1dfb934c0e24 -->
## api/stores/products/{id}
> Example request:

```bash
curl -X DELETE \
    "{baseUrl}/api/stores/products/1" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "{baseUrl}/api/stores/products/1"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/stores/products/{id}`


<!-- END_0c2b1fce02ce0e0834cf1dfb934c0e24 -->

<!-- START_b4b25ca0445c29242911687367f7b798 -->
## Product list

> Example request:

```bash
curl -X GET \
    -G "{baseUrl}/api/customers/products" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "{baseUrl}/api/customers/products"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "status": false,
    "message": "Invalid Token"
}
```

### HTTP Request
`GET api/customers/products`


<!-- END_b4b25ca0445c29242911687367f7b798 -->

#Store management


APIs for managing Store user
<!-- START_0c950d5f818a38db5751c081896cf760 -->
## Signup new store

> Example request:

```bash
curl -X POST \
    "{baseUrl}/api/stores/signup" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"name":"omnis","phone":17,"email":"placeat","address":"voluptas","lat":"delectus","lng":"veniam","password":"et"}'

```

```javascript
const url = new URL(
    "{baseUrl}/api/stores/signup"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "omnis",
    "phone": 17,
    "email": "placeat",
    "address": "voluptas",
    "lat": "delectus",
    "lng": "veniam",
    "password": "et"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/stores/signup`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name` | string |  required  | Name is required for store name
        `phone` | integer |  required  | Phone number is required for this api
        `email` | string |  required  | Email address is required for this api
        `address` | string |  required  | address is required for this api
        `lat` | string |  required  | Latitude is required for this api
        `lng` | string |  required  | Longitude is required for this api
        `password` | string |  required  | Password is required for this api
    
<!-- END_0c950d5f818a38db5751c081896cf760 -->

<!-- START_47c247fd69f528956ede09ae72e4abb7 -->
## SignIn store

> Example request:

```bash
curl -X POST \
    "{baseUrl}/api/stores/login" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"phone":13,"password":"id"}'

```

```javascript
const url = new URL(
    "{baseUrl}/api/stores/login"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "phone": 13,
    "password": "id"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/stores/login`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `phone` | integer |  required  | Phone number is required for this api
        `password` | string |  required  | Password is required for this api
    
<!-- END_47c247fd69f528956ede09ae72e4abb7 -->

<!-- START_854696d7c5c79609d8ca70ad11e4b3d3 -->
## Forgot password for store

> Example request:

```bash
curl -X POST \
    "{baseUrl}/api/stores/forgot-password" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"phone":"sunt"}'

```

```javascript
const url = new URL(
    "{baseUrl}/api/stores/forgot-password"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "phone": "sunt"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/stores/forgot-password`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `phone` | string |  required  | Phone number is required for this api
    
<!-- END_854696d7c5c79609d8ca70ad11e4b3d3 -->

<!-- START_eb60989480288c14a9834f44887143d1 -->
## Legal document upload for store

> Example request:

```bash
curl -X POST \
    "{baseUrl}/api/stores/doc-upload" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"address_prof":"perspiciatis","trade_licence":"asperiores","passport":"repellendus"}'

```

```javascript
const url = new URL(
    "{baseUrl}/api/stores/doc-upload"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "address_prof": "perspiciatis",
    "trade_licence": "asperiores",
    "passport": "repellendus"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/stores/doc-upload`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `address_prof` | image |  optional  | Address prof for store
        `trade_licence` | image |  optional  | Trade licence for store
        `passport` | image |  optional  | Passport
    
<!-- END_eb60989480288c14a9834f44887143d1 -->

<!-- START_990c6d24585f0252c01cabeae523f227 -->
## Store legal doc fetch api

> Example request:

```bash
curl -X GET \
    -G "{baseUrl}/api/stores/docs" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "{baseUrl}/api/stores/docs"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "status": false,
    "message": "Invalid Token"
}
```

### HTTP Request
`GET api/stores/docs`


<!-- END_990c6d24585f0252c01cabeae523f227 -->

<!-- START_f84972890ff041008cae6365e8d4c49a -->
## Resent OTP  for store

> Example request:

```bash
curl -X POST \
    "{baseUrl}/api/stores/resent-otp" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "{baseUrl}/api/stores/resent-otp"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/stores/resent-otp`


<!-- END_f84972890ff041008cae6365e8d4c49a -->

<!-- START_0621f0a32a2d5e39899218d691351eb4 -->
## Reset password for store

> Example request:

```bash
curl -X POST \
    "{baseUrl}/api/stores/reset-password" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"mode":"quaerat","otp":15,"new_pass":"atque","old_pass":"ut"}'

```

```javascript
const url = new URL(
    "{baseUrl}/api/stores/reset-password"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "mode": "quaerat",
    "otp": 15,
    "new_pass": "atque",
    "old_pass": "ut"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/stores/reset-password`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `mode` | enum(reset_pass,change_pass) |  required  | 
        `otp` | integer |  required  | (if:mode=reset_pass)
        `new_pass` | string |  required  | 
        `old_pass` | string |  required  | (if:mode=change_pass)
    
<!-- END_0621f0a32a2d5e39899218d691351eb4 -->

<!-- START_0d32427b5a91f18957faebd398978c30 -->
## OTP Verified for store

> Example request:

```bash
curl -X POST \
    "{baseUrl}/api/stores/otp-verified" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"otp":3}'

```

```javascript
const url = new URL(
    "{baseUrl}/api/stores/otp-verified"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "otp": 3
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/stores/otp-verified`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `otp` | integer |  required  | OTP is required for this api
    
<!-- END_0d32427b5a91f18957faebd398978c30 -->

<!-- START_e32428e8f228608a6f371279d7ebc435 -->
## Store search of a location

> Example request:

```bash
curl -X GET \
    -G "{baseUrl}/api/customers/stores" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"lat":39214.172,"lng":49009.927,"store_id":16,"cat_id":20}'

```

```javascript
const url = new URL(
    "{baseUrl}/api/customers/stores"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "lat": 39214.172,
    "lng": 49009.927,
    "store_id": 16,
    "cat_id": 20
}

fetch(url, {
    method: "GET",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "status": false,
    "error": {
        "lat": [
            "The lat field is required."
        ],
        "lng": [
            "The lng field is required."
        ]
    }
}
```

### HTTP Request
`GET api/customers/stores`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `lat` | float |  required  | Latitude required
        `lng` | float |  required  | Longitude required
        `store_id` | integer |  optional  | For specific store search
        `cat_id` | integer |  optional  | For category wise store search
    
<!-- END_e32428e8f228608a6f371279d7ebc435 -->

#User address management


APIs for managing user address
<!-- START_77e0058d7c92c52607dc92e8587a4a39 -->
## Get Address List

> Example request:

```bash
curl -X GET \
    -G "{baseUrl}/api/customers/address" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "{baseUrl}/api/customers/address"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "status": false,
    "message": "Invalid Token"
}
```

### HTTP Request
`GET api/customers/address`


<!-- END_77e0058d7c92c52607dc92e8587a4a39 -->

<!-- START_ff51a765f04b9150ae1130b9586f5ec1 -->
## Add new address

> Example request:

```bash
curl -X POST \
    "{baseUrl}/api/customers/address" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"title":"totam","address":"veniam","city":"qui","postcode":10,"state":"iste","lat":24.9124,"lng":42757.13477}'

```

```javascript
const url = new URL(
    "{baseUrl}/api/customers/address"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "title": "totam",
    "address": "veniam",
    "city": "qui",
    "postcode": 10,
    "state": "iste",
    "lat": 24.9124,
    "lng": 42757.13477
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/customers/address`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `title` | string |  required  | the title of the post
        `address` | string |  required  | the address is required for the post
        `city` | string |  required  | the city is required for the post
        `postcode` | integer |  required  | the postcode is required for the post
        `state` | string |  required  | the state is required for the post
        `lat` | float |  required  | the lat is required for the post
        `lng` | float |  required  | the lng is required for the post
    
<!-- END_ff51a765f04b9150ae1130b9586f5ec1 -->

<!-- START_000f58c9c4a99572b69a3f82663b8779 -->
## Delete Address

> Example request:

```bash
curl -X DELETE \
    "{baseUrl}/api/customers/address/nihil" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "{baseUrl}/api/customers/address/nihil"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/customers/address/{id}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  optional  | int required for this api

<!-- END_000f58c9c4a99572b69a3f82663b8779 -->

#general


<!-- START_86380c1b417f7083901e35f319bb6095 -->
## api/agents/signup
> Example request:

```bash
curl -X POST \
    "{baseUrl}/api/agents/signup" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "{baseUrl}/api/agents/signup"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/agents/signup`


<!-- END_86380c1b417f7083901e35f319bb6095 -->

<!-- START_7dffd1aad79e450d0553ad409c9d9fbb -->
## api/agents/login
> Example request:

```bash
curl -X POST \
    "{baseUrl}/api/agents/login" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "{baseUrl}/api/agents/login"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/agents/login`


<!-- END_7dffd1aad79e450d0553ad409c9d9fbb -->

<!-- START_2946272066c703bc4e625a45be728bf6 -->
## api/agents/forgot-password
> Example request:

```bash
curl -X POST \
    "{baseUrl}/api/agents/forgot-password" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "{baseUrl}/api/agents/forgot-password"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/agents/forgot-password`


<!-- END_2946272066c703bc4e625a45be728bf6 -->

<!-- START_e842771de661172dc31d9f3632093aba -->
## api/agents/reset-password
> Example request:

```bash
curl -X POST \
    "{baseUrl}/api/agents/reset-password" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "{baseUrl}/api/agents/reset-password"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/agents/reset-password`


<!-- END_e842771de661172dc31d9f3632093aba -->

<!-- START_0f6606d395e1898170a881a1a49ca7f1 -->
## api/agents/otp-verified
> Example request:

```bash
curl -X POST \
    "{baseUrl}/api/agents/otp-verified" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "{baseUrl}/api/agents/otp-verified"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/agents/otp-verified`


<!-- END_0f6606d395e1898170a881a1a49ca7f1 -->

<!-- START_377396358296c79d4dddd7e953200e64 -->
## api/agents/resent-otp
> Example request:

```bash
curl -X POST \
    "{baseUrl}/api/agents/resent-otp" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "{baseUrl}/api/agents/resent-otp"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/agents/resent-otp`


<!-- END_377396358296c79d4dddd7e953200e64 -->

<!-- START_109013899e0bc43247b0f00b67f889cf -->
## api/categories
> Example request:

```bash
curl -X GET \
    -G "{baseUrl}/api/categories" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "{baseUrl}/api/categories"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "status": true,
    "data": [
        {
            "id": 1,
            "category_name": "Grocery Shop",
            "category_desc": "Grocery Shop",
            "cover_photo": null
        },
        {
            "id": 2,
            "category_name": "Restaurant",
            "category_desc": "Restaurant",
            "cover_photo": null
        },
        {
            "id": 3,
            "category_name": "Wine Shop",
            "category_desc": "Wine Shop",
            "cover_photo": null
        }
    ]
}
```

### HTTP Request
`GET api/categories`


<!-- END_109013899e0bc43247b0f00b67f889cf -->

<!-- START_7e3072a9c6d43c05123a799823b02c6d -->
## api/docs
> Example request:

```bash
curl -X GET \
    -G "{baseUrl}/api/docs" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "{baseUrl}/api/docs"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "status": true,
    "data": [
        {
            "id": 1,
            "title": "Address Prof",
            "slug": "address_prof",
            "desc": "Address Prof",
            "user_type": "both"
        },
        {
            "id": 2,
            "title": "Trade Licence",
            "slug": "trade_licence",
            "desc": "Trade Licence",
            "user_type": "shop"
        },
        {
            "id": 3,
            "title": "Driving licence (front)",
            "slug": "driving_licence_front",
            "desc": "Driving licence ",
            "user_type": "agent"
        },
        {
            "id": 4,
            "title": "Driving licence (back)",
            "slug": "driving_licence_back",
            "desc": "Driving licence ",
            "user_type": "agent"
        },
        {
            "id": 5,
            "title": "Passport",
            "slug": "passport",
            "desc": "Passport",
            "user_type": "both"
        }
    ]
}
```

### HTTP Request
`GET api/docs`


<!-- END_7e3072a9c6d43c05123a799823b02c6d -->

<!-- START_182076825f5ecffd9a788b75e97f8002 -->
## api/changePhoneStatus
> Example request:

```bash
curl -X GET \
    -G "{baseUrl}/api/changePhoneStatus" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "{baseUrl}/api/changePhoneStatus"
);

let headers = {
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "status": true,
    "message": "Phone verification status has been changed successfully"
}
```

### HTTP Request
`GET api/changePhoneStatus`


<!-- END_182076825f5ecffd9a788b75e97f8002 -->


