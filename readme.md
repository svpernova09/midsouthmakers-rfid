# MidsouthMakers RFID

[![Build Status](https://travis-ci.org/svpernova09/midsouthmakers-rfid.svg?branch=master)](https://travis-ci.org/svpernova09/midsouthmakers-rfid)



## API Endpoints

### POST `/api/login-attempt`

Post information about a keypad login attemp.

Body:

Successful Login:

```
{
    "key": 123456,
    "timestamp": 12345678,
    "reason": "success",
    "result": "success"
}
```

Failure Login

```
{
    "key": 123456,
    "timestamp": 12345678,
    "reason": "bad key || bad password",
    "result": "failure"
}
```

#### Response:

```
{
    "status": true
}
```

### GET `/api/members`

Retrieve records for all members. 
Data cached for 1 week. Cache busted every time a Member is saved or deleted.

#### Response:

```
{
  "timestamp": {
    "date": "2017-01-28 20:55:00.114552",
    "timezone_type": 3,
    "timezone": "UTC"
  },
  "members": [
    {
      "id": 1,
      "key": 55220,
      "hash": "$1$OSgsFlWE$79omYL8JCk0X0JLvREfjm1",
      "irc_name": "Rhianna Olson Sr.",
      "spoken_name": "Alena Kuhic DDS",
      "added_by": 4,
      "date_created": "2017-01-28 00:00:00",
      "last_login": "2017-01-28 00:00:00",
      "admin": 0,
      "active": 1,
      "created_at": "2017-01-28 20:41:00",
      "updated_at": "2017-01-28 20:41:00"
    }
```

### GET `/api/members/{id}`

Get a Member record by Id.

#### Response:

```
{
  "id": 1,
  "key": 55220,
  "hash": "$1$OSgsFlWE$79omYL8JCk0X0JLvREfjm1",
  "irc_name": "Rhianna Olson Sr.",
  "spoken_name": "Alena Kuhic DDS",
  "added_by": 4,
  "date_created": "2017-01-28 00:00:00",
  "last_login": "2017-01-28 00:00:00",
  "admin": 0,
  "active": 1,
  "created_at": "2017-01-28 20:41:00",
  "updated_at": "2017-01-28 20:41:00"
}
```

### GET `/api/users/{id}`

Get a member record by Id.

```
{
  "id": 1,
  "name": "Dr. Bessie Kuhlman",
  "email": "juvenal58@example.org",
  "admin": 0,
  "created_at": "2017-01-28 20:41:00",
  "updated_at": "2017-01-28 20:41:00"
}
```
