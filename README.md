# Stamp API

API server for the digital stamp card service.

## Environment
You should refer [Stamp Backend](https://github.com/jumakall/stamp-backend) on how to setup the correct environment for the API server.

## Setup
To setup the API server, you need to install dependencies, configure environment variables and run the database migrations. Start by cloning the repository to the correct location specified in the environment and then proceed to below.

### Install dependencies
Since the environment uses Docker, we are going to utilize it also when installing dependencies. The following command should do the job for you.
```
docker run --rm --interactive --tty \
    --volume $PWD:/app \
    composer install
```

### Configure environment variables
Take the ``.env.example`` file and make a copy of it called ``.env``. The ``APP_KEY`` is the most important, it should be 32 characters long random string. You may also wish to change ``APP_ENV``, ``APP_DEBUG`` and ``APP_URL`` depending on your environment.

### Run the database migrations
The last step is to run database migrations. For this you should have the environment up and running. In the environment's root directory, run ``docker-compose exec php php ../artisan migrate``.

## API request documentation
Available [here](https://documenter.getpostman.com/view/8164635/SW7W5VFj).
