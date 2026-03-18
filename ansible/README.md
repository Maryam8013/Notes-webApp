# Ansible Deploy

This folder deploys the Notes stack to EC2 using Docker Compose.

## Local run

```bash
ansible-playbook -i "<EC2_HOST>," ansible/deploy.yml \
  -u <EC2_USER> \
  --private-key <PATH_TO_KEY> \
  -e backend_image=ghcr.io/<owner>/notes-backend:sha-<sha> \
  -e frontend_image=ghcr.io/<owner>/notes-frontend:sha-<sha> \
  -e app_key=<APP_KEY> \
  -e jwt_secret=<JWT_SECRET> \
  -e app_url=http://<EC2_HOST>:8000 \
  -e frontend_url=http://<EC2_HOST>:5173
```

## Notes

- CI/CD already calls this playbook from `.github/workflows/cicd.yml`.
- Deployment directory on EC2 defaults to `~/notes-app`.
