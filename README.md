
## Installation
```
docker run --rm --interactive --tty --volume ${PWD}:/app -u $(id -u ${USER}):$(id -g ${USER}) composer:2 install --no-ansi
```

## Test
```
docker run --rm --interactive --tty --volume ${PWD}:/app -u $(id -u ${USER}):$(id -g ${USER}) composer:2 ./vendor/bin/simple-phpunit
```

## Execution
```
docker run --rm --interactive --tty --volume ${PWD}:/app -u $(id -u ${USER}):$(id -g ${USER}) composer:2 php bin/console app:exploration-start
```

## Instructions

At the beginning you must enter which planet you want to explore and which explorer you want to send and the coordinates and position to land

After that you can execute all the commands after the prompt `>`

| Command       | Description |
|---------------|---|
| L             | Turn the explorer to the left  |
| R             | Turn the explorer to the right   |
| F             | The explorer move forward  |
| LRFFLFRFRRL   | Any combination of the movement commands  |
| NEW           | Start the process to create a new Mission  |
| MAP           | Show the visualization of the Planet included Obstacles and the Explorer  |
| HELP          | Show this information  |
| EXIT          | Exits the exploration  |

The information about the planets is in `configuration/planets.yaml`

The information about the explorers is in `configuration/explorers.yaml`

## Status mission control by http

NOTE: Right now doesn't work because the information is storage in memory

If you want to check the status of the mission you can execute:

```
docker run --rm --network host -p 8000:8000 --volume ${PWD}:/app -u $(id -u ${USER}):$(id -g ${USER}) composer:2 php -S localhost:8000 -t public
```

And then execute the next URL in your browser:

```
http://localhost:8000/status
```

## Improvements

- phpunit -> Check the events created
- phpunit -> Check the messages of the exceptions
- Create a UI to manage the mission control (see map of the Planet, move Explorer with arrows, ...)
- Make Obstacle abstract and create types of Obstacle like Hold, Rock, ...
- Add unique id to MissionControl in order to manage different MissionControl in the same execution
- Save MissionControl and Planet in a database (mysql?) in order to recover data between executions
- Create a new Bounded Context to build Explorers
- Create a new Bounded Context to find new Planets in the Universe
- Add features to Explorer (like detect new Obstacles) to personalize the behaviour of the different Explorers  
