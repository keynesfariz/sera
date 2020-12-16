# Lumen Post CRUD API using Multiple Database Connection

This is an example of CRUD API implementation using multiple database and *Repository Design Pattern*. A small set of unit test examples are also included.

### Prerequisite things to do
- Create a ```.env``` file in the root directory using the example file ```.env.example```
- Setup your Firebase Project and MongoDB Database, then put it in the ```.env```

### Used Database Connection
- Firebase Firestore ```firestore```
- Firebase Realtime Database ```realtime```
- MongoDB ```mongodb```

### API End Points
There are five endpoints in this repo to perform CRUD operation :
- **Get All Posts** - Retrieve all posts from database
**GET** ```api-url.test/api/v1/{database}/posts```
Example Response :
```json
{
    "status": 1,
    "message": "Success",
    "total": 1,
    "data": [
        {
            "id": "dc21e1ad-30cb-4b72-89ab-63823e104a10",
            "body": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
            "created_at": "2020-12-15 22:51:10",
            "title": "Updated (again) Post Title",
            "update_at": "2020-12-15 22:51:28"
        }
    ]
}
```
- **Get a Post by ID** - Retrieve a single post from database using its ID
**GET** ```api-url.test/api/v1/{database}/posts/{id}```
Example Response :
```json
{
    "status": 1,
    "message": "Success",
    "data": {
        "id": "dc21e1ad-30cb-4b72-89ab-63823e104a10",
        "body": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
        "created_at": "2020-12-15 22:51:10",
        "title": "Updated (again) Post Title",
        "updated_at": "2020-12-15 22:51:28"
    }
}
```
- **Create a New Post**
**POST** ```api-url.test/api/v1/{database}/posts```
Request Body (JSON) :
```json
{
    "title": "Post Title",
    "body": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
}
```
Example Response :
```json
{
    "status": 1,
    "message": "A post has been created",
    "data": {
        "id": "fd0eac71-44cf-41c7-a9fb-adc505bb7416",
        "body": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
        "created_at": "2020-12-16 01:50:15",
        "title": "Post Title",
        "updated_at": "2020-12-16 01:50:15"
    }
}
```
- **Update an Existing Post** - Update a post using its ID
**PUT** ```api-url.test/api/v1/{database}/posts/{id}```
Request Body (JSON) :
```json
{
    "title": "Post Title Updated",
    "body": "Post Body Updated."
}
```
Example Response :
```json
{
    "status": 1,
    "message": "Post updated",
    "data": {
        "id": "ed458fac-7910-49ee-9cba-e7f76df9c74b",
        "body": "Post Body Updated.",
        "created_at": "2020-12-16 01:50:58",
        "title": "Post Title Updated",
        "updated_at": "2020-12-16 01:51:33"
    }
}
```
- **Delete an Existing Post** Delete a post using its ID
**DELETE** ```api-url.test/api/v1/{database}/posts/{id}```
Example Response :
```json
{
    "status": 1,
    "message": "Post deleted"
}
```

The ```{database}``` should be replaced with corresponding database connection available. For example if you're about to use **Firebase Firestore** to get all the posts, then the API end point becomes ```api-url.test/api/v1/firestore/posts```

### Unit Test
Run this command to test **Get All Posts API**, **Get a Post by ID API**, and **Create a New Post API**
```sh
$ vendor/bin/phpunit
```
