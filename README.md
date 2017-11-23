# Cmptest

## Installation

In order to install the dependencies run the following command:

```
 $ composer install
```

## Usage

Going to

## Tests

In order to execute the test you will need phpunit.

```
$ vendor/bin/phpunit --stderr
```

## Next steps

If I would have had more time, I would do the following additional functionalities:

* Add dynamic profile pages depending on the user clicked.

* Use a div instead an input to make a multiline while user is typing.

* Add a key code to the session (db) in order to provide a multi-users chat. For example use the phone for a user session.

* Add a message type control, with an enum for example, and throw an exception when the message type is not correct.

* Add security injection when users sends a message to avoid scripts, etc

* More tests using the rights annotations such as @group, @after
