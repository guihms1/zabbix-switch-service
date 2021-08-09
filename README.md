# Zabbix Switch Service
>Zabbix Switch Service is a small API built with PHP and Laravel. This application complements the Zabbix ecosystem, bringing all the needed information about switchs and their vLAN data in real-time.

## Requirements

- Docker
- docker-compose

## Installing

To install the application and be able to use it, you should follow the steps below:

1. Clone the repository from github:
```
git clone https://github.com/guihms1/zabbix-switch-service.git
```

2. Access the project folder, make a copy of  the .env.example file, then rename it to .env:
```
cd zabbix-switch-service
cp .env.example .env
```

3. Now, let's build our Dockerfile through the docker-compose:
```shell
# To run this command make sure that you are in the project folder

# To change between dev and production environment
# just change the word "dev" to "production", after ".docker"

docker-compose -f .docker/dev/docker-compose.yml up --build -d
```
> It's good to know that the application is **purposefully small and simple**, so when whe change between dev and production environments, the only thing that is affected is the volume mapping that enable us to develop directly from the docker container.

4. If the docker container was built successfully, we can check if it all is working following this last step:

 - Open your browser and try to access the address http://localhost. If the application was installed successfully, the message "It works!" should appear in the screen.

## Documentation

You can find the initial documentation [here](https://guihms1.stoplight.io/docs/zabbix-switch-service/YXBpOjE3MjQ0NzY2-zabbix-switch-api). It's not completed, but you should be able to use the service provided after reading this doc.

## Tests

The tests and how to execute them will be here soon.

## Supported brands

Actually this application only works with the **Datacom** switches, but we hope it can change soon.

## How it works behind the scenes
To connect and get all the data the monitoring services need, we use the [ssh2](https://www.php.net/manual/pt_BR/book.ssh2.php) library.

In this first version, this library was implemented with their basics functionalities, these functionalities able us to **connect**, **authenticate**, **execute commands**, **get the output data**, **get the output errors** and **disconnect** from a **SSH Server**.
