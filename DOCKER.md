# Docker Setup

## Services

- `mysql`: MySQL 8 on `localhost:3307`
- `backend`: Laravel API on `http://localhost:8000`
- `frontend`: Vue app on `http://localhost:5173`

## Run

```bash
docker compose up --build
```

## test

## Stop

```bash
docker compose down
```

## Notes

- Backend container auto-creates `.env` from `.env.example` if needed.
- Backend container runs migrations on startup.
- MySQL data persists in Docker volume `mysql_data`.
- Frontend reads API base URL from `VITE_API_BASE_URL`.
- Deployment to EC2 is handled by Ansible playbook `ansible/deploy.yml` in CI/CD.
- Kubernetes starter manifests are in `k8s/` (`k8s/README.md`).
