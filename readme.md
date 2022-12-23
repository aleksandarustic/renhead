# Renhead Task

## Installation Instructions

Make sure that ports 8890 and 3307 are available because docker-compose will use them.
You can set whole application by running this commands in this order

```sh
docker-compose up -d

docker-compose exec renhead composer install

docker-compose exec renhead php artisan migrate:fresh --seed
```
Insomnia and Postman collections are located in root of repository.
There is also openapi specifications in [openapi.json](https://github.com/aleksandarustic/renhead/blob/main/openapi.json) file

Base url: ``` http://localhost:8890  ```

## Users credentials

#### Non-approver
email: ```non_approver_1@gmail.com``` password: ```password```
#### Approver
email: ```approver_1@gmail.com``` password: ```password```

## About Application

Pagination is added to Payment and Travel Crud
It is worth mentioning that Payment and Travel Crud have following rules

- Non-approver can only fetch and make actions on his own payments and travel-payments

- Approver can fetch all payments and travel payments, but he can't perform delete, update on them 

Payment, TravelPayments, PaymentApprovals , Users are seeded.


| Method  | Url |  |
| ------------- | ------------- |------------- |
| POST  | /api/auth/login  | Login  |
| POST  | /api/auth/register  | Register  |
| GET  | /api/report  | Report  |
| POST  | /api/payments/{payment_id}/approve  | Approve/disapprove payment  |
| GET  | /api/payments  | List payments  |
| POST  | /api/payments  | Create payment  |
| GET  | /api/payments/{payment_id}  | Single payment  |
| PUT  | /api/payments/{payment_id}  | Update payment  |
| DELETE  | /api/payments/{payment_id}  | Delete payment  |
| POST  | /api/travel-payments/{payment_id}/approve  | Approve/disapprove travel payment  |
| GET  | /api/travel-payments  | List travel payments  |
| POST  | /api/travel-payments  | Create travel payment  |
| GET  | /api/travel-payments/{payment_id}  | Single travel payment  |
| PUT  | /api/travel-payments/{payment_id}  | Update travel payment  |
| DELETE  | /api/travel-payments/{payment_id}  | Delete travel payment  |




