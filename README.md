# Casafy API

Requirements for this project:
* Docker
* Docker-compose

_PS: Tested in a Mac environment._

To run this project, you should clone this repository.
```bash
git clone https://github.com/lucascavalcante/backend_test.git
```
Into the folder.
```bash
cd backend_test
```
Change the branch.
```bash
git checkout lucas-test
```
Build and startup the docker containers.
```
docker-compose up -d --build
```
After finish docker operations, you should run database operations.
```
./db.sh
```
_PS: You should give to this file, permission to execution._ (`chmod +x db.sh`)

If everything went well, you can access the URL.
```
http://127.0.0.1:8001/api
```

## Endpoints available

```
Users

GET api/users
POST api/users
GET api/users/{userId}
PUT api/users/{userId}
DELETE api/users/{userId}
GET api/users/{userId}/properties

Properties

GET api/properties
POST api/properties
GET api/properties/{propertyId}
PUT api/properties/{propertyId}
DELETE api/properties/{propertyId}
PATCH api/properties/{propertyId}/purchased/{value}
```

## Data formats

To add or update an user
```
{
	"name": "John Doe",
	"email": "john@doe.com"
}
```

To add or update an address
```
{
	"address": "123, Main Street",
	"bedrooms": 3,
	"bathrooms": 2,
	"total_area": 322,
	"value": 100585.00,
	"discount": 20,
	"owner_id": 2
}
```

## Tests

To run the tests.
```
docker exec -it casafy-app php artisan test
```
_PS: After run the tests, the database will be resetted._
