# API for iOS app on VTB hackathon


## ![available](https://cdn4.iconfinder.com/data/icons/sketchdock-ecommerce-icons/ok-green.png) **addAccount**
> Adding a virtual account;  

### HTTP request  

 - **POST** /mobile-api/account/add  

### Parameters  

Name | Type | Required | Description
------------- | ------------- | -------------  | ------------- 
 **type** | **integer** | **Yes** | Device type 1-Android; 2-iOS; 
 **push_token** | **string** | **No** | Firebase cloud messaging push token;

### HTTP request headers  

 - **Accept**: application/json  
 - **Content-Type**: application/json   

### Request example  

POST `http://127.0.0.1:8000/mobile-api/account/add`
```
{
	"type": 2,
	"push_token": "e8S8tTljQ5w:APA91bGZKdRR-nHTIwqy60OIH21vgM3WqCji6v7fvf6MTaJd1RP1w_WC7MsqW4dxkIRnQwz4enm15BlC3xt-sopAQk4rJp3Tb4jZKLS42GgUAgUVLatYYbz73pp_gNfqSpsg6G20UJdc"
}
```

### Response example  

```
{
  "status": "success",
  "sessionId": "6671d112-3579-4857-8eac-d08dd9b38004"
}
```

-------------------------
## ![available](https://cdn4.iconfinder.com/data/icons/sketchdock-ecommerce-icons/ok-green.png) **getAccountInfo**
> Get info about virtual account;  

### HTTP request  

 - **GET** /mobile-api/account/info/{sessionId}  

### Parameters  

Name | Type | Required | Description
------------- | ------------- | -------------  | ------------- 
 **sessionId** | **string** | **Yes** | Session od from addAccount response. 

### HTTP request headers  

 - **Accept**: application/json  
 - **Content-Type**: application/json   

### Request example  

GET `http://127.0.0.1:8000/mobile-api/account/info/6671d112-3579-4857-8eac-d08dd9b38004`

### Response example  

```
{
  "status": "success",
  "data": {
    "id": 27,
    "device_id": "dc36699179e667934d2e",
    "device_type": 2,
    "session_id": "6671d112-3579-4857-8eac-d08dd9b38004",
    "account_number": "34444777c294e1e8657aa6068ee3090f8e300faa",
    "push_token": "e8S8tTljQ5w:APA91bGZKdRR-nHTIwqy60OIH21vgM3WqCji6v7fvf6MTaJd1RP1w_WC7MsqW4dxkIRnQwz4enm15BlC3xt-sopAQk4rJp3Tb4jZKLS42GgUAgUVLatYYbz73pp_gNfqSpsg6G20UJdc",
    "deleted": false,
    "last_active_at": "2019-09-15 10:43:13",
    "created_at": "2019-09-15 10:43:13"
  }
}
```

-------------------------
## ![available](https://cdn4.iconfinder.com/data/icons/sketchdock-ecommerce-icons/ok-green.png) **getAllAccounts**
> Get list of all virtual accounts;  

### HTTP request  

 - **GET** /mobile-api/accounts/list  

### Parameters  

**None**

### HTTP request headers  

 - **Accept**: application/json  
 - **Content-Type**: application/json   

### Request example  

GET `http://127.0.0.1:8000/mobile-api/accounts/list`

### Response example  

```
{
  "status": "success",
  "data": [
    {
      "id": 17,
      "device_id": "b82d95961b1eb9886178",
      "device_type": 2,
      "session_id": "ab0e0bdb-7a22-4db5-bbcc-1a77b5d0bafe",
      "account_number": "a9eb5169ada8ad3923bc64d370ffca7e5619a04c",
      "created_at": "2019-09-15 00:38:32"
    },
    {
      "id": 12,
      "device_id": "9acddb9b276bb242a228",
      "device_type": 2,
      "session_id": "99a9cc31-84a7-47f5-8f69-bd00dc91a35a",
      "account_number": "b29de584e7022238bb2d3c4d790e435cbc5faa59",
      "created_at": "2019-09-14 22:02:27"
    },
    ...
  ]
}
```

-------------------------
## ![available](https://cdn4.iconfinder.com/data/icons/sketchdock-ecommerce-icons/ok-green.png) **makeInvoice**
> Get info about virtual account;  

### HTTP request  

 - **POST** /mobile-api/invoice/make  

### Parameters  

Name | Type | Required | Description
------------- | ------------- | -------------  | ------------- 
 **amount** | **integer** | **Yes** |  
 **items** | **array** | **Yes** | 
 **currencyCode** | **integer** | **Yes** | 
 **description** | **string** | **Yes** | 
 **payer** | **string** | **Yes** | 
 **recipient** | **string** | **Yes** | 
 **sessionId** | **string** | **Yes** | 
 **nameCheque** | **string** | **Yes** | 
 **datePayCheque** | **string** | **Yes** | 

### HTTP request headers  

 - **Accept**: application/json  
 - **Content-Type**: application/json   

### Request example  

