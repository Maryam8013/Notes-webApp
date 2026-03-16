# Notes App Backend (Laravel)

This folder contains the Laravel API for the Notes app.

## Local Development (PHP)

1. Create `.env` from `.env.example` if needed.
2. Set DB values for your local MySQL or Docker MySQL.
3. Run:

```powershell
php artisan serve
```

## Docker (Local)

From the repo root:

```powershell
docker-compose up -d mysql
```

## GHCR Images

We publish backend and frontend images to GHCR. The recommended tag format is the git commit SHA:

- `ghcr.io/maryam8013/notes-backend:sha-<commit>`
- `ghcr.io/maryam8013/notes-frontend:sha-<commit>`

Latest published commit tag:

- `sha-3b40d9e169058b4cb3fa39d142995ae08ac3a052`

To build and push (from repo root):

```powershell
docker build -t ghcr.io/maryam8013/notes-backend:sha-<commit> -f notes-backend/Dockerfile notes-backend
docker build -t ghcr.io/maryam8013/notes-frontend:sha-<commit> -f notes-frontend/Dockerfile notes-frontend
docker push ghcr.io/maryam8013/notes-backend:sha-<commit>
docker push ghcr.io/maryam8013/notes-frontend:sha-<commit>
```
