## About project

This project implements a service for passing the entrance exam to a programming school.
The architecture consists of three different microservices:
- Api service based on Laravel framework
- User page based on VueJS framework
- Admin page based on VueJS framework

## Deployment for local development

### Requirements

- Docker & Docker Compose

### Step by step

1. Clone this repository to your local machine
2. Go to `site/backend` directory, create `.env` file and copy contents from file `.env.example` 
3. Go to root directory of the project
4. Run command `docker-compose up`
5. After the build of the project is completed open `localhost:8080` in your browser
6. For stopping services use command `docker-compose down`

### Local links

- `http://localhost:8080` - User page
- `http://localhost:8080/admin/` - Admin page
- `htto://localhost:8081` - Database adminer