POST `http://127.0.0.1:8000/mobile-api/invoice/make`
```
{
	"amount": 10000,
	"items": [
		{
			"price": 6000,
			"name": "Position 1",
			"selected" : false
		},
		{
			"price": 1000,
			"name": "Position 2",
			"selected" : false
		},
		{
			"price": 3000,
			"name": "Position 3",
			"selected" : true
		}
	],
	"currencyCode": 810,
	"description": "test",
	"payer": "f2bead373b32dfe107d35a8c1d1d24108a67e892",
	"recipient": "2a9fb79f-b7e4-471e-a498-aa9a7bfc0525",
	"sessionId": "7289ec99-7916-472c-b56d-ae8864b53f54",
	"nameCheque": "ООО МАКДОНАЛДС",
  "datePayCheque": "2019-09-13T21:14:00"
}
```

### Response example  

```
{
  "status": "success",
  "number": "b3172f1c-d78b-11e9-a50c-0cc47a75a680"
}
```

-------------------------
## ![available](https://cdn4.iconfinder.com/data/icons/sketchdock-ecommerce-icons/ok-green.png) **getInvoiceInfo**
> Get information about created invoice;  

### HTTP request  

 - **GET** /mobile-api/invoice/info/{number}  

### Parameters  

Name | Type | Required | Description
------------- | ------------- | -------------  | ------------- 
 **number** | **string** | **Yes** | Invoice number from makeInvoice response. 

### HTTP request headers  

 - **Accept**: application/json  
 - **Content-Type**: application/json   

### Request example  

GET `http://127.0.0.1:8000/mobile-api/invoice/info/b3172f1c-d78b-11e9-a50c-0cc47a75a680`

### Response example  

```
{
  "status": "success",
  "data": {
    "number": "0b36e540-d780-11e9-be95-8c1645e90d4c",
    "currencyCode": 810,
    "amount": 10000,
    "description": "test",
    "recipient": "1003a8ea371fa1c582cb6f158f8c8be7cf17cba3",
    "payer": "1002a8ea371fa1c582cb6f158f8c8be7cf17cba2",
    "state": 2,
    "created": 1568528056860,
    "updated": 0,
    "owner": "263093b1c21f98c5f9b6433bf9bbb97bb87b6e79",
    "errorCode": 0,
    "items": [
      {
        "price": 6000,
        "name": "Position 1",
        "selected": true
      },
      {
        "price": 1000,
        "name": "Position 2",
        "selected": true
      },
      {
        "price": 3000,
        "name": "Position 3",
        "selected": false
      }
    ],
    "date_pay_cheque": "2019-09-13T21:14:00",
    "name_cheque": "ООО МАКДОНАЛДС"
  }
}
```


-------------------------
## ![available](https://cdn4.iconfinder.com/data/icons/sketchdock-ecommerce-icons/ok-green.png) **getAccountInvoices**
> Get list of opened invoices from virtual accounts;  

### HTTP request  

 - **GET** /mobile-api/account/{sessionId}/invoices/list  

### Parameters  

Name | Type | Required | Description
------------- | ------------- | -------------  | ------------- 
 **sessionId** | **string** | **Yes** | Session od from addAccount response. 

### HTTP request headers  

 - **Accept**: application/json  
 - **Content-Type**: application/json   

### Request example  

GET `http://127.0.0.1:8000/mobile-api/account/ccf619e5-f1a8-466b-93a1-7a1e23bae5ec/invoices/list`

### Response example  

```
{
  "status": "success",
  "data": [
    {
      "amount": 1000,
      "currency_code": 810,
      "description": "teetee",
      "number": "b556ce38-d720-11e9-9468-8c1645e90d4c",
      "payer": "1002a8ea371fa1c582cb6f158f8c8be7cf17cba2",
      "recipient": "1003a8ea371fa1c582cb6f158f8c8be7cf17cba3",
      "tx_id": "0947d3e4564c10db31d55f3575c1b3a1823fbc3d377d3fdb9fbbf5ed88a3e2e3",
      "status_code": null,
      "created_at": "2019-09-14 21:51:51"
    },
    ...
  ]
}
```

-------------------------
## ![available](https://cdn4.iconfinder.com/data/icons/sketchdock-ecommerce-icons/ok-green.png) **payInvoice**
> Pay invoice method;  

### HTTP request  

 - **POST** /mobile-api/invoice/pay  

### Parameters  

Name | Type | Required | Description
------------- | ------------- | -------------  | ------------- 
 **amount** | **integer** | **Yes** |  
 **currencyCode** | **integer** | **Yes** | 
 **description** | **string** | **Yes** | 
 **sessionId** | **string** | **Yes** |  
 **recipient** | **string** | **Yes** | 

### HTTP request headers  

 - **Accept**: application/json  
 - **Content-Type**: application/json   

### Request example  

POST `http://127.0.0.1:8000/mobile-api/invoice/make`
```
{
	"amount": 1000,
	"currencyCode": 810,
	"description": "teetee",
	"number": "f625c064-d73d-11e9-854b-0cc47a75a680",
	"recipient": "1003a8ea371fa1c582cb6f158f8c8be7cf17cba3",
	"sessionId": "99a9cc31-84a7-47f5-8f69-bd00dc91a35a"
}
```

### Response example  

```
{
  "status": "success",
  "data": {
    "amount": 1000,
    "currencyCode": 810,
    "description": "teetee",
    "number": "f625c064-d73d-11e9-854b-0cc47a75a680",
    "recipient": "1003a8ea371fa1c582cb6f158f8c8be7cf17cba3"
  }
}
```
